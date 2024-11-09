<?php

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('phpml-simple-linear-regression-code.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Linear Regression with PHP</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Simple Linear Regression with PHP-ML</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="<?=create_href('ml-algorithms', 'linear-regression', 'phpml-simple-linear-regression')?>" class="btn btn-sm btn-outline-primary">Show Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        Used when there is only one independent variable.
        For this example, let’s use a small dataset with square footage and price.
    </p>
</div>

<div>
    <p class="btn btn-link px-0 py-0 me-4" id="toggleDataset" data-bs-toggle="collapse" href="#collapseDataset" role="button" aria-expanded="false" aria-controls="collapseDataset" title="Click to expand">
        Dataset <i id="toggleIconDataset" class="fa-regular fa-square-plus"></i>
    </p>
    <p class="btn btn-link px-0 py-0" id="toggleExampleOfUse" data-bs-toggle="collapse" href="#collapseExampleOfUse" role="button" aria-expanded="false" aria-controls="collapseExampleOfUse" title="Click to expand">
        Example of use <i id="toggleIconExampleOfUse" class="fa-regular fa-square-plus"></i>
    </p>
    <div class="collapse pb-4" id="collapseDataset">
        <div class="card card-body pb-0">
            <code id="code">
                <?php highlight_file('houses.csv'); ?>
            </code>
        </div>
    </div>
    <div class="collapse pb-4" id="collapseExampleOfUse">
        <div class="card card-body pb-0">
            <div class="bd-clipboard">
                <button id="copyButton" type="button" class="btn-clipboard" onclick="copyToClipboard()">
                    Copy
                </button>
                &nbsp;
            </div>
            <code id="code">
                <?= highlight_file(dirname(__FILE__) . '/phpml-simple-linear-regression-code.php', true); ?>
            </code>
        </div>
    </div>
</div>

<div class="container px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-7 px-1 pe-4">
            <p>Chart:</p>
            <?php
                echo Chart::drawLinearRegression(
                    samples:  $samples,
                    labels: $labels,
                    xLabel: 'Square Footage (sq.ft)',
                    yLabel: 'Price ($)',
                    datasetLabel: 'House Prices',
                    regressionLabel: 'Regression Line',
                    predictionPoint: [$newSample[0], round($predictedPrice)],
                    minY: 100_000,
                );
            ?>
        </div>
        <div class="col-md-12 col-lg-5 p-0 m-0">
            <p>Result:
                <span class="float-end">Memory: <?= memory_usage($memoryEnd, $memoryStart); ?> Mb</span>
                <span class="float-end me-2">Time running: <?= running_time($microtimeEnd, $microtimeStart); ?> sec.</span>
            </p>
            <code id="code" class="code-result">
                <pre><?= $result; ?></pre>
            </code>
        </div>

    </div>
</div>

