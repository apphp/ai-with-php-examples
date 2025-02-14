<?php

use app\public\include\classes\Chart;
use app\public\include\classes\SearchVisualizer;

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////
include('random-walk-search-code-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Uninformed (Blind) Search</h1>
</div>

<?= create_show_code_button('Random Walk Search (RWS)', 'problem-solving', 'uninformed-search', 'random-walk-search'); ?>

<div>
    <p>
        The Random Walk Search algorithm is a fundamental search strategy where a search agent randomly selects and moves to a neighboring node
        without maintaining a history of past states. This approach is often used in scenarios where structured search methods are either infeasible
        or inefficient due to an unknown or highly complex search space.
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/random-walk-search-code-usage.php'); ?>
</div>

<div class="container-fluid px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-7 px-1 pe-4">
            <p><b>Graph:</b></p>

            <?php
                // Generate visualization
                $visualizer = new SearchVisualizer($graph);
                $visualization = $visualizer->generateVisualization($searchResult);

                $chartGraph = $visualization['graph'];
                $chartSteps = $visualization['steps'];

                echo Chart::drawTreeDiagram(
                    graph: $chartGraph,
                    steps: $chartSteps,
                    defaultMessage: 'Starting RWS traversal...',
                    startNode: $visualization['startNode'],
                    endNode: $visualization['endNode'],
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
