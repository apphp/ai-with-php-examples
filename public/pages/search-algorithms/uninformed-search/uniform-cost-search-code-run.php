<?php
include_once('uninformed-graph-code.php');

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////
include('uniform-cost-search-code-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Uninformed (Blind) Search</h1>
</div>

<?= create_show_code_button('Uniform Cost Search (UCS)', 'search-algorithms', 'uninformed-search', 'uniform-cost-search'); ?>

<div>
    <p>
        Uniform Cost Search (UCS) is a fundamental algorithm widely used in artificial intelligence for traversing weighted trees or graphs. It is
        designed to handle situations where each edge has a different cost, aiming to find the path to the goal node with the lowest cumulative cost.
        UCS achieves this by expanding nodes based on their path costs, starting from the root node.
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/uniform-cost-search-code-usage.php'); ?>
</div>

<div class="container-fluid px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-7 px-1 pe-4">
            <p><b>Graph:</b></p>

            <?php
                $graph = '
                    graph TB
                        S((S))-->|1| A((A))
                        S-->|4| B((B))
                        B-->|5| G1((G))
                        A-->|3| C((C))
                        A-->|2| D((D))
                        D-->|4| F((F))
                        D-->|3| G((G))
                        C-->|5| E((E))
                        E-->|5| G2((G))                    
                    ';

                $steps = '[
                    { visit: "S", info: "Starting at root node S", edge: null },
                    { visit: "A", info: "Visiting first level node A", edge: "S-A" },
                    { visit: "D", info: "Visiting second level node D", edge: "A-D" },
                    { visit: "G", info: "Visiting third level node G - Search complete!", edge: "D-G" }
                ]';

                echo Chart::drawTreeDiagram(
                    graph: $graph,
                    steps: $steps,
                    defaultMessage: 'Starting UCS traversal...',
                    startNode: 'S',
                    endNode: 'G',
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
