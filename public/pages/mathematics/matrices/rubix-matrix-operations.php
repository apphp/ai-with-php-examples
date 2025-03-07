<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Matrices</h1>
</div>

<?= create_run_code_button('Matrix Operations with Rubix', 'mathematics', 'matrices', 'rubix-matrix-operations-run'); ?>

<div>
    <p>
        Rubix ML provides convenient tools for working with matrices, making it an excellent choice for data processing in machine learning with PHP.
        The library includes classes for creating, manipulating, and performing operations on matrices, such as transposition, multiplication,
        normalization, and decomposition. By using the Matrix class from Rubix ML, developers can efficiently handle numerical data, preprocess it
        before training models, and execute complex mathematical computations without writing low-level code.
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/rubix-matrix-operations-usage.php', opened: true); ?>
</div>
