<?php

use app\classes\search\InformedSearchGraph;

// Create the graph and add vertices with their levels
$graph = new InformedSearchGraph();

// Add vertices with their heuristic values (h)
$graph->addVertex('S', 0, 7.0); // Start node with h=7
$graph->addVertex('A', 1, 9.0); // h=9
$graph->addVertex('B', 2, 4.0); // h=4
$graph->addVertex('C', 3, 2.0); // h=2
$graph->addVertex('D', 1, 5.0); // h=5
$graph->addVertex('E', 2, 3.0); // h=3
$graph->addVertex('G', 4, 0.0); // Goal node with h=0

// Add edges with costs as shown in the image
$graph->addEdge('S', 'A', 3.0);
$graph->addEdge('S', 'D', 2.0);
$graph->addEdge('A', 'B', 1.0);
$graph->addEdge('B', 'G', 5.0);
$graph->addEdge('D', 'E', 4.0);
$graph->addEdge('D', 'B', 1.0);
$graph->addEdge('B', 'C', 2.0);
$graph->addEdge('B', 'E', 1.0);
$graph->addEdge('E', 'G', 3.0);
$graph->addEdge('C', 'G', 4.0);

// Run A* Tree Search
echo "Performing A* Tree Search from S to G:\n";
echo "-------------------------------------\n\n";

$searchResult = $graph->aStarTreeSearch('S', 'G');
if ($searchResult !== null) {
    $graph->printPath($searchResult);
} else {
    echo "No path found!\n";
}
