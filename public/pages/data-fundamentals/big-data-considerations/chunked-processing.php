<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Big Data Techniques in PHP</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="<?=create_href('data-fundamentals', 'big-data-considerations', 'chunked-processing-code-run')?>" class="btn btn-sm btn-outline-primary">&#9654; Run Code</a>
        </div>
    </div>
</div>

<div>
    <h2 class="h4">Chunked Processing</h2>
    <p>
        Chunked processing is crucial when dealing with datasets that are too large to fit in memory.
        This technique involves processing data in smaller, manageable pieces.
    </p>
    <p>Example of Class ChunkedProcessor:</p>
</div>

<div>
    <div class="bd-clipboard">
        <button id="copyButton" type="button" class="btn-clipboard" onclick="copyToClipboard()">
            Copy
        </button>&nbsp;
    </div>
    <code id="code">
        <?php highlight_file('chunked-processing-code.php'); ?>
    </code>
</div>


