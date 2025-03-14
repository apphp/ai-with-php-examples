<?php

use app\classes\search\InformedSearchGraph;

// Create the graph and add vertices with their levels
$graph = new InformedSearchGraph();

// Add vertices with their levels and heuristic values
$graph->addVertex('A', 0, 7.0);  // Root node at level 0
$graph->addVertex('B', 1, 5.0);  // Level 1 nodes
$graph->addVertex('C', 1, 10.0);
$graph->addVertex('D', 2, 10.0); // Level 2 nodes
$graph->addVertex('E', 2, 9.0);
$graph->addVertex('F', 2, 7.0);  // Goal node

// Add edges with their costs
$graph->addEdge('A', 'B', 3.0); // Left branch
$graph->addEdge('B', 'D', 5.0);
$graph->addEdge('B', 'E', 4.0);

$graph->addEdge('A', 'C', 4.0); // Right branch
$graph->addEdge('C', 'F', 3.0);

// Perform IDA* search from S to G
echo "Performing IDA* Search from A to F:\n";
echo "----------------------------------\n\n";

$searchResult = $graph->idaStarSearch('A', 'F');
if ($searchResult) {
    $graph->printPath($searchResult);
} else {
    echo "No path found!\n";
}
