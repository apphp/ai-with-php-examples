<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Cleaning with PHP</h1>
</div>

<?= create_run_code_button('Handling Missing Values with PHP-ML', 'data-fundamentals', 'data-processing', 'phpml-data-cleaning-handling-missing-code-run'); ?>

<div>
    <p>
        PHP-ML doesn’t have a built-in MissingDataImputer, but we can write custom code to handle missing values.
    </p>
</div>

<div>
    <?= create_dataset_and_test_data_links(__DIR__ . '/customers.csv', fullWidth: true); ?>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/phpml-data-cleaning-handling-missing-code.php', opened: true); ?>
</div>


