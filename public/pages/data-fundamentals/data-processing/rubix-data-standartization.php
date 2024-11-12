<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Cleaning with PHP</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Data Normalization with Rubix</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="<?= create_href('data-fundamentals', 'data-processing', 'rubix-data-normalization-code-run') ?>"
               class="btn btn-sm btn-outline-primary">&#9654; Run Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        RubixML has a MinMaxNormalizer that scales values to a range (usually between 0 and 1). This is especially useful for features like
        <code>income</code> and <code>spending_score</code> that vary widely.
    </p>
</div>

<div>
    <p class="btn btn-link px-0 py-0" id="toggleDataset" data-bs-toggle="collapse" href="#collapseDataset" role="button" aria-expanded="false" aria-controls="collapseDataset" title="Click to expand">
        Dataset <i id="toggleIconDataset" class="fa-regular fa-square-plus"></i>
    </p>
    <div class="collapse pb-4" id="collapseDataset">
        <code class="gray">
        <pre>
[100, 500, 25],
[150, 300, 15],
[200, 400, 20],
[50, 200, 10]</pre>
        </code>
    </div>
</div>

<div>
    <p>Example of use:</p>
    <div class="bd-clipboard">
        <button id="copyButton" type="button" class="btn-clipboard" onclick="copyToClipboard()">
            Copy
        </button>&nbsp;
    </div>
    <code id="code">
        <?php highlight_file('rubix-data-normalization-code.php'); ?>
    </code>
</div>


