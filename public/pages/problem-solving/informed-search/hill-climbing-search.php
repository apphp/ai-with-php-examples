<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Informed (Heuristic) Search</h1>
</div>

<?= create_run_code_button('Hill Climbing Search', 'problem-solving', 'informed-search', 'hill-climbing-search-code-run'); ?>

<div>
    <p>
        Hill climbing is an iterative optimization technique that attempts to find the best solution by making incremental changes to a given
        solution, similar to climbing up a hill to reach its peak. The algorithm starts with an initial solution and continuously moves toward better
        solutions until no further improvements can be made.
    </p>
</div>

<div>
    <?= create_example_of_use_links(APP_PUBLIC_PATH . 'include/classes/search/InformedSearchGraph.php', title: 'Example of class <code>InformedSearchGraph</code> (with Hill Climbing search)', opened: true); ?>
</div>


