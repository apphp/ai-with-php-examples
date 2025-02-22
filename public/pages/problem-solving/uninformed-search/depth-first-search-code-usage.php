<?php

// Create the graph and add vertices with their levels
use app\public\include\classes\search\UninformedSearchGraph;

$graph = new UninformedSearchGraph();

// Add vertices with their levels
$graph->addVertex('S', 0);  // Level 0
$graph->addVertex('A', 1);  // Level 1
$graph->addVertex('H', 1);  // Level 1
$graph->addVertex('B', 2);  // Level 2
$graph->addVertex('C', 2);  // Level 2
$graph->addVertex('I', 2);  // Level 2
$graph->addVertex('J', 2);  // Level 2
$graph->addVertex('D', 3);  // Level 3
$graph->addVertex('E', 3);  // Level 3
$graph->addVertex('K', 3);  // Level 3 (First K)

// Add edges according to the tree structure
$graph->addEdge('S', 'A');
$graph->addEdge('S', 'H');
$graph->addEdge('A', 'B');
$graph->addEdge('A', 'C');
$graph->addEdge('B', 'D');
$graph->addEdge('B', 'E');
$graph->addEdge('C', 'K');
$graph->addEdge('H', 'I');
$graph->addEdge('H', 'J');

// Perform DFS starting from 'S' to find 'K'
$searchResult = $graph->dfs('S', 'K');

// Output the DFS traversal
echo "DFS traversal starting from vertex 'S':\n";
echo "--------------------------------------\n\n";
$graph->printPath($searchResult);
