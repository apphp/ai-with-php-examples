<?php

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('php-remove-duplicates-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">NLP Text Preprocessing</h1>
</div>

<?= create_show_code_button('Remove duplicates and extra whitespace with Pure PHP', 'nlp-processing-methods', 'text-preprocessing', 'php-remove-duplicates'); ?>

<div>
    <p>
        Data cleanliness directly affects model accuracy and performance. Machine Learning models, especially in
        Natural Language Processing (NLP), are highly sensitive to data inconsistencies. If the same word appears multiple
        times with different formatting (like "word", " word", or "word "), the algorithm may treat them as separate entries.
        Similarly, duplicated records in structured datasets can bias model training and distort predictions.
    </p>
</div>

<div>
    <p class="btn btn-link px-0 py-0" id="toggleExampleOfUse" data-bs-toggle="collapse" href="#collapseExampleOfUse" role="button" aria-expanded="false" aria-controls="collapseExampleOfUse" title="Click to expand">
        Example of use <i id="toggleIcon" class="fa-regular fa-square-plus"></i>
    </p>
    <div class="collapse pb-4" id="collapseExampleOfUse">
        <div class="bd-clipboard">
            <button id="copyButton" type="button" class="btn-clipboard" onclick="copyToClipboard()">
                Copy
            </button>
            &nbsp;
        </div>
        <div id="copyButton-code" class="code-wrapper">
            <code id="code">
                <?= highlight_file(dirname(__FILE__) . '/php-remove-duplicates-usage.php', true); ?>
            </code>
        </div>
    </div>
</div>

<?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>



