<?php

use app\classes\Chart;

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);

$regressionDebugOptions = ['Show Debug' => '1'];
$regressionDebug = isset($_GET['regressionDebug']) && is_string($_GET['regressionDebug']) ? $_GET['regressionDebug'] : '';
verify_fields($regressionDebug, array_values($regressionDebugOptions), '');

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
            <a href="<?=create_href('ml-algorithms', 'linear-regression', 'rubix-lasso-regression')?>" class="btn btn-sm btn-outline-primary">Show Code</a>
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
    <?php //= create_dataset_and_test_data_links(__DIR__ . '/data/houses3.csv', array_flatten($testSamples));?>
</div>

<div class="container-fluid px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-7 px-1 pe-4">
            <p><b>Chart:</b></p>
            <?php
            foreach ($featureNames as $ind => $name):
                if ($featureNames[$ind] === 'price'):
                    continue;
                endif;
                echo '<div class="col-md-12 col-lg-12">';
                echo Chart::drawLinearRegression(
                    samples:  array_reduce_samples($dataset->samples(), $ind),
                    labels: array_map(fn ($label) => round($label / 1000), $dataset->labels()),
                    chartId: 'lasso_' . $ind,
                    regressionLine: false,
//                    testSamples:  $testSamples,
//                    testLabels:  $predictions,
//                    datasetLabel: 'House Prices',
//                    regressionLabel: 'Polynomial Regression',
                    xLabel: humanize($featureNames[$ind]),
                    yLabel: 'Price ($1000s)',
                    showLabelBoxes: false
                );
                echo '</div>';
            endforeach;

            ?>
        </div>
        <div class="col-md-12 col-lg-5 p-0 m-0">
            <div>
                <div class="mt-1">
                    <b>Regression:</b>
                </div>
                <form action="<?= APP_SEO_LINKS ? create_href('ml-algorithms', 'linear-regression', 'rubix-lasso-regression-code-run') : 'index.php'; ?>" type="GET">
                    <?= !APP_SEO_LINKS ? create_form_fields('ml-algorithms', 'linear-regression', 'rubix-lasso-regression-code-run  ') : '';?>
                    <?= create_form_features($regressionDebugOptions, [$regressionDebug], fieldName: 'regressionDebug', type: 'single-checkbox', class: ''); ?>
                    <div class="form-check form-check-inline float-end p-0 m-0 me-1">
                        <button type="submit" class="btn btn-sm btn-outline-primary">Re-generate</button>
                    </div>
                </form>
            </div>

            <hr>

            <?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>
        </div>
    </div>
</div>

