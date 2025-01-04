<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Transformation with PHP</h1>
</div>

<?= create_run_code_button('Reshaping Data Structures with Rubix', 'data-fundamentals', 'data-processing', 'rubix-data-reshaping-data-structures-code-run'); ?>

<div>
    <p>
        Reshaping allows us to organize data into structures required by specific algorithms.
        For example, in time series analysis, data can be reshaped into rolling windows for sequence modeling.
    </p>
</div>

<div>
    <?= create_dataset_and_test_data_links(__DIR__ . '/data/time_series.csv', fullWidth: true); ?>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/rubix-data-reshaping-data-structures-code.php', opened: true); ?>
</div>
