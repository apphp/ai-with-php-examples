<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Vectors</h1>
</div>

<?= create_run_code_button('Vector Operations with Rubix', 'mathematics', 'vectors', 'rubix-vector-operations-run'); ?>

<div>
    <p>
        Rubix ML offers powerful tools for vector operations, making it easy to perform mathematical computations in machine learning applications.
        The library provides a Vector class that supports element-wise arithmetic, dot products, norms, and statistical functions like mean and
        variance. These operations are essential for feature scaling, distance calculations, and optimizing machine learning models.
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/rubix-vector-operations-usage.php', opened: true); ?>
</div>
