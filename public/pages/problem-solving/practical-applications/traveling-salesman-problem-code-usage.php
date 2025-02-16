<?php

use app\public\include\classes\InformedSearchGraph;
use app\public\include\classes\UninformedSearchGraph;


// Function to run and analyze all search algorithms
function runSearch(InformedSearchGraph|UninformedSearchGraph $graph, string $start, string $goal, string $searchAlgorithm = 'a-tree-search') {
//    echo "\nInitial graph structure:\n";
//    echo "------------------------\n";
//    $graph->printGraph();

    // Init algorithms
    $searches = [];

    switch ($searchAlgorithm) {
        case 'depth-first-search':
            $searches['Depth First'] = fn() => $graph->dfs($start, $goal); break;
        case 'breadth-first-search':
            $searches['Breadth First'] = fn() => $graph->bfs($start, $goal); break;
        case 'uniform-cost-search':
            $searches['Uniform Cost Search'] = fn() => $graph->ucs($start, $goal); break;
        case 'iterative-deepening-depth-first':
            $searches['Iterative Deepening Depth-First Search'] = fn() => $graph->iddfs($start, $goal); break;

        case 'greedy-search':
            $searches['Greedy Search'] = fn() => $graph->greedySearch($start, $goal); break;
        case 'a-group-search':
            $searches['A* Group Search'] = fn() => $graph->aStarGroupSearch($start, $goal); break;
        case 'beam-search-3':
            $searches['Beam Search (width = 3)'] = fn() => $graph->beamSearch($start, $goal, 3); break;
        case 'ida-search':
            $searches['IDA* Search'] = fn() => $graph->idaStarSearch($start, $goal); break;
        case 'simple-hill-climbing':
            $searches['Simple Hill Climbing'] = fn() => $graph->simpleHillClimbing($start, $goal); break;
        case 'steepest-ascent-hill-climbing':
            $searches['Steepest Ascent Hill Climbing'] = fn() => $graph->steepestAscentHillClimbing($start, $goal); break;
        case 'stochastic-hill-climbing':
            $searches['Stochastic Hill Climbing'] = fn() => $graph->stochasticHillClimbing($start, $goal); break;
        case 'a-tree-search':
        default:
            $searches['A* Tree Search'] = fn() => $graph->aStarTreeSearch($start, $goal); break;
    }

    $searchResult = '';
    foreach ($searches as $name => $searchFn) {
        echo "\n" . str_repeat('-', 50);
        echo "\n$name:\n";
        echo str_repeat('-', 50) . "\n";

        try {
            $startTime = microtime(true);
            $searchResult = $searchFn();
            $endTime = microtime(true);

            if ($name === 'Stochastic Hill Climbing') {
                $searchResult = $graph->debugStochasticHillClimbing($searchResult, $start, $goal);
            } elseif ($name === 'Steepest Ascent Hill Climbing') {
                $searchResult = $graph->debugSteepestAscentHillClimbing($start, $goal);
            } elseif ($name === 'Simple Hill Climbing') {
                $searchResult = $graph->debugSimpleHillClimbing($start, $goal);
            }

            if ($searchResult !== null) {
                if ($graph instanceof InformedSearchGraph){
                    $graph->searchAnalysis($searchResult);
                }
                printf("Time taken: %.4f seconds\n", $endTime - $startTime);
            } else {
                echo "No path found!\n";
            }
        } catch (Exception $e) {
            echo "Error during search: " . $e->getMessage() . "\n";
        }
    }

    return $searchResult;
}

// Define start and goal cities
$startCity = 'PHL';
$goalCity = 'HO';

// Create graph and run searches
echo "Creating city graph and running all search algorithms...\n";
echo "Start: $startCity, Goal: $goalCity\n";
echo "Distance calculations are in kilometers\n";

//$graph = createCityGraph($cities, $goalCity);

// Create the graph and add vertices with their levels
if (in_array($searchAlgorithm, ['depth-first-search', 'breadth-first-search', 'uniform-cost-search', 'iterative-deepening-depth-first'])){
    $graph = new UninformedSearchGraph();
} else {

    $graph = new InformedSearchGraph();
}

// Add all vertices with their heuristic values
// First parameter is vertex name, second is level (optional), third is heuristic value
$graph->addVertex('PHL', 0, 3843.5, 'Philadelphia');
$graph->addVertex('MI', 2, 3758.8, 'Miami');
$graph->addVertex('NY', 1, 3835.7, 'New York');
$graph->addVertex('CH', 2, 2804.0, 'Chicago');
$graph->addVertex('LA', 2, 1234.3, 'Los Angeles');
$graph->addVertex('DA', 3, 1992.0, 'Dallas');
$graph->addVertex('HO', 3, 2206.3, 'Houston');
$graph->addVertex('PH', 3, 574.3, 'Phoenix');
$graph->addVertex('SD', 3, 179.4, 'San Diego');
$graph->addVertex('SA', 4, 1933.8, 'San Antonio');

// Add all edges with their costs
$graph->addEdge('LA', 'PH', 574.3);
$graph->addEdge('LA', 'SD', 179.4);
$graph->addEdge('LA', 'NY', 3935.7);

$graph->addEdge('PH', 'LA', 574.3);
$graph->addEdge('PH', 'SD', 480.9);

$graph->addEdge('SD', 'PH', 480.9);
$graph->addEdge('SD', 'LA', 179.4);

$graph->addEdge('CH', 'DA', 1294.9);
$graph->addEdge('CH', 'NY', 1144.3);

$graph->addEdge('DA', 'CH', 1294.9);
$graph->addEdge('DA', 'SA', 406.3);
$graph->addEdge('DA', 'HO', 361.8);

$graph->addEdge('SA', 'DA', 406.3);
$graph->addEdge('SA', 'HO', 304.3);

$graph->addEdge('HO', 'SA', 304.3);
$graph->addEdge('HO', 'DA', 361.8);
$graph->addEdge('HO', 'MI', 1556.8);

$graph->addEdge('MI', 'HO', 1556.8);
$graph->addEdge('MI', 'NY', 1757.9);

$graph->addEdge('NY', 'MI', 1757.9);
$graph->addEdge('NY', 'PHL', 129.6);
$graph->addEdge('NY', 'CH', 1144.3);
$graph->addEdge('NY', 'LA', 3935.7);

$graph->addEdge('PHL', 'NY', 129.6);

$searchResult = runSearch($graph, $startCity, $goalCity, $searchAlgorithm);



