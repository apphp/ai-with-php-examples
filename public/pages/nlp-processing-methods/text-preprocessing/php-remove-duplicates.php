<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">NLP Text Preprocessing</h1>
</div>

<?= create_run_code_button('Remove duplicates and extra whitespace with Pure PHP', 'nlp-processing-methods', 'text-preprocessing', 'php-remove-duplicates-code-run', 'Run Code'); ?>

<div>
    <p>
        Data cleanliness directly affects model accuracy and performance. Machine Learning models, especially in
        Natural Language Processing (NLP), are highly sensitive to data inconsistencies. If the same word appears multiple
        times with different formatting (like "word", " word", or "word "), the algorithm may treat them as separate entries.
        Similarly, duplicated records in structured datasets can bias model training and distort predictions.
    </p>
</div>

<div>
    <?= create_example_of_use_links(APP_PATH . 'src/NLP/Preprocessors/TextPreprocessor.php', opened: true); ?>
</div>

