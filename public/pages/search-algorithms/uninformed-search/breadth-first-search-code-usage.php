<?php

// Create the graph and add vertices with their levels
$graph = new Graph();

// Add vertices
$graph->addVertex('S', 0);  // Level 0
$graph->addVertex('A', 1);  // Level 1
$graph->addVertex('B', 1);  // Level 1
$graph->addVertex('C', 2);  // Level 2
$graph->addVertex('D', 2);  // Level 2
$graph->addVertex('G', 2);  // Level 2
$graph->addVertex('H', 2);  // Level 2
$graph->addVertex('E', 3);  // Level 3
$graph->addVertex('F', 3);  // Level 3
$graph->addVertex('I', 3);  // Level 3
$graph->addVertex('K', 4);  // Level 4

// Add edges
$graph->addEdge('S', 'A');
$graph->addEdge('S', 'B');
$graph->addEdge('A', 'C');
$graph->addEdge('A', 'D');
$graph->addEdge('C', 'E');
$graph->addEdge('C', 'F');
$graph->addEdge('E', 'K');
$graph->addEdge('B', 'G');
$graph->addEdge('B', 'H');
$graph->addEdge('G', 'I');

// Perform DFS starting from 'S' to find 'K'
$bfsResult = $graph->bfs('S');

// Output the BFS traversal
echo "BFS traversal starting from vertex 'S':\n";
$graph->printPath($bfsResult);