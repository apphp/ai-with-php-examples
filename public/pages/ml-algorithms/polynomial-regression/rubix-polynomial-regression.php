<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Polynomial Regression with PHP</h1>
</div>

<?= create_run_code_button('Polynomial Regression with Rubix', 'ml-algorithms', 'polynomial-regression', 'rubix-polynomial-regression-code-run'); ?>

<div>
    <p>
        Polynomial Regression is an extension where the relationship between variables is non-linear.
        Polynomial regression transforms input variables to higher powers (e.g., $x2,x3x^2, x^3x2,x3$) but remains a
        linear model concerning the parameters, making it suitable for more complex patterns.
        In polynomial regression, we aim to model a non-linear relationship by transforming the input variable $x$ to
        include higher powers. The model equation for a polynomial regression of degree is:
        $y = \beta_0 + \beta_1 x + \beta_2 x^2 + \beta_3 x^3 + \dots + \beta_d x^d + \epsilon$
        <br><br>
        In this example we compare RM: average number of rooms per dwelling vs PRICE.
    </p>
</div>

<div>
    <?= create_dataset_and_test_data_links(__DIR__ . '/data/boston_housing.csv', fullWidth: true); ?>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/rubix-polynomial-regression-code.php', opened: true); ?>
</div>
