<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Linear Regression with PHP</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Simple Linear Regression with PHP-ML</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?=create_href('ml-algorithms', 'linear-regression', 'phpml-simple-linear-regression-code-run')?>" class="btn btn-sm btn-outline-primary">&#9654;&nbsp; Run Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        Used when there is only one independent variable.
        For this example, let’s use a small dataset with square footage and price.
    </p>
</div>

<div>
    <?= create_dataset_and_test_data_links(__DIR__ . '/houses1.csv'); ?>
</div>

<div>
    <p>Example of use:</p>
    <div class="bd-clipboard">
        <button id="copyButton" type="button" class="btn-clipboard" onclick="copyToClipboard()">
            Copy
        </button>&nbsp;
    </div>
    <code id="code">
        <?php highlight_file('phpml-simple-linear-regression-code.php'); ?>
    </code>
</div>


