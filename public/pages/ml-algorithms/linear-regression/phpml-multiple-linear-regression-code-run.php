<?php

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('phpml-multiple-linear-regression-code.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Linear Regression with PHP</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Multiple Linear Regression with PHP-ML</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="<?=create_href('ml-algorithms', 'linear-regression', 'phpml-multiple-linear-regression')?>" class="btn btn-sm btn-outline-primary">Show Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        Involves two or more independent variables. For example, predicting house prices based on
        factors like size, number of rooms, and location.
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
            <code id="dataset">
                <?php highlight_file('houses2.csv'); ?>
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
                <?= highlight_file(dirname(__FILE__) . '/phpml-multiple-linear-regression-code.php', true); ?>
            </code>
        </div>
    </div>
</div>

<div class="container px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-7 px-1 pe-5">
            <p><b>Chart:</b></p>
            <?php
                echo Chart::drawMultiLinearRegression(
                    samples:  $samples,
                    labels: $labels,
                    xLabel: 'Number of rooms',
                    yLabel: 'Square footage (sq.ft)',
                    zLabel: 'Price ($)',
                    mainTraceLabel: 'Dataset',
                    customTraceLabel: 'Prediction',
                    predictionPoints: ['x' => [$newSamples[0][0], $newSamples[1][0]], 'y' => [$newSamples[0][1], $newSamples[1][1]], 'z' => [round($predictions[0]), round($predictions[1])]],
                );
            ?>
        </div>
        <div class="col-md-12 col-lg-5 p-0 m-0">
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

