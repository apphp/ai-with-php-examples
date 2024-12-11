<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Transformation with PHP</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Encoding Categorical Variables with Rubix</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?=create_href('data-fundamentals', 'data-processing', 'rubix-data-encoding-categorical-variables-code-run')?>" class="btn btn-sm btn-outline-primary">&#9654;&nbsp; Run Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        Categorical data, such as "color" or "size," needs to be converted into numerical format so machine learning models can interpret it. One-Hot
        Encoding is a common method that transforms each category into a binary vector.
    </p>
</div>

<div>
    <?= create_dataset_and_test_data_links(__DIR__ . '/colors_and_size.csv', fullWidth: true); ?>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/rubix-data-encoding-categorical-variables-code.php', opened: true); ?>
</div>
