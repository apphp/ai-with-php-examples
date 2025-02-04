<?php

use app\public\include\classes\Chart;

include_once('informed-graph-code.php');

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////
include('iterative-deepening-a-search-code-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Informed (Heuristic) Search</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Iterative Deepening A*</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?= create_href('search-algorithms', 'informed-search', 'iterative-deepening-a-search') ?>" class="btn btn-sm btn-outline-primary">Show
                Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        The Iterative Deepening A* Algorithm (IDA*) is a heuristic search method that combines the memory efficiency of Depth-First Search (DFS) with
        the optimal path-finding capabilities of the A* algorithm. It is specifically designed to handle large search spaces while maintaining
        optimality and completeness. By limiting memory usage, IDA* enables effective exploration of complex networks or trees to find the shortest
        path from the start state to the goal state.
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/iterative-deepening-a-search-code-usage.php'); ?>
</div>

<div class="container-fluid px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-7 px-1 pe-4">
            <p><b>Graph:</b></p>

            <?php
            $graph = '
                    graph TB
                        A((A<small class="sub-title">h=7</small>))--> |3| B((B<small class="sub-title">h=5</small>))
                        A--> |4| C((C<small class="sub-title">h=10</small>))
                        B--> |5| D((D<small class="sub-title">h=10</small>))
                        B--> |4| E((E<small class="sub-title">h=9</small>))
                        C--> |3| F((F<small class="sub-title">h=7</small>))
                    ';

            $steps = '[
                    { visit: "A", info: "Starting at root node A", edge: null },
                    { visit: "C", info: "Visiting first level node C", edge: "A-C" },
                    { visit: "F", info: "Visiting second level node F - Search complete!", edge: "C-F" }
                ]';

            echo Chart::drawTreeDiagram(
                graph: $graph,
                steps: $steps,
                defaultMessage: 'Starting A* Graph traversal...',
                startNode: 'A',
                endNode: 'F',
                intersectionNode: '',
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
