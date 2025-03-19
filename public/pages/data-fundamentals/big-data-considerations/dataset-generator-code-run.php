<?php
include_once('dataset-generator-code.php');

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('dataset-generator-code-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Big Data Techniques in PHP</h1>
</div>

<?= create_show_code_button('Dataset Generator', 'data-fundamentals', 'big-data-considerations', 'dataset-generator'); ?>

<div>
    <p>
        Generators provide a memory-efficient way to iterate over large datasets by yielding values one at a time.
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/dataset-generator-code-usage.php'); ?>
</div>

<?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>
