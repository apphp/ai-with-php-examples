<?php

use app\public\include\classes\Chart;

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////
include('greedy-search-code-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Informed (Heuristic) Search</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Greedy Search</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?= create_href('problem-solving', 'informed-search', 'greedy-search') ?>" class="btn btn-sm btn-outline-primary">Show
                Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        Greedy search is an informed search algorithm that aims to expand the node closest to the goal, as estimated by a heuristic function . It
        takes a direct and straightforward approach, always choosing the path that seems most promising based on the heuristic value. The method is
        inspired by human intuition — choosing the option that appears best at each step without considering the overall problem structure. While
        simple and often efficient, greedy search is not guaranteed to find the optimal solution.
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/greedy-search-code-usage.php'); ?>
</div>

<div class="container-fluid px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-7 px-1 pe-4">
            <p><b>Graph:</b></p>

            <?php
            $graph = '
                    graph TB
                        S((S<small class="sub-title">h=7</small>))-->A((A<small class="sub-title">h=9</small>))
                        S-->D((D<small class="sub-title">h=5</small>))                
                        D-->B((B<small class="sub-title">h=4</small>))                
                        D-->E((E<small class="sub-title">h=3</small>))                
                        E-->G((G<small class="sub-title">h=0</small>))                
                    ';

            $steps = '[
                    { visit: "S", info: "Starting at root node S", edge: null },
                    { visit: "D", info: "Visiting first level node D", edge: "S-D" },
                    { visit: "E", info: "Visiting second level node E", edge: "D-E" },
                    { visit: "G", info: "Visiting third level node G - Search complete!", edge: "E-G" }
                ]';

            echo Chart::drawTreeDiagram(
                graph: $graph,
                steps: $steps,
                defaultMessage: 'Starting Greedy traversal...',
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
