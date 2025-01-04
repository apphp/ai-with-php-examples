<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Linear Regression with PHP</h1>
</div>

<?= create_run_code_button('Simple Linear Regression with Rubix', 'ml-algorithms', 'linear-regression', 'rubix-simple-linear-regression-code-run'); ?>

<div>
    <p>
        Used when there is only one independent variable.
        For this example, let’s use a small dataset with square footage and price.
        This is the simplest form of linear regression, and it involves only one independent variable and one dependent variable. The equation for simple linear regression is:
        $y=\beta_{0} +\beta _{1} * x$
    </p>
</div>

<div>
    <?= create_dataset_and_test_data_links(__DIR__ . '/data/houses1.csv', fullWidth: true); ?>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/rubix-simple-linear-regression-code.php', opened: true); ?>
</div>
