<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Big Data Techniques in PHP</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Chunked Processing</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?=create_href('data-fundamentals', 'big-data-considerations', 'chunked-processing-code-run')?>" class="btn btn-sm btn-outline-primary">&#9654;&nbsp; Run Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        Chunked processing is crucial when dealing with datasets that are too large to fit in memory.
        This technique involves processing data in smaller, manageable pieces.
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/chunked-processing-code.php', title: 'Example of Class ChunkedProcessor', opened: true); ?>
</div>

