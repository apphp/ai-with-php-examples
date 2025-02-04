<?php

// Create the graph and add vertices with their levels
$graph = new InformedSearchGraph();

// Add all vertices with their heuristic values
// First parameter is vertex name, second is level (optional), third is heuristic value
$graph->addVertex('S', 0, 10.0);  // Start node
$graph->addVertex('A', 1, 8.5);
$graph->addVertex('B', 1, 8.0);
$graph->addVertex('C', 1, 9.0);
$graph->addVertex('D', 2, 7.0);
$graph->addVertex('E', 2, 6.5);
$graph->addVertex('F', 2, 7.5);
$graph->addVertex('H', 3, 5.0);
$graph->addVertex('I', 3, 4.5);
$graph->addVertex('J', 3, 6.0);
$graph->addVertex('K', 4, 3.0);
$graph->addVertex('L', 4, 2.5);
$graph->addVertex('M', 4, 4.0);
$graph->addVertex('N', 3, 5.5);
$graph->addVertex('O', 4, 3.5);
$graph->addVertex('P', 5, 1.5);
$graph->addVertex('Q', 5, 2.0);
$graph->addVertex('G', 6, 0.0);  // Goal node

// Add all edges with their costs
// Main paths
$graph->addEdge('S', 'A', 1.5);
$graph->addEdge('S', 'B', 2.1);
$graph->addEdge('S', 'C', 1.1);
$graph->addEdge('A', 'D', 2.5);
$graph->addEdge('B', 'E', 2.0);
$graph->addEdge('C', 'F', 1.5);
$graph->addEdge('D', 'H', 2.0);
$graph->addEdge('E', 'I', 2.0);
$graph->addEdge('F', 'J', 2.0);
$graph->addEdge('H', 'K', 2.0);
$graph->addEdge('I', 'L', 2.5);
$graph->addEdge('J', 'M', 2.0);
$graph->addEdge('K', 'P', 3.0);
$graph->addEdge('L', 'P', 2.0);
$graph->addEdge('M', 'Q', 2.5);
$graph->addEdge('P', 'G', 2.0);
$graph->addEdge('Q', 'G', 3.0);

// Cross connections
$graph->addEdge('D', 'E', 1.5);
$graph->addEdge('E', 'F', 1.0);
$graph->addEdge('H', 'I', 1.0);
$graph->addEdge('I', 'J', 1.5);
$graph->addEdge('K', 'L', 1.0);
$graph->addEdge('L', 'M', 1.5);
$graph->addEdge('F', 'N', 2.0);
$graph->addEdge('N', 'O', 2.5);
$graph->addEdge('O', 'Q', 2.0);

// Perform hill climbing search from S to G
echo "Performing Hill Climbing Search from S to G:\n";
echo "-------------------------------------------\n\n";

$searchResult = $graph->steepestAscentHillClimbing('S', 'G');

if ($searchResult === null) {
    echo "No path found!\n";
} else {
    echo "[!] Path found using Hill Climbing Search:\n";
    echo "\n\nSearch Analysis:\n";
    echo "---------------\n";
    $graph->searchAnalysis($searchResult);
}

echo "\n\nVerifying Hill Climbing search decisions:\n";
echo "----------------------------------------\n";
$path = $graph->debugSteepestAscentHillClimbing('S', 'G');
