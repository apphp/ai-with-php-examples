<?php

use app\public\include\classes\Chart;

include_once('linear-transformation-code.php');

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('fully-connected-layer-code-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Linear Transformations</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Fully Connected Layer</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?=create_href('mathematics', 'linear-transformations', 'fully-connected-layer')?>"  class="btn btn-sm btn-outline-primary">Show Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        In a neural network, each layer applies a linear transformation followed by an activation function: $y = Wx + b$.
        Here, $W$ is a weight matrix, $x$ is the input, and $b$ is the bias vector.<br>
        In PHP it can be written as a class <code>LinearTransformation</code> with implementation of linear transformation operations.
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/fully-connected-layer-code-usage.php'); ?>
</div>


<div class="container-fluid px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-7 px-1 pe-5">
            <p><b>Chart:</b></p>

            <?php
                echo Chart::drawVectors(
                    vector: $inputVector,
                    matrix: $weightMatrix,
                    bias: $bias,
                    type: 'linear'
                );
            ?>

        </div>
        <div class="col-md-12 col-lg-5 p-0 m-0">
            <form action="<?= APP_SEO_LINKS ? create_href('mathematics', 'linear-transformations', 'fully-connected-layer-code-run') : 'index.php'; ?>" type="GET">
                <div class="float-end p-0 m-0 me-1">
                    <button type="submit" class="btn btn-sm btn-outline-primary">Reset</button>
                </div>
                <div class="clearfix"></div>
            </form>
            <hr>

            <?php
                echo Chart::drawVectorControls(
                    vector: $inputVector,
                    matrix: $weightMatrix,
                    bias: $bias,
                    result: $resultVector,
                    matrixTitle: 'Weight Matrix ($W$)',
                    iVectorTitle: 'Input Vector ($x$)',
                    oVectorTitle: 'Output Vector ($y = Wx + b$)',
                    bVectorTitle: 'Bias Vector ($b$)',
                );
            ?>
            <hr>

            <div class="pb-1">
                <b>Result:</b>
                <span class="float-end">Memory: <?= memory_usage($memoryEnd, $memoryStart); ?> Mb</span>
                <span class="float-end me-2">Time running: <?= running_time($microtimeEnd, $microtimeStart); ?> sec.</span>
            </div>
            <code class="code-result">
                <pre><?= $result; ?></pre>
            </code>
        </div>
    </div>
</div>

