<?php

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('rubix-tensor-matrix-operations-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Matrices</h1>
</div>

<?= create_show_code_button('Matrix Operations with Rubix/Tensor', 'mathematics-for-ml', 'matrices', 'rubix-tensor-matrix-operations'); ?>

<div>
    <p>
        The RubixML/Tensor library provides high-performance matrix operations for numerical computing in PHP. It offers a Matrix class with support
        for element-wise arithmetic, transposition, multiplication, decomposition, and advanced transformations. These capabilities are essential for
        data preprocessing, feature engineering, and machine learning model optimization. With its efficient implementation, Tensor enables seamless
        matrix computations without external dependencies, making it a powerful tool for AI and data science applications in PHP.
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
            <?= highlight_file(dirname(__FILE__) . '/rubix-tensor-matrix-operations-usage.php', true); ?>
            </code>
        </div>
    </div>
</div>

<?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>
