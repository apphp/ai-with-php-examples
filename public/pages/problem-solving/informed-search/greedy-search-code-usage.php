<?php

use app\public\include\classes\InformedSearchGraph;

// Create the graph and add vertices with their levels
$graph = new InformedSearchGraph();

// Add vertices with their levels and heuristic values (h)
$graph->addVertex('S', 0, 7);  // Start node, h=7
$graph->addVertex('A', 1, 9);  // h=9
$graph->addVertex('D', 1, 5);  // h=5
$graph->addVertex('B', 2, 4);  // h=4
$graph->addVertex('E', 2, 3);  // h=3
$graph->addVertex('G', 3, 0);  // Goal node, h=0

// Add directed edges according to the diagram
$graph->addEdge('S', 'A');  // S -> A
$graph->addEdge('S', 'D');  // S -> D
$graph->addEdge('D', 'B');  // D -> B
$graph->addEdge('D', 'E');  // D -> E
$graph->addEdge('E', 'G');  // E -> G

// Perform Greedy search from S to G
echo "Performing Greedy search from S to G:\n";
echo "------------------------------------\n\n";

$searchResult = $graph->greedySearch('S', 'G');

if ($searchResult !== null) {
    echo "Path found:\n";
    $graph->printPath($searchResult, showCost: false);
} else {
    echo "No path found!\n";
}
