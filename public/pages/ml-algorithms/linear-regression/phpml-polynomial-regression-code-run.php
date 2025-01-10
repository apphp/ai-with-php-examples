<?php

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);

$regressionOrder = $_GET['regression_order'] ?? '';
verify_fields($regressionOrder, ['1', '2', '3', '4', '5'], '3');

ob_start();
//////////////////////////////

include('phpml-polynomial-regression-code.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Linear Regression with PHP</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Polynomial Regression with PHP-NL</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?=create_href('ml-algorithms', 'linear-regression', 'phpml-polynomial-regression')?>" class="btn btn-sm btn-outline-primary">Show Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        An extension where the relationship between variables is non-linear.
        Polynomial regression transforms input variables to higher powers (e.g., $x2,x3x^2, x^3x2,x3$) but remains a
        linear model concerning the parameters, making it suitable for more complex patterns.
        In polynomial regression, we aim to model a non-linear relationship by transforming the input variable $x$ to
        include higher powers. The model equation for a polynomial regression of degree is:
        $y = \beta_0 + \beta_1 x + \beta_2 x^2 + \beta_3 x^3 + \dots + \beta_d x^d + \epsilon$
        <br><br>
        In this example we compare RM: average number of rooms per dwelling vs PRICE.
    </p>
</div>

<div>
    <?php
        //echo create_dataset_and_test_data_links(__DIR__ . '/data/boston_housing.csv', array_flatten($testSamples));
    ?>
</div>

<div class="container-fluid px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-7 px-1 pe-4">
            <p><b>Chart:</b></p>
            <?php
                echo Chart::drawPolynomialRegression(
                    samples:  $samples,
                    labels: $targets,
                    testSamples:  $testSamples,
                    testLabels:  $predictions,
                    datasetLabel: 'House Prices',
                    regressionLabel: 'Polynomial Regression',
                    xLabel: 'Number of Rooms',
                    yLabel: 'Price ($1000s)',
                    polynomialOrder: $regressionOrder,
                    title: "Boston Housing: Price vs Room Count",
                );
            ?>
        </div>
        <div class="col-md-12 col-lg-5 p-0 m-0">
            <div>
                <div class="mt-1">
                    <b>Regression:</b>
                </div>
                <form action="<?= APP_SEO_LINKS ? create_href('ml-algorithms', 'linear-regression', 'phpml-polynomial-regression-code-run') : 'index.php'; ?>" type="GET">
                    <?= !APP_SEO_LINKS ? create_form_fields('ml-algorithms', 'linear-regression', 'phpml-polynomial-regression-code-run') : '';?>
                    <?=create_form_features(['Order' => [1, 2, 3, 4, 5]], [$regressionOrder], fieldName: 'regression_order', type: 'number');?>
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

