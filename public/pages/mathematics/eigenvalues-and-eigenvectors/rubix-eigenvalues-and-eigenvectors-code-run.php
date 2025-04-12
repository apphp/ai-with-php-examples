<?php

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('rubix-eigenvalues-and-eigenvectors-code.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Eigenvalues and Eigenvectors</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Eigenvalues and Eigenvectors Computing with Rubix</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?=create_href('mathematics', 'eigenvalues-and-eigenvectors', 'rubix-eigenvalues-and-eigenvectors')?>" class="btn btn-sm btn-outline-primary">Show Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        Using Rubix ML, we can also compute eigenvalues and eigenvectors.
    </p>
</div>

<div>
    <?php //= create_dataset_and_test_data_links(__DIR__ . '/data/colors_and_size.csv', fullWidth: true);?>
</div>

<div class="container-fluid px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-7 px-1 pe-5">
            <div id="app"></div>

            <?php include('rubix-eigenvalues-and-eigenvectors-js.php'); ?>
        </div>
        <div class="col-md-12 col-lg-5 p-0 m-0">
            <!-- Controls can be placed anywhere -->
            <div id="controls" class="controls-container"></div>


            <?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>
        </div>
    </div>
</div>


