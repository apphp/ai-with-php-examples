<?php
include_once('creating-tensors-code.php');

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('creating-tensors-code-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tensors</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Creating Tensors</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?=create_href('mathematics', 'tensors', 'creating-tensors')?>"  class="btn btn-sm btn-outline-primary">Show Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        RubixML’s Tensor library allows you to create matrices and vectors (1-dimensional tensors) easily. Here’s how to create a tensor using various
        methods:
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/creating-tensors-code-usage.php'); ?>
</div>

<span class="float-end me-2"><span class="d-xs-hide">Time running:</span>
