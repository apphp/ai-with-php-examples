<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tensors</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="<?= create_href('mathematics', 'tensors', 'creating-tensors-code-run') ?>" class="btn btn-sm btn-outline-primary">&#9654; Run
                Code</a>
        </div>
    </div>
</div>

<div>
    <h2 class="h4">Creating Tensors</h2>
    <p>
        In PHP it can be written as a class Tensor with implementation of a set of matrix operations.
        This class is a PHP implementation of tensor operations, such as addition, subtraction, multiplication, division, and transposition.
        Additionally, it can handle element-wise transformations (e.g., exponentiation, logarithmic operations), making it easier to preprocess and
        manipulate data directly in PHP. This functionality is essential for PHP developers who want to implement machine learning models or perform
        matrix-heavy computations without needing to rely on external languages or software.
    </p>
    <p>Example of Class Tensor:</p>
</div>

<div>
    <div class="bd-clipboard">
        <button id="copyButton" type="button" class="btn-clipboard" onclick="copyToClipboard()">
            Copy
        </button>&nbsp;
    </div>
    <code id="code">
        <?php highlight_file('creating-tensors-code.php'); ?>
    </code>
</div>


