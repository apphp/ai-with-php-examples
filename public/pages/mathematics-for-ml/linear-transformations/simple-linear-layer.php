<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Linear Transformations</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Simple Linear Layer</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?= create_href('mathematics-for-ml', 'linear-transformations', 'simple-linear-layer-code-run') ?>" class="btn btn-sm btn-outline-primary">&#9654; Run
                Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        In neural networks, linear transformations are represented as: $y = Wx + b$. Here, $W$ is a weight matrix, $x$ is the input, and $b$ is the bias vector.<br>
        In PHP it can be written as a class <code>LinearTransformation</code> with implementation of linear transformation operations.
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/linear-transformation-code.php', title: 'Example of class <code>LinearTransformation</code>', opened: true); ?>
</div>

