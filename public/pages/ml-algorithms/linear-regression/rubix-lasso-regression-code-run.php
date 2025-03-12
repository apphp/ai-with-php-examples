<?php

use app\public\include\classes\Chart;

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);

$regressionOrders = ['Order' => [1, 2, 3, 4, 5]];
$regressionOrder = $_GET['regression_order'] ?? '';
verify_fields($regressionOrder, array_values($regressionOrders['Order']), '3');

ob_start();
//////////////////////////////

include('rubix-lasso-regression-code.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Linear Regression with PHP</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Lasso Regression with Rubix</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?=create_href('ml-algorithms', 'linear-regression', 'rubix-lasso-regression-code')?>" class="btn btn-sm btn-outline-primary">Show Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        In Lasso (Least Absolute Shrinkage and Selection Operator) regression, the penalty added is proportional to the absolute value of each
        coefficient. The cost function to minimize is:

        $J(\beta) = \sum_{i=1}^{n} (y_i - \hat{y_i})^2 + \lambda \sum_{j=1}^{p} |\beta_j|$
        <br><br>
        The  L1 -norm penalty $\sum_{j=1}^{p} |\beta_j|$ often results in some coefficients being reduced to zero, effectively performing feature selection.
    </p>
</div>

<div>
    <?//= create_dataset_and_test_data_links(__DIR__ . '/data/boston_housing.csv', array_flatten($testSamples)); ?>
</div>

<div class="container-fluid px-2">
    <div class="row justify-content-start p-0">
        <div class="--col-md-12 col-lg-7 px-1 pe-4">
            <p><b>Chart:</b></p>
            <?php
//                echo Chart::drawPolynomialRegression(
//                    samples:  $samples,
//                    labels: $targets,
//                    testSamples:  $testSamples,
//                    testLabels:  $predictions,
//                    datasetLabel: 'House Prices',
//                    regressionLabel: 'Polynomial Regression',
//                    xLabel: 'Number of Rooms',
//                    yLabel: 'Price ($1000s)',
//                    polynomialOrder: $regressionOrder,
//                    title: "Boston Housing: Price vs Room Count",
//                );
            ?>
        </div>
        <div class="col-md-12 col-lg-12 p-0 m-0">
            <div>
                <div class="mt-1">
                    <b>Regression:</b>
                </div>
                <form action="<?= APP_SEO_LINKS ? create_href('ml-algorithms', 'linear-regression', 'rubix-polynomial-regression-code-run') : 'index.php'; ?>" type="GET">
                    <?= !APP_SEO_LINKS ? create_form_fields('ml-algorithms', 'linear-regression', 'rubix-polynomial-regression-code-run') : '';?>
                    <?=create_form_features($regressionOrders, [$regressionOrder], fieldName: 'regression_order', type: 'number');?>
                    <div class="form-check form-check-inline float-end p-0 m-0 me-1">
                        <button type="submit" class="btn btn-sm btn-outline-primary">Re-generate</button>
                    </div>
                </form>
            </div>

            <hr>

            <div class="mb-1">
                <b>Result:</b>
                <span class="float-end">Memory: <?= memory_usage($memoryEnd, $memoryStart); ?> Mb</span>
                <span class="float-end me-2">Time running: <?= running_time($microtimeEnd, $microtimeStart); ?> sec.</span>
            </div>
            <code class="code-result">
                <pre><?= $result; ?></pre>
            </code>
        </div>
    </div>
</div>

<?php

//
//// This script converts the housing.csv file to the format required by the Lasso example
//// The example expects features in column 0 and target (price) in column 1
//
//// Load the original CSV file
//$originalData = file_get_contents('housing.csv');
//$lines = explode("\n", $originalData);
//$header = str_getcsv(array_shift($lines));
//
//// Find the price column index (it should be the last column)
//$priceIndex = array_search('price', $header);
//
//// Create a new CSV file with the required format
//$outputFile = fopen('housing_formatted.csv', 'w');
//
//// Write the header - all features plus price
//fputcsv($outputFile, ['features', 'price']);
//
//// Process each line
//foreach ($lines as $line) {
//    if (empty(trim($line))) continue;
//
//    $row = str_getcsv($line);
//    $features = [];
//    $price = 0;
//
//    // Extract all features and the price
//    foreach ($row as $i => $value) {
//        if ($i == $priceIndex) {
//            $price = floatval($value);
//        } else {
//            $features[] = floatval($value);
//        }
//    }
//
//    // Write to the output file
//    fputcsv($outputFile, [json_encode($features), $price]);
//}
//
//fclose($outputFile);
//
//echo "Conversion completed. The data is now in the format expected by the Lasso example.\n";
//echo "Original features: " . implode(', ', array_diff($header, ['price'])) . "\n";
//echo "Price column identified at index: $priceIndex\n";
//echo "New file created: housing_formatted.csv\n";

//
/////////////////
/////
/////
//use Rubix\ML\Datasets\Labeled;
//use Rubix\ML\Datasets\Unlabeled;
//use Rubix\ML\Extractors\CSV;
//use Rubix\ML\Regressors\Ridge;
//use Rubix\ML\Transformers\MinMaxNormalizer;
//use Rubix\ML\CrossValidation\Metrics\RMSE;
//use Rubix\ML\CrossValidation\Metrics\RSquared;
//use Rubix\ML\CrossValidation\Metrics\MeanAbsoluteError;
//use Rubix\ML\Persisters\Filesystem;
//
//// Load and prepare the dataset
//echo "Loading dataset...\n";
//$extractor = new CSV(dirname(__FILE__) . '/data/houses3.csv', true);
//$samples = [];
//$labels = [];
//
//// Manually parse the CSV to ensure numeric types
//foreach ($extractor->getIterator() as $row) {
//    // Get price (last column) as the label
//    $label = (float) array_pop($row);
//
//    // Convert all feature values to float
//    $sample = array_map('floatval', $row);
//
//    $samples[] = $sample;
//    $labels[] = $label;
//}
//
//// Create a labeled dataset
//$dataset = new Labeled($samples, $labels);
//
//// The dataset has features in the following order:
//$featureNames = [
//    'bedrooms', 'bathrooms', 'sqft', 'lot_size', 'year_built',
//    'days_on_market', 'proximity_to_transit', 'crime_rate',
//    'school_rating', 'neighborhood_rating'
//];
//
//// Randomize the dataset
//$dataset = $dataset->randomize();
//echo "Total dataset size: " . $dataset->numSamples() . " samples\n";
//
//// Use regular split instead of stratified split (which is for classification)
//$trainSize = 0.8 * $dataset->numSamples();
//$trainSize = (int) $trainSize;
//$testSize = $dataset->numSamples() - $trainSize;
//
//// Split manually
//$samples = $dataset->samples();
//$labels = $dataset->labels();
//
//$trainingSamples = array_slice($samples, 0, $trainSize);
//$trainingLabels = array_slice($labels, 0, $trainSize);
//$testingSamples = array_slice($samples, $trainSize, $testSize);
//$testingLabels = array_slice($labels, $trainSize, $testSize);
//
//$training = new Labeled($trainingSamples, $trainingLabels);
//$testing = new Labeled($testingSamples, $testingLabels);
//
//echo 'Training samples: ' . $training->numSamples() . PHP_EOL;
//echo 'Testing samples: ' . $testing->numSamples() . PHP_EOL;
//
//// Calculate mean price for baseline comparison
//$meanPrice = array_sum($trainingLabels) / count($trainingLabels);
//echo 'Mean price in training data: $' . number_format($meanPrice, 2) . PHP_EOL;
//
//// Normalize the features for better model convergence
//echo "Normalizing features...\n";
//$normalizer = new MinMaxNormalizer();
//
//// Create an unlabeled dataset for fitting the normalizer
//$unlabeledTraining = new Unlabeled($training->samples());
//$normalizer->fit($unlabeledTraining);
//
//// Apply the normalizer to training and testing data
//$normalizedTrainingSamples = $training->samples();
//$normalizer->transform($normalizedTrainingSamples);
//$normalizedTraining = new Labeled($normalizedTrainingSamples, $training->labels());
//
//$normalizedTestingSamples = $testing->samples();
//$normalizer->transform($normalizedTestingSamples);
//$normalizedTesting = new Labeled($normalizedTestingSamples, $testing->labels());
//
//// Debug: Print sample data types to verify all are numeric
//if ($normalizedTraining->numSamples() > 0) {
//    $sampleData = $normalizedTraining->samples()[0];
//    echo "Sample data types verification:\n";
//    foreach ($sampleData as $i => $value) {
//        $featureName = isset($featureNames[$i]) ? $featureNames[$i] : "Feature $i";
//        echo "$featureName: " . gettype($value) . " (value: $value)\n";
//    }
//}
//
//// Create baseline predictions (just the mean)
//$baselinePredictions = array_fill(0, count($testingLabels), $meanPrice);
//
//// Calculate baseline metrics
//$rmseMetric = new RMSE();
//$baselineRMSE = $rmseMetric->score($baselinePredictions, $testingLabels);
//echo "Baseline RMSE (using mean price): $" . number_format(abs($baselineRMSE), 2) . PHP_EOL;
//
//$r2Metric = new RSquared();
//$baselineR2 = $r2Metric->score($baselinePredictions, $testingLabels);
//echo "Baseline R^2 (using mean price): " . number_format($baselineR2, 4) . PHP_EOL;
//
//// Try different alpha values for Ridge regression
//$alphaValues = [0.0001, 0.001, 0.01, 0.1, 1.0, 10.0, 100.0, 1000.0];
//$bestAlpha = null;
//$bestRMSE = PHP_FLOAT_MAX;
//$bestR2 = -PHP_FLOAT_MAX;
//$bestMAE = PHP_FLOAT_MAX;
//$bestEstimator = null;
//
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
//
//// Report best model
//echo "\nBest model performance with alpha = $bestAlpha:\n";
//echo 'RMSE: $' . number_format(abs($bestRMSE), 2) . PHP_EOL;
//echo 'R^2: ' . number_format($bestR2, 4) . PHP_EOL;
//echo 'Mean Absolute Error: $' . number_format(abs($bestMAE), 2) . PHP_EOL;
//echo 'Improvement over baseline: ' . number_format(abs($baselineRMSE) - abs($bestRMSE), 2) . ' RMSE' . PHP_EOL;
//
//if ($bestEstimator) {
//    // Ridge has direct access to coefficients
//    $coefficients = $bestEstimator->coefficients();
//
//    // Report coefficients and their magnitudes
//    echo "\nRidge Regression Coefficients:\n";
//
//    $importances = [];
//    foreach ($coefficients as $i => $coefficient) {
//        if (isset($featureNames[$i])) {
//            $importances[$featureNames[$i]] = $coefficient;
//        }
//    }
//
//    // Sort by coefficient magnitude (absolute value)
//    uasort($importances, function ($a, $b) {
//        return abs($b) <=> abs($a);
//    });
//
//    foreach ($importances as $feature => $importance) {
//        echo $feature . ': ' . number_format($importance, 4) . PHP_EOL;
//    }
//
//    // Example of making predictions for different homes
//    $newHomes = [
//        // 3 bed, 2 bath, medium-sized newer home
//        [3.0, 2.0, 2000.0, 6000.0, 2010.0, 30.0, 8.0, 3.0, 8.0, 8.0],
//        // 5 bed, 3.5 bath, large luxury home
//        [5.0, 3.5, 3500.0, 12000.0, 2018.0, 15.0, 6.5, 2.0, 9.0, 9.0],
//        // 2 bed, 1 bath, small older home
//        [2.0, 1.0, 1000.0, 3500.0, 1965.0, 60.0, 9.0, 3.5, 6.5, 7.0]
//    ];
//
//    // Create descriptions for the homes
//    $homeDescriptions = [
//        "Medium home (3 bed, 2 bath, 2000 sqft, built 2010)",
//        "Luxury home (5 bed, 3.5 bath, 3500 sqft, built 2018)",
//        "Small home (2 bed, 1 bath, 1000 sqft, built 1965)"
//    ];
//
//    $newSample = new Unlabeled($newHomes);
//    $normalizedNewSamples = $newSample->samples();
//    $normalizer->transform($normalizedNewSamples);
//    $normalizedNewSample = new Unlabeled($normalizedNewSamples);
//    $predictions = $bestEstimator->predict($normalizedNewSample);
//
//    echo "\nPredictions for example homes:\n";
//    foreach ($predictions as $i => $prediction) {
//        echo $homeDescriptions[$i] . ": $" . number_format($prediction, 2) . PHP_EOL;
//    }
//
//    // Save the trained model
////    $persister = new Filesystem('ridge_model.rbx');
////    $persister->save($bestEstimator);
////    echo "\nBest model saved to ridge_model.rbx" . PHP_EOL;
//} else {
//    echo "No successful model was trained." . PHP_EOL;
//}

?>
