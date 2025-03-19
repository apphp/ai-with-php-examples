<?php

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('phpml-data-cleaning-handling-missing-code.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Cleaning with PHP</h1>
</div>

<?= create_show_code_button('Handling Missing Values with PHP-ML', 'data-fundamentals', 'data-processing', 'phpml-data-cleaning'); ?>

<div>
    <p>
        PHP-ML doesn’t have a built-in MissingDataImputer, but we can write custom code to handle missing values.
    </p>
</div>

<div>
    <?= create_dataset_and_test_data_links(__DIR__ . '/data/customers.csv'); ?>
</div>

<span class="float-end me-2"><span class="d-xs-hide">Time running:</span>
