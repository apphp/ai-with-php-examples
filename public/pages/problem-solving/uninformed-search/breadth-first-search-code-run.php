<?php

use app\classes\Chart;

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('breadth-first-search-code-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Uninformed (Blind) Search</h1>
</div>

<?= create_show_code_button('Breadth-First Search (BFS)', 'problem-solving', 'uninformed-search', 'breadth-first-search'); ?>

<div>
    <p>
        Breadth-First Search is a widely used search strategy for traversing trees or graphs. It explores nodes level by level, expanding all
        successor nodes at the current depth before moving on to the next layer. This systematic breadthwise exploration is what gives BFS its name.
    </p>
</div>

<div>
    <?= create_example_of_use_links(APP_PATH . 'classes/search/UninformedSearchGraph.php'); ?>
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
                        C-->E((E))
                        C-->F((F))
                        E-->K((K))
                        B-->G((G))
                        B-->H((H))
                        G-->I((I))
                    ';

                $steps = '[
                    { visit: "S", info: "Starting at root node S", edge: null },
                    { visit: "A", info: "Visiting first level node A", edge: "S-A" },
                    { visit: "B", info: "Visiting first level node B", edge: "S-B" },
                    { visit: "C", info: "Visiting second level node C", edge: "A-C" },
                    { visit: "D", info: "Visiting second level node D", edge: "A-D" },
                    { visit: "G", info: "Visiting second level node G", edge: "B-G" },
                    { visit: "H", info: "Visiting second level node H", edge: "B-H" },
                    { visit: "E", info: "Visiting third level node E", edge: "C-E" },
                    { visit: "F", info: "Visiting third level node F", edge: "C-F" },
                    { visit: "I", info: "Visiting third level node I", edge: "G-I" },
                    { visit: "K", info: "Visiting fourth level node K - Search complete!", edge: "E-K" }
                ]';

                echo Chart::drawTreeDiagram(
                    graph: $graph,
                    steps: $steps,
                    defaultMessage: 'Starting BFS traversal...',
                    startNode: 'S',
                    endNode: 'K',
                );
            ?>
        </div>
        <div class="col-md-12 col-lg-5 p-0 m-0">
            <?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>
        </div>
    </div>
</div>
