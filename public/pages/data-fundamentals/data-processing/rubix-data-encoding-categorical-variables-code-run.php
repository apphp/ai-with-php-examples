<?php

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('rubix-data-encoding-categorical-variables-code.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Transformation with PHP</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Encoding Categorical Variables with Rubix</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?=create_href('data-fundamentals', 'data-processing', 'rubix-data-encoding-categorical-variables')?>" class="btn btn-sm btn-outline-primary">Show Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        Categorical data, such as "color" or "size," needs to be converted into numerical format so machine learning models can interpret it. One-Hot
        Encoding is a common method that transforms each category into a binary vector.
    </p>
</div>

<div>
    <?= create_dataset_and_test_data_links(__DIR__ . '/colors_and_size.csv'); ?>
</div>

<div class="mb-1">
    <b>Result:</b>
    <span class="float-end">Memory: <?= memory_usage($memoryEnd, $memoryStart); ?> Mb</span>
    <span class="float-end me-2">Time running: <?= running_time($microtimeEnd, $microtimeStart); ?> sec.</span>
</div>
<code class="code-result">
    <pre><?= $result; ?></pre>
</code>
