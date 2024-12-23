<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Big Data Techniques in PHP</h1>
</div>

<?= create_run_code_button('Dataset Generator', 'data-fundamentals', 'big-data-considerations', 'dataset-generator-code-run'); ?>

<div>
    <p>
        Generators provide a memory-efficient way to iterate over large datasets by yielding values one at a time.
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/dataset-generator-code.php', title: 'Example of class DatasetGenerator', opened: true); ?>
</div>
