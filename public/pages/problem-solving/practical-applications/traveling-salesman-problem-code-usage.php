<?php


use app\public\include\classes\InformedSearchGraph;

// Define cities with their coordinates
$cities = [
    'New York' => [40.7128, -74.0060],
    'Los Angeles' => [34.0522, -118.2437],
    'Chicago' => [41.8781, -87.6298],
    'Houston' => [29.7604, -95.3698],
    'Phoenix' => [33.4484, -112.0740],
    'Philadelphia' => [39.9526, -75.1652],
    'San Antonio' => [29.4241, -98.4936],
    'San Diego' => [32.7157, -117.1611],
    'Dallas' => [32.7767, -96.7970],
    'Miami' => [25.7617, -80.1918]
];

// Helper function to calculate distance between cities
function calculateDistance($lat1, $lon1, $lat2, $lon2): float {
    $R = 6371; // Earth's radius in kilometers
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);

    $a = sin($dLat/2) * sin($dLat/2) +
        cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
        sin($dLon/2) * sin($dLon/2);

    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    return $R * $c;
}

// Function to run and analyze all search algorithms
function runAllSearches(InformedSearchGraph $graph, string $start, string $goal) {
    echo "\nInitial graph structure:\n";
    echo "------------------------\n";
    $graph->printGraph();

    $searches = [
//        'Greedy Search' => fn() => $graph->greedySearch($start, $goal),
        'A* Tree Search' => fn() => $graph->aStarTreeSearch($start, $goal),
        'A* Group Search' => fn() => $graph->aStarGroupSearch($start, $goal),
        'Beam Search (width = 3)' => fn() => $graph->beamSearch($start, $goal, 3),
        'IDA* Search' => fn() => $graph->idaStarSearch($start, $goal),
        'Simple Hill Climbing' => fn() => $graph->debugSimpleHillClimbing($start, $goal),
        'Steepest Ascent Hill Climbing' => fn() => $graph->debugSteepestAscentHillClimbing($start, $goal),
        'Stochastic Hill Climbing' => fn() => $graph->stochasticHillClimbing($start, $goal)
    ];

    foreach ($searches as $name => $searchFn) {
        echo "\n" . str_repeat('-', 50);
        echo "\n$name:\n";
        echo str_repeat('-', 50) . "\n";

        try {
            $startTime = microtime(true);
            $result = $searchFn();
            $endTime = microtime(true);

            if ($name === 'Stochastic Hill Climbing') {
                $result = $graph->debugStochasticHillClimbing($result, $start, $goal);
            }

            if ($result !== null) {
                $graph->searchAnalysis($result);
                printf("Time taken: %.4f seconds\n", $endTime - $startTime);
            } else {
                echo "No path found!\n";
            }
        } catch (Exception $e) {
            echo "Error during search: " . $e->getMessage() . "\n";
        }
    }
}

// Define start and goal cities
$startCity = 'New York';
$goalCity = 'Houston';

// Create graph and run searches
echo "Creating city graph and running all search algorithms...\n";
echo "Start: $startCity, Goal: $goalCity\n";
echo "Distance calculations are in kilometers\n";

//$graph = createCityGraph($cities, $goalCity);

// Create the graph and add vertices with their levels
$graph = new InformedSearchGraph();

// Add all vertices with their heuristic values
// First parameter is vertex name, second is level (optional), third is heuristic value
$graph->addVertex('Los Angeles', 0, 0);
$graph->addVertex('San Diego', 0, 179.4);
$graph->addVertex('Phoenix', 1, 574.3);
$graph->addVertex('San Antonio', 3, 1933.8);
$graph->addVertex('Dallas', 3, 1992.0);
$graph->addVertex('Houston', 4, 2206.3);
$graph->addVertex('Chicago', 5, 2804.0);
$graph->addVertex('New York', 7, 3935.7);  // Start node
$graph->addVertex('Miami', 7, 3758.8);
$graph->addVertex('Philadelphia', 7, 3843.5);

// Add all edges with their costs
$graph->addEdge('Los Angeles', 'Phoenix', 574.3);
$graph->addEdge('Los Angeles', 'San Diego', 179.4);
$graph->addEdge('Los Angeles', 'New York', 3935.7);

$graph->addEdge('Phoenix', 'Los Angeles', 574.3);
$graph->addEdge('Phoenix', 'San Diego', 480.9);

$graph->addEdge('San Diego', 'Phoenix', 480.9);
$graph->addEdge('San Diego', 'Los Angeles', 179.4);

$graph->addEdge('Chicago', 'Dallas', 1294.9);
$graph->addEdge('Chicago', 'New York', 1144.3);

$graph->addEdge('Dallas', 'Chicago', 1294.9);
$graph->addEdge('Dallas', 'San Antonio', 406.3);
$graph->addEdge('Dallas', 'Houston', 361.8);

$graph->addEdge('San Antonio', 'Dallas', 406.3);
$graph->addEdge('San Antonio', 'Houston', 304.3);

$graph->addEdge('Houston', 'San Antonio', 304.3);
$graph->addEdge('Houston', 'Dallas', 361.8);
$graph->addEdge('Houston', 'Miami', 1556.8);

$graph->addEdge('Miami', 'Houston', 1556.8);
$graph->addEdge('Miami', 'New York', 1757.9);

$graph->addEdge('New York', 'Miami', 1757.9);
$graph->addEdge('New York', 'Philadelphia', 129.6);
$graph->addEdge('New York', 'Chicago', 1144.3);
$graph->addEdge('New York', 'Los Angeles', 3935.7);

$graph->addEdge('Philadelphia', 'New York', 129.6);



runAllSearches($graph, $startCity, $goalCity);

// Function to print distances between all cities
function printDistanceMatrix($cities) {
    echo "\nDistance Matrix (km):\n";
    echo "-------------------\n";

    // Print header
    echo str_pad("", 15);
    foreach ($cities as $city => $coords) {
        echo str_pad(substr($city, 0, 12), 13);
    }
    echo "\n";

    // Print distances
    foreach ($cities as $city1 => $coords1) {
        echo str_pad(substr($city1, 0, 12), 15);
        foreach ($cities as $city2 => $coords2) {
            if ($city1 === $city2) {
                echo str_pad("0", 13);
            } else {
                $distance = calculateDistance(
                    $coords1[0], $coords1[1],
                    $coords2[0], $coords2[1]
                );
                echo str_pad(number_format($distance, 1), 13);
            }
        }
        echo "\n";
    }
}

// Print distance matrix at the end
//printDistanceMatrix($cities);

