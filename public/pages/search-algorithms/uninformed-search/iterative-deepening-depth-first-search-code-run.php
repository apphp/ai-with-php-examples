<?php
include_once('graph-code.php');

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////
include('iterative-deepening-depth-first-search-code-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Uninformed (Blind) Search</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Iterative Deepening Depth-First Search (IDDFS)</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?=create_href('search-algorithms', 'uninformed-search', 'iterative-deepening-depth-first-search')?>" class="btn btn-sm btn-outline-primary">Show Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        The Iterative Deepening Depth-First Search (IDDFS) algorithm combines the strengths of two fundamental search algorithms: Depth-First Search
        (DFS) and Breadth-First Search (BFS). This hybrid approach balances memory efficiency with optimality by progressively exploring deeper levels
        of the search space. Unlike traditional DFS, which dives to the maximum depth at once, or BFS, which requires significant memory to maintain a
        queue of explored nodes, IDDFS systematically increases the search depth, ensuring thorough exploration while minimizing resource usage.
    </p>
</div>

<div>
    <p class="btn btn-link px-0 py-0" id="toggleExampleOfUse" data-bs-toggle="collapse" href="#collapseExampleOfUse" role="button" aria-expanded="false" aria-controls="collapseExampleOfUse" title="Click to expand">
        Example of use <i id="toggleIcon" class="fa-regular fa-square-plus"></i>
    </p>
    <div class="collapse pb-4" id="collapseExampleOfUse">
        <div class="bd-clipboard">
            <button id="copyButton" type="button" class="btn-clipboard" onclick="copyToClipboard()">
                Copy
            </button>
            &nbsp;
        </div>
        <code id="code">
            <?= highlight_file(dirname(__FILE__) . '/iterative-deepening-depth-first-search-code-usage.php', true); ?>
        </code>
    </div>
</div>

<div class="container-fluid px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-7 px-1 pe-4">
            <p><b>Graph:</b></p>

            <?php
                $graph = '
                    graph TB
                        S((S))-->A((A))
                        S-->B((B))
                        A-->C((C))
                        A-->D((D))
                        C-->G((G))
                        C-->H((H))
                        D-->I((I))                        
                        B-->E((E))
                        B-->F((F))
                        E-->J((J))
                    ';

                $steps = '[
                    { visit: "S", info: "Starting at root node S - Not Found!" },
                    { reset: true, info: "Reset for depth 1 search" },
                   
                    { visit: "S", info: "Starting at root node S" },
                    { visit: "A", info: "Visiting first level node A" },
                    { visit: "B", info: "Visiting first level node B - Not Found!" },
                    { reset: true, info: "Reset for depth 2 search" },
                    
                    { visit: "S", info: "Starting at root node S" },
                    { visit: "A", info: "Visiting first level node A" },
                    { visit: "C", info: "Visiting second level node C" },
                    { visit: "D", info: "Visiting second level node D" },
                    { visit: "B", info: "Visiting first level node B" },
                    { visit: "E", info: "Visiting second level node E" },
                    { visit: "F", info: "Visiting second level node F - Search complete!" },
                ]';

                echo Chart::drawTreeDiagram(
                    graph: $graph,
                    steps: $steps,
                    defaultMessage: 'Starting IDDFS traversal...',
                    startNode: 'S',
                    endNode: 'F',
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
