<?php

require APP_PATH . 'vendor/autoload.php';

use Rubix\ML\Datasets\Unlabeled;
use Rubix\ML\Extractors\CSV;
use Rubix\ML\Transformers\MinMaxNormalizer;
use Rubix\ML\Transformers\ZScaleStandardizer;

// Load the dataset using CSV
$dataset = Unlabeled::fromIterator(new CSV(dirname(__FILE__) . '/data/time_series.csv', false));

// Create windows manually since RubixML doesn't have built-in windowing
function reshapeIntoRollingWindows(array $data, int $windowSize): array {
    // If input is a flat array, convert each element to an array
    $isFlat = !is_array(reset($data));
    $formattedData = $isFlat ? array_map(fn($value) => [$value], $data) : $data;

    $windows = [];
    for ($i = 0; $i <= count($formattedData) - $windowSize; $i++) {
        $window = array_slice($formattedData, $i, $windowSize);
        $windows[] = array_column($window, 0);
    }
    return $windows;
}

$reshapedData = reshapeIntoRollingWindows($dataset->samples(), 3);

// Convert back to RubixML dataset if needed
$windowedDataset = new Unlabeled($reshapedData);

echo "After Reshaping: \n";
echo "---------------\n";
print_r($reshapedData);
