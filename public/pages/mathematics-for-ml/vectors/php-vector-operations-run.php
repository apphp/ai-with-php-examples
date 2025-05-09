<?php

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('php-vector-operations-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Vectors</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Vector Operations with PHP</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?=create_href('mathematics-for-ml', 'vectors', 'php-vector-operations')?>"  class="btn btn-sm btn-outline-primary">Show Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        In PHP it can be written as a class Vector with implementation of a set of vector operations.
        This class is a PHP implementation of vector operations commonly used in linear algebra and, by extension, in various AI and machine learning
        algorithms. It provides a robust set of methods for performing vectors calculations, making it a valuable tool for developers working on AI
        projects in PHP.
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
        <div id="copyButton-code" class="code-wrapper">
            <code id="code">
                <?= highlight_file(dirname(__FILE__) . '/php-vector-operations-usage.php', true); ?>
            </code>
        </di>
    </div>
</div>

<?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>
