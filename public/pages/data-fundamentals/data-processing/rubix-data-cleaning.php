<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Cleaning with PHP</h1>
</div>

<?= create_run_code_button('Handling Missing Values with Rubix', 'data-fundamentals', 'data-processing', 'rubix-data-cleaning-handling-missing-code-run'); ?>

<div>
    <p>
        RubixML provides the MissingDataImputer for handling missing values. This imputer allows you to fill in missing values using strategies like
        Mean, Median, or Constant.
    </p>
</div>

<div>
    <?= create_dataset_and_test_data_links(__DIR__ . '/customers.csv', fullWidth: true); ?>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/rubix-data-cleaning-handling-missing-code.php', opened: true); ?>
</div>
