<?php

use app\classes\Chart;

include_once('linear-transformation-code.php');

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('relu-activation-code-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Linear Transformations</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">ReLU Activation</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?=create_href('mathematics', 'linear-transformations', 'relu-activation')?>"  class="btn btn-sm btn-outline-primary">Show Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        Linear transformations alone cannot solve complex, nonlinear problems.
        Activation functions like ReLU or Sigmoid introduce nonlinearity to the network. <br>
        The ReLU function is defined as: $ReLU(x) = max(0, x)$.
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/relu-activation-code-usage.php'); ?>
</div>


<div class="container-fluid px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-7 px-1 pe-5">
            <p><b>Chart:</b></p>

            <?php
                echo Chart::drawReLU(
                    vector: $inputVector,
                    matrix: $weightMatrix,
                    bias: $bias,
                );
            ?>
        </div>
        <div class="col-md-12 col-lg-5 p-0 m-0">
            <form action="<?= APP_SEO_LINKS ? create_href('mathematics', 'linear-transformations', 'relu-activation-code-run') : 'index.php'; ?>" type="GET">
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
                    result: $linearResult,
                    matrixTitle: 'Weight Matrix ($W$)',
                    iVectorTitle: 'Input Vector ($x$)',
                    oVectorTitle: 'Output Vector ($y = Wx + b$)',
                    bVectorTitle: 'Bias Vector ($b$)',
                    min: -100,
                    max: 100
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





