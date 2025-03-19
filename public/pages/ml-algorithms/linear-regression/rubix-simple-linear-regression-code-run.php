<?php

use app\classes\Chart;

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('rubix-simple-linear-regression-code.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Linear Regression with PHP</h1>
</div>

<?= create_show_code_button('Simple Linear Regression with Rubix', 'ml-algorithms', 'linear-regression', 'rubix-simple-linear-regression'); ?>

<div>
    <p>
        Used when there is only one independent variable.
        For this example, let’s use a small dataset with square footage and price.
        This is the simplest form of linear regression, and it involves only one independent variable and one dependent variable. The equation for simple linear regression is:
        $y=\beta_{0} +\beta _{1} * x$
    </p>
</div>

<div>
    <?php
        $testData = [
            'size',
            '2250    // New house: 2250 sq ft'
        ];
        echo create_dataset_and_test_data_links(__DIR__ . '/data/houses1.csv', $testData);
    ?>
</div>

<div class="container-fluid px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-7 px-1 pe-4">
            <p><b>Chart:</b></p>
            <?php
                echo Chart::drawLinearRegression(
                    samples:  $dataset->samples(),
                    labels: $dataset->labels(),
                    xLabel: 'Square Footage (sq.ft)',
                    yLabel: 'Price ($)',
                    datasetLabel: 'House Prices',
                    regressionLabel: 'Regression Line',
                    predictionPoint: [$newSample[0], round($prediction[0])],
                    minY: 100_000,
                );
            ?>
        </div>
        <div class="col-md-12 col-lg-5 p-0 m-0">
            <?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>
        </div>
    </div>
</div>

