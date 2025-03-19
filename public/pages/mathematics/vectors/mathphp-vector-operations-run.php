<?php

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('mathphp-vector-operations-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Vectors</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Vector Operations with MathPHP</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?=create_href('mathematics', 'vectors', 'mathphp-vector-operations')?>"  class="btn btn-sm btn-outline-primary">Show Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        MathPHP is a PHP library designed for advanced mathematical operations, including vector operations. Below is an overview of how you can use
        MathPHP to perform vector operations such as addition, subtraction, dot product, cross product, and magnitude.
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
                <?= highlight_file(dirname(__FILE__) . '/mathphp-vector-operations-usage.php', true); ?>
            </code>
        </div>
    </div>
</div>

<?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>
