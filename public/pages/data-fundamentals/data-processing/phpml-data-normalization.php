<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Cleaning with PHP</h1>
</div>

<?= create_run_code_button('Data Normalization with PHP-ML', 'data-fundamentals', 'data-processing', 'phpml-data-normalization-code-run'); ?>

<div>
    <p>
        Normalization in PHP-ML can be done manually or by looping through each feature.
        However, PHP-ML also includes some transformers, though they are more limited.
        Here’s an example of manual Min-Max normalization.
    </p>
</div>

<div>
    <?php
        $dataset = [
            '[100, 500, 25],',
            '[150, 300, 15],',
            '[200, 400, 20],',
            '[50, 200, 10]'
        ];
        echo create_dataset_and_test_data_links($dataset, fullWidth: true);
    ?>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/phpml-data-normalization-code.php', opened: true); ?>
</div>
