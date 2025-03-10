<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Matrices</h1>
</div>

<?= create_run_code_button('Matrix Operations with Rubix/Tensor', 'mathematics', 'matrices', 'rubix-tensor-matrix-operations-run'); ?>

<div>
    <p>
        The RubixML/Tensor library provides high-performance matrix operations for numerical computing in PHP. It offers a Matrix class with support
        for element-wise arithmetic, transposition, multiplication, decomposition, and advanced transformations. These capabilities are essential for
        data preprocessing, feature engineering, and machine learning model optimization. With its efficient implementation, Tensor enables seamless
        matrix computations without external dependencies, making it a powerful tool for AI and data science applications in PHP.
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/rubix-tensor-matrix-operations-usage.php', opened: true); ?>
</div>
