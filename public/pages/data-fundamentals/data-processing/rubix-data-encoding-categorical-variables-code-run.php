<?php

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('rubix-data-encoding-categorical-variables-code.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Transformation with PHP</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Encoding Categorical Variables with Rubix</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?=create_href('data-fundamentals', 'data-processing', 'rubix-data-encoding-categorical-variables')?>" class="btn btn-sm btn-outline-primary">Show Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        Categorical data, like "color" or "size," must be converted into numerical form for machine learning models to process it. One common approach
        is One-Hot Encoding, which represents each category as a binary vector. This method creates separate columns for each category, assigning a 1
        if the category is present and a 0 if it is not. The main goal of One-Hot Encoding is to make categorical data usable in machine learning
        models.
    </p>
</div>

<div>
    <?= create_dataset_and_test_data_links(__DIR__ . '/data/colors_and_size.csv', fullWidth: true); ?>
</div>

<?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>
