<?php

require APP_PATH . 'vendor/autoload.php';

use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Datasets\Unlabeled;
use Rubix\ML\Extractors\CSV;
use Rubix\ML\Transformers\OneHotEncoder;

// Load the dataset using CSV
//$dataset = Unlabeled::fromIterator(new CSV(dirname(__FILE__) . '/data/colors_and_size.csv', false));


use Rubix\ML\Transformers\MinMaxNormalizer;

$dataset = new Labeled([
    [2000, 300],
    [2500, 400],
    [3000, 500],
], ['low', 'medium', 'high']);

$normalizer = new MinMaxNormalizer();
$normalizer->fit($dataset);
$normalizer->transform($dataset);

print_r($dataset->samples());
