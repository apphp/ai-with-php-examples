<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Linear Regression with PHP</h1>
</div>

<?= create_run_code_button('Lasso Regression with Rubix', 'ml-algorithms', 'linear-regression', 'rubix-lasso-regression-code-run'); ?>

<div>
    <p>
        In Lasso (Least Absolute Shrinkage and Selection Operator) regression, the penalty added is proportional to the absolute value of each
        coefficient. The cost function to minimize is:

        $J(\beta) = \sum_{i=1}^{n} (y_i - \hat{y_i})^2 + \lambda \sum_{j=1}^{p} |\beta_j|$
        <br><br>
        The  L1 -norm penalty $\sum_{j=1}^{p} |\beta_j|$ often results in some coefficients being reduced to zero, effectively performing feature selection.
    </p>
</div>

<div>
    <?= create_dataset_and_test_data_links(__DIR__ . '/data/houses3.csv', fullWidth: true); ?>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/rubix-lasso-regression-code.php', opened: true); ?>
</div>
