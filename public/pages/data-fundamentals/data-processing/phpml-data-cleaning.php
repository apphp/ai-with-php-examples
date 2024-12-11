<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Cleaning with PHP</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Handling Missing Values with PHP-ML</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?=create_href('data-fundamentals', 'data-processing', 'phpml-data-cleaning-handling-missing-code-run')?>" class="btn btn-sm btn-outline-primary">&#9654;&nbsp; Run Code</a>
        </div>
    </div>
</div>

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


