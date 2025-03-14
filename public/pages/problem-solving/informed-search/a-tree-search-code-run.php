<?php

use app\classes\Chart;

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('a-tree-search-code-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Informed (Heuristic) Search</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">A* Tree Search</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?= create_href('problem-solving', 'informed-search', 'a-tree-search') ?>" class="btn btn-sm btn-outline-primary">Show
                Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        A* Tree Search, commonly referred to as A* Search, is a widely used pathfinding and graph traversal algorithm. It builds on the strengths of
        uniform-cost search and greedy search, offering a robust mechanism for finding the most cost-effective path from a starting node to a goal
        node.
        <br><br>
        A* uses a heuristic function, $f(x) = g(x) + h(x)$, where is the cumulative cost to reach the current node, and is an estimated cost to reach the goal from the
        current node. This balance between actual cost and estimated cost makes A* one of the most efficient search algorithms in many applications,
        including game development, robotics, and network optimization.
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/a-tree-search-code-usage.php'); ?>
</div>

<div class="container-fluid px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-7 px-1 pe-4">
            <p><b>Graph:</b></p>

            <?php
            $graph = '
                    graph TB
                        S((S<small class="sub-title">h=7</small>))--> |3| A((A<small class="sub-title">h=9</small>))
                        A-->|1| B1((B<small class="sub-title">h=4</small>))
                        B1-->|5| G3((G<small class="sub-title">h=0</small>))
                        S-->|2| D((D<small class="sub-title">h=5</small>))
                        D-->|1| B((B<small class="sub-title">h=4</small>))
                        D-->|4| E1((E<small class="sub-title">h=3</small>))
                        E1-->|3| G1((G<small class="sub-title">h=0</small>))
                        B-->|2| C((C<small class="sub-title">h=2</small>))
                        B-->|1| E((E<small class="sub-title">h=3</small>))
                        C-->|4| G2((G<small class="sub-title">h=0</small>))
                        E-->|3| G((G<small class="sub-title">h=0</small>))
                    ';

            $steps = '[
                    { visit: "S", info: "Starting at root node S", edge: null },
                    { visit: "D", info: "Visiting first level node D", edge: "S-D" },
                    { visit: "B", info: "Visiting first level node B", edge: "D-B" },
                    { visit: "E", info: "Visiting first level node E", edge: "B-E" },
                    { visit: "G", info: "Visiting third level node G - Search complete!", edge: "E-G" }
                ]';

            echo Chart::drawTreeDiagram(
                graph: $graph,
                steps: $steps,
                defaultMessage: 'Starting A* Graph traversal...',
                startNode: 'S',
                endNode: 'G',
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
