<?php

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('rubix-tensor-vector-operations-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Vectors</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Vector Operations with Rubix/Tensor</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?=create_href('mathematics', 'vectors', 'rubix-tensor-vector-operations')?>"  class="btn btn-sm btn-outline-primary">Show Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        The RubixML/Tensor library provides efficient vector operations for numerical computing in PHP. With its Vector class, developers can perform
        element-wise arithmetic, dot products, norms, and statistical calculations like mean and variance. These operations are crucial for tasks such
        as feature scaling, distance measurement, and optimizing machine learning models. Designed for high performance, Tensor enables seamless
        vector computations without external dependencies.
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
                <?= highlight_file(dirname(__FILE__) . '/rubix-tensor-vector-operations-usage.php', true); ?>
            </code>
        </div>
    </div>
</div>

<?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>
