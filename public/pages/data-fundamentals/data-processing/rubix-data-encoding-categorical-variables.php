<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Transformation with PHP</h1>
</div>

<?= create_run_code_button('Encoding Categorical Variables with Rubix', 'data-fundamentals', 'data-processing', 'rubix-data-encoding-categorical-variables-code-run'); ?>

<div>
    <p>
        Categorical data, such as "color" or "size," needs to be converted into numerical format so machine learning models can interpret it. One-Hot
        Encoding is a common method that transforms each category into a binary vector.
    </p>
</div>

<div>
    <?= create_dataset_and_test_data_links(__DIR__ . '/data/colors_and_size.csv', fullWidth: true); ?>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/rubix-data-encoding-categorical-variables-code.php', opened: true); ?>
</div>
