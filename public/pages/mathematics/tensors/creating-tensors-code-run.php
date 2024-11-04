<?php
include_once('creating-tensors-code.php');

$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('creating-tensors-code-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tensors</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="<?=create_href('mathematics', 'tensors', 'creating-tensors')?>"  class="btn btn-sm btn-outline-primary">Show Code</a>
        </div>
    </div>
</div>

<div>
    <h2 class="h4">Creating Tensors</h2>
    <p>
        RubixML’s Tensor library allows you to create matrices and vectors (1-dimensional tensors) easily. Here’s how to create a tensor using various
        methods:
    </p>
</div>

<div>
    Example of use:
    <div class="bd-clipboard">
        <button id="copyButton" type="button" class="btn-clipboard" onclick="copyToClipboard()">
            Copy
        </button>
        &nbsp;
    </div>
    <code id="code">
        <?= highlight_file(dirname(__FILE__) . '/creating-tensors-code-usage.php', true); ?>
    </code>
</div>
<div>
    Result:
    <span class="float-end">Time running: <?= running_time($microtimeEnd, $microtimeStart); ?> sec.</span>
    <code id="code" class="code-result">
        <pre><?= $result; ?></pre>
    </code>
</div>
