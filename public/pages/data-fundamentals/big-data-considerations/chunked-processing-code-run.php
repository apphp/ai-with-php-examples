<?php
include_once('chunked-processing-code.php');

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('chunked-processing-code-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Big Data Techniques in PHP</h1>
</div>

<?= create_show_code_button('Chunked Processing', 'data-fundamentals', 'big-data-considerations', 'chunked-processing'); ?>

<div>
    <p>
        Chunked processing is crucial when dealing with datasets that are too large to fit in memory.
        This technique involves processing data in smaller, manageable pieces.
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/chunked-processing-code-usage.php'); ?>
</div>

<?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>
