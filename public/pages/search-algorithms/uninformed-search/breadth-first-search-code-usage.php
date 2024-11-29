<?php

// Example usage
$graph = new Graph();

// Add vertices
$graph->addVertex('S');
$graph->addVertex('A');
$graph->addVertex('B');
$graph->addVertex('C');
$graph->addVertex('D');
$graph->addVertex('G');
$graph->addVertex('H');
$graph->addVertex('E');
$graph->addVertex('F');
$graph->addVertex('I');
$graph->addVertex('K');

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


// Perform BFS starting from vertex 'A'
$bfsResult = $graph->bfs('S');

// Output the BFS traversal
echo "BFS traversal starting from vertex 'S': \n" . implode(' -> ', $bfsResult);
