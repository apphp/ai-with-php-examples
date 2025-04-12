<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Cleaning with PHP</h1>
</div>

<?= create_run_code_button('Data Standardization with Rubix', 'data-fundamentals', 'data-processing', 'rubix-data-standardization-code-run'); ?>

<div>
    <p>
        If standardization is more appropriate (for instance, if we’re using algorithms like SVMs that are sensitive to variance), we can apply the ZScaleStandardizer.
        The ZScaleStandardizer adjusts the features to have a mean of 0 and a standard deviation of 1, which is ideal for models like Support Vector Machines (SVM) and Principal Component Analysis (PCA).
    </p>
</div>

<div>
    <?php
        $dataset = [
            '[100, 500, 25],',
            '[150, 300, 15],',
            '[200, 400, 20],',
            '[50, 200, 10]',
        ];
        echo create_dataset_and_test_data_links($dataset, fullWidth: true);
    ?>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/rubix-data-standardization-code.php', opened: true); ?>
</div>
