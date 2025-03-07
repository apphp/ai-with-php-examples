<?php

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('rubix-matrix-operations-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Matrices</h1>
</div>

<?= create_show_code_button('Matrix Operations with Rubix', 'mathematics', 'matrices', 'rubix-matrix-operations'); ?>

<div>
    <p>
        Rubix ML provides convenient tools for working with matrices, making it an excellent choice for data processing in machine learning with PHP.
        The library includes classes for creating, manipulating, and performing operations on matrices, such as transposition, multiplication,
        normalization, and decomposition. By using the Matrix class from Rubix ML, developers can efficiently handle numerical data, preprocess it
        before training models, and execute complex mathematical computations without writing low-level code.
    </p>
</div>

<div>
    <p class="btn btn-link px-0 py-0" id="toggleExampleOfUse" data-bs-toggle="collapse" href="#collapseExampleOfUse" role="button" aria-expanded="false" aria-controls="collapseExampleOfUse" title="Click to expand">
        Example of use <i id="toggleIcon" class="fa-regular fa-square-plus"></i>
    </p>
    <div class="collapse pb-4" id="collapseExampleOfUse">
        <div class="bd-clipboard">
            <button id="copyButton" type="button" class="btn-clipboard" onclick="copyToClipboard()">
                Copy
            </button>
            &nbsp;
        </div>
        <div class="code-wrapper">
            <code id="code">
            <?= highlight_file(dirname(__FILE__) . '/rubix-matrix-operations-usage.php', true); ?>
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
