<?php

use app\classes\Chart;
use app\classes\search\SearchVisualizer;

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);

$availableTypes = ['Simple' => 'simple', 'Steepest Ascent' => 'steepest', 'Stochastic' => 'stochastic'];
$searchType = isset($_GET['searchType']) && is_string($_GET['searchType']) ? $_GET['searchType'] : '';
verify_fields($searchType, array_values($availableTypes), reset($availableTypes));

ob_start();
//////////////////////////////

//include('hill-climbing-search-code-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Informed (Heuristic) Search</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Simulated Annealing Search</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?= create_href('problem-solving', 'informed-search', 'simulated-annealing-search') ?>" class="btn btn-sm btn-outline-primary">Show
                Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        ...
    </p>
</div>

<div>
<!--    --><?php //= create_example_of_use_links(__DIR__ . '/hill-climbing-search-code-usage.php'); ?>
</div>


<div class="container-fluid px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-12 px-1 pe-4">

            <div id="root" class="_container py-4"></div>

            <?php include('simulated-annealing-search-js.php'); ?>

            <style>
                /* Additional custom styles */
                .legend-item {
                    display: flex;
                    align-items: center;
                    margin-right: 15px;
                }

                .legend-marker {
                    width: 12px;
                    height: 12px;
                    border-radius: 50%;
                    margin-right: 5px;
                }

                .algorithm-log {
                    height: 250px;
                    background-color: #000;
                    color: #4CFF4C;
                    font-family: monospace;
                    font-size: 0.875rem;
                    overflow-y: auto;
                }

                .log-entry-accepted {
                    color: #4CFF4C;
                }

                .log-entry-rejected {
                    color: #FFCC00;
                }

                .log-entry-info {
                    color: #6699FF;
                }
            </style>

        </div>

    </div>
</div>
