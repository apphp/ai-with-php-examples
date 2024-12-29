<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Transformation with PHP</h1>
</div>

<?= create_run_code_button('Normalizing and Scaling Numerical Features with Rubix', 'data-fundamentals', 'data-processing', 'rubix-data-encoding-normalizing-numerical-features-code-run'); ?>

<div>
    <p>
        Normalization adjusts numerical data to a standard range (often [0, 1]),
        which helps with model performance when features are on different scales.
    </p>
</div>

<div>
    <?= create_dataset_and_test_data_links(__DIR__ . '/data/numerical.csv', fullWidth: true); ?>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/rubix-data-encoding-normalizing-numerical-features-code.php', opened: true); ?>
</div>
