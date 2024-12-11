<?php
include_once('uninformed-graph-code.php');

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////
include('depth-first-search-code-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Uninformed (Blind) Search</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Depth-First Search (DFS)</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?=create_href('search-algorithms', 'uninformed-search', 'depth-first-search')?>" class="btn btn-sm btn-outline-primary">Show Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        Depth-First Search (DFS) is a classic algorithm for traversing or searching through tree and graph data structures. As the name suggests, DFS
        explores as far down a branch as possible before backtracking to examine other paths. This behavior makes DFS particularly useful in scenarios
        where exploring deep hierarchies or paths is necessary. It relies on a stack data structure — either explicitly (using a manual stack) or
        implicitly (via recursion) — to manage the nodes being visited.
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/depth-first-search-code-usage.php'); ?>
</div>

<div class="container-fluid px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-7 px-1 pe-4">
            <p><b>Graph:</b></p>

            <?php
                $graph = '
                    graph TB
                        S((S))-->A((A))
                        S-->H((H))
                        A-->B((B))
                        A-->C((C))
                        B-->D((D))
                        B-->E((E))
                        C-->K((K))
                        H-->I((I))
                        H-->J((J))
                        I-->K1((K))                       
                    ';

                $steps = '[
                    { visit: "S", info: "Starting at root node S", edge: null },
                    { visit: "A", info: "Visiting first level node A", edge: "S-A" },
                    { visit: "B", info: "Visiting second level node B", edge: "A-B" },
                    { visit: "D", info: "Visiting third level node D", edge: "B-D" },
                    { visit: "E", info: "Visiting third level node E", edge: "B-E" },
                    { visit: "C", info: "Visiting second level node C", edge: "A-C" },
                    { visit: "K", info: "Visiting third level node K - Search complete!", edge: "C-K" }
                ]';

                echo Chart::drawTreeDiagram(
                    graph: $graph,
                    steps: $steps,
                    defaultMessage: 'Starting DFS traversal...',
                    startNode: 'S',
                    endNode: 'K',
                );
            ?>

        </div>
        <div class="col-md-12 col-lg-5 p-0 m-0">
            <div class="mb-1">
                <b>Result:</b>
                <span class="float-end">Memory: <?= memory_usage($memoryEnd, $memoryStart); ?> Mb</span>
                <span class="float-end me-2">Time running: <?= running_time($microtimeEnd, $microtimeStart); ?> sec.</span>
            </div>
            <code class="code-result">
                <pre><?= $result; ?></pre>
            </code>
        </div>
    </div>
</div>
