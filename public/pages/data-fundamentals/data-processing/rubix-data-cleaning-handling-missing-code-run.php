<?php

$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('rubix-data-cleaning-handling-missing-code.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Cleaning with PHP</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Handling Missing Values with Rubix</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="<?=create_href('data-fundamentals', 'data-processing', 'rubix-data-cleaning')?>" class="btn btn-sm btn-outline-primary">Show Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        RubixML provides the MissingDataImputer for handling missing values. This imputer allows you to fill in missing values using strategies like
        Mean, Median, or Constant.
    </p>
</div>

<div>
    <p>Dataset</p>
    <code id="code">
        <?php highlight_file('customers.csv'); ?>
    </code>
</div>

<div>
    <p class="btn btn-link px-0 py-0" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
        Example of use
    </p>
    <div class="collapse pb-4" id="collapseExample">
        <div class="card card-body pb-0">
            <div class="bd-clipboard">
                <button id="copyButton" type="button" class="btn-clipboard" onclick="copyToClipboard()">
                    Copy
                </button>
                &nbsp;
            </div>
            <code id="code">
                <?= highlight_file(dirname(__FILE__) . '/rubix-data-cleaning-handling-missing-code.php', true); ?>
            </code>
        </div>
    </div>
</div>

<div>
    Result:
    <span class="float-end">Time running: <?= running_time($microtimeEnd, $microtimeStart); ?> sec.</span>
    <code id="code" class="code-result">
        <pre><?= $result; ?></pre>
    </code>
</div>
