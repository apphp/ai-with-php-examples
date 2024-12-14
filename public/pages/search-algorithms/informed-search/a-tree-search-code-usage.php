<?php

// Create the graph and add vertices with their levels
$graph = new InformedSearchGraph();

// Add vertices with their levels and heuristic values
$graph->addVertex('S', 0, 7);  // Start node
$graph->addVertex('A', 1, 9);
$graph->addVertex('D', 1, 5);
$graph->addVertex('B', 2, 4);
$graph->addVertex('E', 2, 3);
$graph->addVertex('C', 3, 2);
$graph->addVertex('G1', 4, 0); // First G node (from C)
$graph->addVertex('G2', 3, 0); // Second G node (from E)
$graph->addVertex('G', 4, 0); // Third G node (from E)

// Add edges with their costs
$graph->addEdge('S', 'A', 3);
$graph->addEdge('S', 'D', 2);
$graph->addEdge('D', 'B', 1);
$graph->addEdge('D', 'E', 4);
$graph->addEdge('B', 'C', 2);
$graph->addEdge('B', 'E', 1);
$graph->addEdge('C', 'G1', 4); // Path to first G
$graph->addEdge('E', 'G2', 3); // Path to second G
$graph->addEdge('E', 'G', 3); // Path to third G (the one highlighted in orange)

// Find path using A* search to G3 (the highlighted goal node)
echo "Performing A* search search from S to G:\n";
echo "---------------------------------------\n\n";

$path = $graph->aStarSearch('S', 'G');
if ($path !== null) {
    $graph->printPath($path);
} else {
    echo "No path found!\n";
}
