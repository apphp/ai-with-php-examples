<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Transformation with PHP</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Encoding Categorical Variables with Rubix</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?=create_href('data-fundamentals', 'data-processing', 'rubix-data-encoding-categorical-variables-code-run')?>" class="btn btn-sm btn-outline-primary">&#9654; Run Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        Categorical data, such as "color" or "size," needs to be converted into numerical format so machine learning models can interpret it. One-Hot
        Encoding is a common method that transforms each category into a binary vector.
    </p>
</div>

<div>
    <p class="btn btn-link px-0 py-0" id="toggleDataset" data-bs-toggle="collapse" href="#collapseDataset" role="button" aria-expanded="false" aria-controls="collapseDataset" title="Click to expand">
        Dataset <i id="toggleIconDataset" class="fa-regular fa-square-plus"></i>
    </p>
    <div class="collapse pb-4" id="collapseDataset">
        <code id="dataset">
            <?php highlight_file('colors_and_size.csv'); ?>
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
        <?php highlight_file('rubix-data-encoding-categorical-variables-code.php'); ?>
    </code>
</div>


