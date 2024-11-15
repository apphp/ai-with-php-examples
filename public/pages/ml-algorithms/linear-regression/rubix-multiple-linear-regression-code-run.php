<?php

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('rubix-multiple-linear-regression-code.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

$features = $_GET['features'] ?? [];

if (empty($features)) {
    $features[0] = '0';
    $features[1] = '1';
}

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Linear Regression with PHP</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Multiple Linear Regression with Rubix</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-0">
            <a href="<?=create_href('ml-algorithms', 'linear-regression', 'rubix-multiple-linear-regression')?>" class="btn btn-sm btn-outline-primary">Show Code</a>
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
                <?= highlight_file(dirname(__FILE__) . '/rubix-multiple-linear-regression-code.php', true); ?>
            </code>
        </div>
    </div>
</div>

<div class="container-fluid px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-7 px-1 pe-5">
            <p><b>Chart:</b></p>
            <?php
                echo Chart::drawMultiLinearRegression(
                    samples:  $dataset->samples(),
                    labels: $dataset->labels(),
                    features: $features,
                    titles: ['Number of rooms', 'Square footage (sq.ft)', 'Location (km to center)'],
                    targetLabel: 'Price ($)',
                    mainTraceLabel: 'Dataset',
                    customTraceLabel: 'Prediction',
                    predictionSamples: $newSamples,
                    predictionResults: $predictions,
                );
            ?>
        </div>
        <div class="col-md-12 col-lg-5 p-0 m-0">
            <div>
                <div class="mt-1">
                    <b>Features:</b>
                </div>
                <form action="index.php" type="GET">
                    <?=create_form_fields('ml-algorithms', 'linear-regression', 'rubix-multiple-linear-regression-code-run')?>

                    <div class="form-check form-check-inline mt-2">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="features[]" value="0" <?=in_array('0', $features) ? 'checked' : '';?>>
                        <label class="form-check-label" for="inlineCheckbox1">Rooms</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="features[]" value="1" <?=in_array('1', $features) ? 'checked' : '';?>>
                        <label class="form-check-label" for="inlineCheckbox2">Size</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox3" name="features[]" value="2" <?=in_array('2', $features) ? 'checked' : '';?>>
                        <label class="form-check-label" for="inlineCheckbox3">Location</label>
                    </div>
                    <div class="form-check form-check-inline float-end p-0 m-0">
                        <button type="submit" class="btn btn-sm btn-outline-primary">Re-generate</button>
                    </div>
                </form>
            </div>

            <hr>

            <div class="pb-1">
                <b>Result:</b>
                <span class="float-end">Memory: <?= memory_usage($memoryEnd, $memoryStart); ?> Mb</span>
                <span class="float-end me-2">Time running: <?= running_time($microtimeEnd, $microtimeStart); ?> sec.</span>
            </div>
            <code id="code" class="code-result">
                <pre><?= $result; ?></pre>
            </code>
        </div>

    </div>

</div>

