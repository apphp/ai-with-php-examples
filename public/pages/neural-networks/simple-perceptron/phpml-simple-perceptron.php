<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Basic Neural Network</h1>
</div>

<?= create_run_code_button('Basic Neural Network with PHP-ML', 'neural-networks', 'simple-perceptron', 'phpml-simple-perceptron-code-run'); ?>

<div>
    <p>
        Basic Neural Network with no hidden layers (simple perceptron)
    </p>
</div>

<div>
    <?= create_dataset_and_test_data_links(__DIR__ . '/data/exams.csv', fullWidth: true); ?>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/phpml-simple-perceptron-code.php', opened: true); ?>
</div>

