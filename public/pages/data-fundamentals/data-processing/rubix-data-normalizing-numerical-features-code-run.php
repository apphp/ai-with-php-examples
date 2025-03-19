<?php

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('rubix-data-normalizing-numerical-features-code.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Cleaning with PHP</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Normalizing and Scaling Numerical Features with Rubix</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?=create_href('data-fundamentals', 'data-processing', 'rubix-data-normalizing-numerical-features')?>" class="btn btn-sm btn-outline-primary">Show Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        Normalization adjusts numerical data to a standard range (often $[0, 1]$),
        which helps with model performance when features are on different scales.
    </p>
</div>

<div>
    <?php
        $dataset = [
            '2000,300,low,',
            '2500,400,medium',
            '3000,500,high',
        ];
        echo create_dataset_and_test_data_links($dataset, fullWidth: true);
    ?>
</div>

<?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>
