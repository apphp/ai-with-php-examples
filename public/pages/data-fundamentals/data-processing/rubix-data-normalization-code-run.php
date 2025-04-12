<?php

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('rubix-data-normalization-code.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Cleaning with PHP</h1>
</div>

<?= create_show_code_button('Data Normalization with Rubix', 'data-fundamentals', 'data-processing', 'rubix-data-normalization'); ?>

<div>
    <p>
        RubixML has a MinMaxNormalizer that scales values to a range (usually between 0 and 1). This is especially useful for features like
        <code>income</code> and <code>spending_score</code> that vary widely.
    </p>
</div>

<div>
    <?php
        $dataset = [
            '[100, 500, 25],',
            '[150, 300, 15],',
            '[200, 400, 20],',
            '[50, 200, 10]',
        ];
        echo create_dataset_and_test_data_links($dataset, fullWidth: true);
    ?>
</div>

<?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>
