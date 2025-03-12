<?php


/////////////////
///
///
use Rubix\ML\CrossValidation\Metrics\MeanAbsoluteError;
use Rubix\ML\CrossValidation\Metrics\RMSE;
use Rubix\ML\CrossValidation\Metrics\RSquared;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Datasets\Unlabeled;
use Rubix\ML\Extractors\CSV;
use Rubix\ML\Regressors\Ridge;
use Rubix\ML\Transformers\MinMaxNormalizer;
use Rubix\ML\Transformers\ZScaleStandardizer;


// Load and prepare the dataset
//echo "Loading dataset...\n";
$extractor = new CSV(dirname(__FILE__) . '/data/houses3.csv', false);
$samples = [];
$labels = [];

// Manually parse the CSV to ensure numeric types
foreach ($extractor->getIterator() as $row) {
    // Get price (last column) as the label
    $label = (float) array_pop($row);

    // Convert all feature values to float
    $sample = array_map('floatval', $row);
    $samples[] = $sample;
    $labels[] = $label;
}

//ddd($labels);

// Feature names (for display)
$featureNames = ['bedrooms', 'bathrooms', 'sqft', 'lot_size', 'year_built','days_on_market','proximity_to_transit','crime_rate', 'school_rating','neighborhood_rating'];

// Create labeled dataset
$dataset = new Labeled($samples, $labels);

// Randomize the dataset
$dataset = $dataset->randomize();
echo "General info\n";
echo "Total dataset size: " . $dataset->numSamples() . " samples\n\n";

//// Debug: Print sample data types to verify all are numeric
//if ($dataset->numSamples() > 0) {
//    $sampleData = $dataset->samples()[0];
//    echo "Sample data types verification:\n";
//    foreach ($sampleData as $i => $value) {
//        $featureName = isset($featureNames[$i]) ? $featureNames[$i] : "Feature $i";
//        echo "$featureName: " . gettype($value) . " (value: $value)\n";
//    }
//}

// Use regular split instead of stratified split (which is for classification)
$trainSize = 0.8 * $dataset->numSamples();
$trainSize = (int) $trainSize;
$testSize = $dataset->numSamples() - $trainSize;

// Split manually
$samples = $dataset->samples();
$labels = $dataset->labels();

$trainingSamples = array_slice($samples, 0, $trainSize);
$trainingLabels = array_slice($labels, 0, $trainSize);
$testingSamples = array_slice($samples, $trainSize, $testSize);
$testingLabels = array_slice($labels, $trainSize, $testSize);

$training = new Labeled($trainingSamples, $trainingLabels);
$testing = new Labeled($testingSamples, $testingLabels);

echo 'Training samples: ' . $training->numSamples() . PHP_EOL;
echo 'Testing samples: ' . $testing->numSamples() . PHP_EOL;

// Calculate mean price for baseline comparison
$meanPrice = array_sum($trainingLabels) / count($trainingLabels);
echo 'Mean price in training data: $' . number_format($meanPrice, 2) . PHP_EOL;

// Normalize the features for better model convergence
echo "Normalizing features...\n";
$normalizer = new MinMaxNormalizer();

// Create an unlabeled dataset for fitting the normalizer
$unlabeledTraining = new Unlabeled($training->samples());
$normalizer->fit($unlabeledTraining);

// Apply the normalizer to training and testing data
$normalizedTrainingSamples = $training->samples();
//$normalizer->transform($normalizedTrainingSamples);
$normalizedTraining = new Labeled($normalizedTrainingSamples, $training->labels());

$normalizedTestingSamples = $testing->samples();
//$normalizer->transform($normalizedTestingSamples);
$normalizedTesting = new Labeled($normalizedTestingSamples, $testing->labels());

// Debug: Print sample data types to verify all are numeric
if ($normalizedTraining->numSamples() > 0) {
    $sampleData = $normalizedTraining->samples()[0];
    echo "Sample data types verification:\n";
    foreach ($sampleData as $i => $value) {
        $featureName = isset($featureNames[$i]) ? $featureNames[$i] : "Feature $i";
        echo "$featureName: " . gettype($value) . " (value: $value)\n";
    }
}

// Create baseline predictions (just the mean)
$baselinePredictions = array_fill(0, count($testingLabels), $meanPrice);

// Calculate baseline metrics
$rmseMetric = new RMSE();
$baselineRMSE = $rmseMetric->score($baselinePredictions, $testingLabels);
echo "Baseline RMSE (using mean price): $" . number_format(abs($baselineRMSE), 2) . PHP_EOL;

$r2Metric = new RSquared();
$baselineR2 = $r2Metric->score($baselinePredictions, $testingLabels);
echo "Baseline R^2 (using mean price): " . number_format($baselineR2, 4) . PHP_EOL;


// Try different alpha values for Ridge regression
$alphaValues = [0.0001, 0.001, 0.01, 0.1, 1.0, 10.0, 100.0, 1000.0];
$bestAlpha = 0.0001;
$bestRMSE = PHP_FLOAT_MAX;
$bestR2 = -PHP_FLOAT_MAX;
$bestMAE = PHP_FLOAT_MAX;
$bestEstimator = null;

//echo "\nTuning alpha parameter for Ridge regression...\n";
//foreach ($alphaValues as $alpha) {
//    // Set up Ridge regression with L2 regularization
//    $estimator = new Ridge(
//        $alpha, // alpha (regularization strength)
//        false // normalize (set to false since we already normalized)
//    );
//
//    // Train the model
//    echo "Training with alpha = $alpha...\n";
//    try {
//        $estimator->train($normalizedTraining);
//
//        // Make predictions on the test set
//        $predictions = $estimator->predict($normalizedTesting);
//
//        // Calculate metrics
//        $rmseMetric = new RMSE();
//        $rmse = $rmseMetric->score($predictions, $testingLabels);
//
//        $r2Metric = new RSquared();
//        $r2 = $r2Metric->score($predictions, $testingLabels);
//
//        $maeMetric = new MeanAbsoluteError();
//        $mae = $maeMetric->score($predictions, $testingLabels);
//
//        echo "Alpha = $alpha: RMSE = $" . number_format(abs($rmse), 2) .
//            ", R^2 = " . number_format($r2, 4) .
//            ", MAE = $" . number_format(abs($mae), 2) . PHP_EOL;
//
//        // Track best model based on R^2
//        if ($r2 > $bestR2) {
//            $bestAlpha = $alpha;
//            $bestRMSE = $rmse;
//            $bestR2 = $r2;
//            $bestMAE = $mae;
//            $bestEstimator = $estimator;
//        }
//    } catch (Exception $e) {
//        echo "\nError during training with alpha = $alpha: " . $e->getMessage() . "\n";
//        continue;
//    }
//}


//// Report best model
//echo "\nBest model performance with alpha = $bestAlpha:\n";
//echo 'RMSE: $' . number_format(abs($bestRMSE), 2) . PHP_EOL;
//echo 'R^2: ' . number_format($bestR2, 4) . PHP_EOL;
//echo 'Mean Absolute Error: $' . number_format(abs($bestMAE), 2) . PHP_EOL;
//echo 'Improvement over baseline: ' . number_format(abs($baselineRMSE) - abs($bestRMSE), 2) . ' RMSE' . PHP_EOL;
//




echo "\n----------------\n\n";

// Standardize features
$standardizer = new ZScaleStandardizer();
$standardizer->fit($dataset);
$sss = $dataset->samples();
$standardizer->transform($sss);

// Different alpha values to try
//$alphaValues = [0.1, 1.0, 10.0, 100.0, 1000.0];
//$alphaValues = [0.0001];
//$alpha = $bestEstimator;

// Create Ridge regressor
$ridge = new Ridge($bestAlpha, false); // alpha, normalize=false (already standardized)

// Train the model
$ridge->train($dataset);

// Get coefficients
$coefficients = $ridge->coefficients();

// Print results
echo "Ridge Regression (alpha=$bestAlpha):\n";
foreach ($coefficients as $i => $coefficient) {
    echo $featureNames[$i] . ': ' . number_format($coefficient, 4) . PHP_EOL;
}

// Example homes for prediction
$exampleHomes = [
    // 2 bed, 1 bath, small older home
    [2.0, 1.0, 1000.0, 3500.0, 1965.0, 60.0, 9.0, 3.5, 6.5, 7.0],
    // 3 bed, 2 bath, medium-sized newer home
    [3.0, 2.0, 2000.0, 6000.0, 2010.0, 30.0, 8.0, 3.0, 8.0, 8.0],
    // 5 bed, 3.5 bath, large luxury home
    [5.0, 3.5, 3500.0, 12000.0, 2018.0, 15.0, 6.5, 2.0, 9.0, 9.0]
];
// Create descriptions for the homes
$homeDescriptions = [
    "Small home (2 bed, 1 bath, 1000 sqft, built 1965)",
    "Medium home (3 bed, 2 bath, 2000 sqft, built 2010)",
    "Luxury home (5 bed, 3.5 bath, 3500 sqft, built 2018)",
];

// Standardize examples
$exampleDataset = new Labeled($exampleHomes, [0, 0, 0]); // Dummy labels
$ssss = $exampleDataset->samples();
$standardizer->transform($ssss);

// Make predictions
$predictions = $ridge->predict($exampleDataset);

echo "\nPredictions for example homes:\n";
foreach ($predictions as $i => $prediction) {
    echo $homeDescriptions[$i] . ": $" . number_format($prediction, 2) . PHP_EOL;
}

//////////////
// Simple implementation of Lasso using soft thresholding

// Use the custom Lasso implementation
echo "\n----------------\n\n";

echo "Custom Lasso Implementation:\n";

// Extract standardized features and labels
$X = $dataset->samples();
$y = $dataset->labels();

// Run Lasso
$coefficients = simpleLasso($X, $y, $bestAlpha);

// Print results
echo "Lasso Regression (alpha=$bestAlpha):\n";
foreach ($coefficients as $i => $coefficient) {
    echo $featureNames[$i] . ': ' . number_format($coefficient, 4) . PHP_EOL;
}

// Predict for example homes
$exampleStandardized = $exampleDataset->samples();
$predictions = [];

foreach ($exampleStandardized as $home) {
    $pred = 0;
    for ($i = 0; $i < count($coefficients); $i++) {
        $pred += $home[$i] * $coefficients[$i];
    }
    $predictions[] = $pred;
}

echo "\nPredictions for example homes:\n";
foreach ($predictions as $i => $prediction) {
    echo $homeDescriptions[$i] . ": $" . number_format($prediction, 2) . PHP_EOL;
}

function simpleLasso($X, $y, $alpha = 1.0, $maxIter = 1000, $tolerance = 1e-4) {
    $n = count($X);
    $p = count($X[0]);

    // Initialize coefficients to zero
    $beta = array_fill(0, $p, 0.0);

    // Calculate X^T
    $Xt = [];
    for ($j = 0; $j < $p; $j++) {
        $Xt[$j] = [];
        for ($i = 0; $i < $n; $i++) {
            $Xt[$j][$i] = $X[$i][$j];
        }
    }

    // Coordinate descent
    for ($iter = 0; $iter < $maxIter; $iter++) {
        $maxDiff = 0;

        for ($j = 0; $j < $p; $j++) {
            // Calculate residual without current feature
            $r = [];
            for ($i = 0; $i < $n; $i++) {
                $pred = 0;
                for ($k = 0; $k < $p; $k++) {
                    if ($k != $j) {
                        $pred += $X[$i][$k] * $beta[$k];
                    }
                }
                $r[$i] = $y[$i] - $pred;
            }

            // Calculate correlation of residual with feature j
            $corr = 0;
            for ($i = 0; $i < $n; $i++) {
                $corr += $Xt[$j][$i] * $r[$i];
            }

            // Calculate L2 norm of feature j
            $l2Norm = 0;
            for ($i = 0; $i < $n; $i++) {
                $l2Norm += $Xt[$j][$i] * $Xt[$j][$i];
            }

            // Soft thresholding
            $oldBeta = $beta[$j];
            if ($corr > $alpha) {
                $beta[$j] = ($corr - $alpha) / $l2Norm;
            } else if ($corr < -$alpha) {
                $beta[$j] = ($corr + $alpha) / $l2Norm;
            } else {
                $beta[$j] = 0;
            }

            // Track max difference for convergence check
            $diff = abs($oldBeta - $beta[$j]);
            if ($diff > $maxDiff) {
                $maxDiff = $diff;
            }
        }

        // Check convergence
        if ($maxDiff < $tolerance) {
            break;
        }
    }

    return $beta;
}
