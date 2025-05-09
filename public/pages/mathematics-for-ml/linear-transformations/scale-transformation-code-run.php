<?php

use app\classes\Chart;

include_once('linear-transformation-code.php');

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('scale-transformation-code-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Linear Transformations</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Scale Transformation</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?=create_href('mathematics-for-ml', 'linear-transformations', 'scale-transformation')?>"  class="btn btn-sm btn-outline-primary">Show Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        In PHP it can be written as a class <code>LinearTransformation</code> with implementation of linear transformation operations.
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/scale-transformation-code-usage.php'); ?>
</div>


<div class="container-fluid px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-7 px-1 pe-5">
            <p><b>Chart:</b></p>

            <?php
                echo Chart::drawVectors(
                    vector: $vector2D,
                    matrix: $transformMatrix
                );
            ?>

        </div>
        <div class="col-md-12 col-lg-5 p-0 m-0">
            <form action="<?= APP_SEO_LINKS ? create_href('mathematics-for-ml', 'linear-transformations', 'scale-transformation-code-run') : 'index.php'; ?>" type="GET">
                <div class="float-end p-0 m-0 me-1">
                    <button type="submit" class="btn btn-sm btn-outline-primary">Reset</button>
                </div>
                <div class="clearfix"></div>
            </form>
            <hr>

            <?php
                echo Chart::drawVectorControls(
                    vector: $vector2D,
                    matrix: $transformMatrix,
                    matrixTitle: 'Transformation Matrix ($A$)',
                    iVectorTitle: 'Input Vector ($x$)',
                    oVectorTitle: 'Output Vector ($Ax$)',
                );
            ?>
            <hr>

            <?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>
        </div>
    </div>
</div>





