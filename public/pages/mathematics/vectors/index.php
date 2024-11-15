<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Vectors</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Vector Operations with PHP</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?=create_href('mathematics', 'vectors', 'vectors-code-run')?>" class="btn btn-sm btn-outline-primary">&#9654; Run Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        In PHP it can be written as a class Vector with implementation of a set of vector operations.
        This class is a PHP implementation of vector operations commonly used in linear algebra and, by extension, in various AI and machine learning
        algorithms. It provides a robust set of methods for performing vectors calculations, making it a valuable tool for developers working on AI
        projects in PHP.
    </p>
    <p>Example of Class Vector:</p>
</div>

<div>
    <div class="bd-clipboard">
        <button id="copyButton" type="button" class="btn-clipboard" onclick="copyToClipboard()">
            Copy
        </button>
        &nbsp;
    </div>
    <code id="code">
        <?php highlight_file('vectors-code.php'); ?>
    </code>
</div>
