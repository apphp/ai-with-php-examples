<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Transformation with PHP</h1>
</div>

<?= create_run_code_button('Encoding Categorical Variables with Rubix', 'data-fundamentals', 'data-processing', 'rubix-data-encoding-categorical-variables-code-run'); ?>

<div>
    <p>
        Categorical data, like "color" or "size," must be converted into numerical form for machine learning models to process it. One common approach
        is One-Hot Encoding, which represents each category as a binary vector. This method creates separate columns for each category, assigning a 1
        if the category is present and a 0 if it is not. The main goal of One-Hot Encoding is to make categorical data usable in machine learning
        models.
    </p>
</div>

<div>
    <?= create_dataset_and_test_data_links(__DIR__ . '/data/colors_and_size.csv', fullWidth: true); ?>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/rubix-data-encoding-categorical-variables-code.php', opened: true); ?>
</div>
