<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Linear Regression with PHP</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Multiple Linear Regression with Rubix</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?=create_href('ml-algorithms', 'linear-regression', 'rubix-multiple-linear-regression-code-run')?>" class="btn btn-sm btn-outline-primary">&#9654;&nbsp; Run Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        Involves two or more independent variables. For example, predicting house prices based on
        factors like size, number of rooms, and location.
    </p>
</div>

<div>
    <?= create_dataset_and_test_data_links(__DIR__ . '/houses2.csv', fullWidth: true); ?>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/rubix-multiple-linear-regression-code.php', opened: true); ?>
</div>
