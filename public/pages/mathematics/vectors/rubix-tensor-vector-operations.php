<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Vectors</h1>
</div>

<?= create_run_code_button('Vector Operations with Rubix/Tensor', 'mathematics', 'vectors', 'rubix-tensor-vector-operations-run'); ?>

<div>
    <p>
        The RubixML/Tensor library provides efficient vector operations for numerical computing in PHP. With its Vector class, developers can perform
        element-wise arithmetic, dot products, norms, and statistical calculations like mean and variance. These operations are crucial for tasks such
        as feature scaling, distance measurement, and optimizing machine learning models. Designed for high performance, Tensor enables seamless
        vector computations without external dependencies.
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/rubix-tensor-vector-operations-usage.php', opened: true); ?>
</div>
