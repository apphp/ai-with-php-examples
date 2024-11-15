<?php

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('rubix-data-normalization-code.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Cleaning with PHP</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Data Normalization with Rubix</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="<?=create_href('data-fundamentals', 'data-processing', 'rubix-data-normalization')?>" class="btn btn-sm btn-outline-primary">Show Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        RubixML has a MinMaxNormalizer that scales values to a range (usually between 0 and 1). This is especially useful for features like
        <code>income</code> and <code>spending_score</code> that vary widely.
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
        <code class="gray">
        <pre>
[100, 500, 25],
[150, 300, 15],
[200, 400, 20],
[50, 200, 10]</pre>
        </code>
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
                <?= highlight_file(dirname(__FILE__) . '/rubix-data-normalization-code.php', true); ?>
            </code>
        </div>
    </div>
</div>

<div class="mb-1">
    <b>Result:</b>
    <span class="float-end">Memory: <?= memory_usage($memoryEnd, $memoryStart); ?> Mb</span>
    <span class="float-end me-2">Time running: <?= running_time($microtimeEnd, $microtimeStart); ?> sec.</span>
</div>
<code class="code-result">
    <pre><?= $result; ?></pre>
</code>
