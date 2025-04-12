<?php

use app\classes\Chart;
use app\classes\search\SearchVisualizer;

$informedSearch = [
    'Greedy Search' => 'greedy-search',
    'A* Tree Search' => 'a-tree-search',
    'A* Group Search' => 'a-group-search',
    'Beam Search (width = 3)' => 'beam-search-3',
    'Beam Search (width = 4)' => 'beam-search-4',
    'IDA* Search' => 'ida-search',
    'Simple Hill Climbing' => 'simple-hill-climbing',
    'Steepest Ascent Hill Climbing' => 'steepest-ascent-hill-climbing',
    'Stochastic Hill Climbing' => 'stochastic-hill-climbing',
];

$uninformedSearch = [
    'Depth First' => 'depth-first-search',
    'Breadth First' => 'breadth-first-search',
    'Uniform Cost Search' => 'uniform-cost-search',
    'Iterative Deepening Depth-First Search' => 'iterative-deepening-depth-first',
    'Bidirectional Search' => 'bidirectional-first',
    'Depth-Limited Search (depth = 2)' => 'depth-limited-search-2',
    'Depth-Limited Search (depth = 3)' => 'depth-limited-search-3',
    'Random Walk Search' => 'random-walk-search',
];

$groupedAlgorithms = [
    'group1' => [
        'label' => 'Informed Search',
        'options' => $informedSearch,
    ],
    'group2' => [
        'label' => 'Uninformed Search',
        'options' => $uninformedSearch,
    ],
];

$availalbeAlgorithms = array_merge($informedSearch, $uninformedSearch);
$algorithmDebugOptions = ['Show Debug' => '1'];

$searchAlgorithm = isset($_GET['searchAlgorithm']) && is_string($_GET['searchAlgorithm']) ? $_GET['searchAlgorithm'] : '';
verify_fields($searchAlgorithm, array_values($availalbeAlgorithms), reset($availalbeAlgorithms));
$algorithmDebug = isset($_GET['algorithmDebug']) && is_string($_GET['algorithmDebug']) ? $_GET['algorithmDebug'] : '';
verify_fields($algorithmDebug, array_values($algorithmDebugOptions), '');

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('traveling-salesman-problem-algo-code-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Practical Applications</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Traveling Salesman Problem</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?= create_href('problem-solving', 'practical-applications', 'traveling-salesman-problem-algo') ?>"
               class="btn btn-sm btn-outline-primary">Show
                Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        The Traveling Salesman Problem (TSP) is a classic optimization problem in computer science and operations research. It involves finding the
        shortest possible route for a salesman to visit a set of cities exactly once and return to the starting point.
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/traveling-salesman-problem-algo-code-usage.php'); ?>
</div>

<div class="container-fluid px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-7 px-1 pe-4">
            <p><b>Graph:</b></p>
            <?php
            $chartGraph = '
                graph TD
                    %% Node definitions with levels and heuristics
                    PHL["Philadelphia<br>Level: 0<br>h: 3843.5"]
                    NY["New York<br>Level: 1<br>h: 3835.7"]
                    MI["Miami<br>Level: 2<br>h: 3758.8"]
                    CH["Chicago<br>Level: 2<br>h: 2804.0"]
                    LA["Los Angeles<br>Level: 2<br>h: 1234.3"]
                    DA["Dallas<br>Level: 3<br>h: 1992.0"]
                    HO["Houston<br>Level: 3<br>h: 2206.3"]
                    PH["Phoenix<br>Level: 3<br>h: 574.3"]
                    SD["San Diego<br>Level: 3<br>h: 179.4"]
                    SA["San Antonio<br>Level: 4<br>h: 1933.8"]

                    %% Style definitions for regions
                    classDef westCoast fill:#ffdddd,stroke:#333
                    classDef eastCoast fill:#ddffdd,stroke:#333
                    classDef central fill:#ddddff,stroke:#333
                    classDef south fill:#ffffdd,stroke:#333

                    %% Apply styles
                    class LA,SD,PH westCoast
                    class NY,PHL,MI eastCoast
                    class CH,DA central
                    class HO,SA south

                    %% Key connections with edge costs
                    NY <--> |129.6| PHL
                    NY <--> |1144.3| CH
                    NY <--> |3935.7| LA

                    LA <--> |179.4| SD
                    LA <--> |574.3| PH

                    HO <--> |304.3| SA
                    HO <--> |361.8| DA

                    PH <--> |480.9| SD

                    SA <--> |406.3| DA

                    CH <--> |1294.9| DA

                    MI <--> |1757.9| NY
                    MI <--> |1556.8| HO

                    %% Group cities by region
                    subgraph West["West Coast Region"]
                        LA
                        SD
                        PH
                    end

                    subgraph East["East Coast Region"]
                        NY
                        PHL
                        MI
                    end

                    subgraph Central["Central Region"]
                        CH
                        DA
                    end

                    subgraph South["Southern Region"]
                        HO
                        SA
                    end

                ';

            // Generate visualization
            if ($searchResult) {
                $visualizer = new SearchVisualizer($graph);
                $visualization = $visualizer->generateVisualization($searchResult);
                $chartSteps = $visualization['steps'];
            } else {
                $chartSteps = '[]';
            }

            echo Chart::drawTreeDiagram(
                graph: $chartGraph,
                steps: $chartSteps,
                defaultMessage: 'Starting traversal...',
                startNode: 'PHL',
                endNode: 'HO',
                intersectionNode: '',
            );
            ?>
        </div>
        <div class="col-md-12 col-lg-5 p-0 m-0">
            <div>
                <div class="mt-1">
                    <b>Search Type:</b>
                </div>
                <form class="mt-2"
                      action="<?= APP_SEO_LINKS ? create_href('problem-solving', 'practical-applications', 'traveling-salesman-problem-algo-code-run') : 'index.php'; ?>"
                      type="GET">
                    <?= !APP_SEO_LINKS ? create_form_fields('problem-solving', 'practical-applications', 'traveling-salesman-problem-algo-code-run') : ''; ?>
                    <?= create_form_features($groupedAlgorithms, [$searchAlgorithm], fieldName: 'searchAlgorithm', type: 'select', class: 'w-50', event: ' _onchange="hangleOnChange(this)"'); ?>
                    <?= create_form_features($algorithmDebugOptions, [$algorithmDebug], fieldName: 'algorithmDebug', type: 'single-checkbox', class: 'ms-3'); ?>
                    <div class="form-check form-check-inline float-end p-0 m-0 me-1">
                        <button type="submit" class="btn btn-sm btn-outline-primary">Re-generate</button>
                    </div>
                    <div class=" clearfix "></div>
                </form>
            </div>

            <hr>

            <?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>
        </div>
    </div>
</div>

<script>
    function hangleOnChange() {
        const select = document.getElementById("select_searchAlgorithm");
        const uninformedSearch = ['depth-first-search', 'breadth-first-search', 'uniform-cost-search', 'iterative-deepening-depth-first', 'bidirectional-first', 'depth-limited-search-2', 'depth-limited-search-3', 'random-walk-search'];

        if (uninformedSearch.includes(select.value)) {
            document.getElementById("inlineCheckbox1").checked = false;
            document.getElementById("inlineCheckbox1").disabled = true;
            document.getElementById("inlineCheckbox1").closest("div").setAttribute("title", "Disabled in Uninformed Search");
        } else {
            document.getElementById("inlineCheckbox1").disabled = false;
            document.getElementById("inlineCheckbox1").closest("div").removeAttribute("title");
        }
        loadTooltips();
    }

    document.addEventListener("DOMContentLoaded", () => {
        const select = document.getElementById("select_searchAlgorithm");
        select.addEventListener("change", hangleOnChange);
        hangleOnChange();
    });

</script>
