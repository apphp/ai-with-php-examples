<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Cleaning with PHP</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Data Standardization with Rubix</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?= create_href('data-fundamentals', 'data-processing', 'rubix-data-standardization-code-run') ?>"
               class="btn btn-sm btn-outline-primary">&#9654;&nbsp; Run Code</a>
        </div>
    </div>
</div>

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
            '[50, 200, 10]'
        ];
        echo create_dataset_and_test_data_links($dataset, fullWidth: true);
    ?>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/rubix-data-standardization-code.php', opened: true); ?>
</div>
