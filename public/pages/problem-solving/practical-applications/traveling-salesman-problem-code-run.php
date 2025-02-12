<?php

use app\public\include\classes\Chart;
use app\public\include\classes\SearchVisualizer;


$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////
include('traveling-salesman-problem-code-usage.php');

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
            <a href="<?= create_href('problem-solving', 'practical-applications', 'traveling-salesman-problem') ?>" class="btn btn-sm btn-outline-primary">Show
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
    <?= create_example_of_use_links(__DIR__ . '/traveling-salesman-problem-code-usage.php'); ?>
</div>

<div class="container-fluid px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-7 px-1 pe-4">
            <p><b>Graph:</b></p>
            <?php
            $chartGraph = '
                graph TD
                    %% Node definitions with levels and heuristics
                    NY["NY<br>Level: 7<br>h: 3935.7"]
                    LA["Los Angeles<br>Level: 0<br>h: 0.0"]
                    CH["Chicago<br>Level: 5<br>h: 2804.0"]
                    HO["Houston<br>Level: 4<br>h: 2206.3"]
                    PH["Phoenix<br>Level: 1<br>h: 574.3"]
                    PHL["Philadelphia<br>Level: 7<br>h: 3843.5"]
                    SA["San Antonio<br>Level: 3<br>h: 1933.8"]
                    SD["San Diego<br>Level: 0<br>h: 179.4"]
                    DA["Dallas<br>Level: 3<br>h: 1992.0"]
                    MI["Miami<br>Level: 7<br>h: 3758.8"]
                
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

            $steps = '[
                    { visit: "NY", info: "", edge: null },
                    { visit: "CH", info: "", edge: "NY-CH" },
                    { visit: "DA", info: "", edge: "CH-DA" },
                    { visit: "HO", info: "Search complete!", edge: "DA-HO" },
                ]';

            echo Chart::drawTreeDiagram(
                graph: $chartGraph,
                steps: $steps,
                defaultMessage: 'Starting traversal...',
                startNode: 'NY',
                endNode: 'HO',
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
