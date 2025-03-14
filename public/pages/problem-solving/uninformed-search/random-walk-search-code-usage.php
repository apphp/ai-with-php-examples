<?php

// Create new graph instance
use app\classes\search\UninformedSearchGraph;

$graph = new UninformedSearchGraph();

// Add vertices with their levels
$graph->addVertex('S', 0);  // Start node (level 0)
$graph->addVertex('A', 1);  // Level 1
$graph->addVertex('B', 1);  // Level 1
$graph->addVertex('C', 2);  // Level 2
$graph->addVertex('D', 2);  // Level 2
$graph->addVertex('G', 2);  // Level 2
$graph->addVertex('H', 2);  // Level 2
$graph->addVertex('E', 3);  // Level 3
$graph->addVertex('F', 3);  // Level 3
$graph->addVertex('I', 3);  // Level 3
$graph->addVertex('K', 4);  // Level 4 (target node)

// Add edges to create the graph structure
$graph->addEdge('S', 'A');  // S -> A
$graph->addEdge('S', 'B');  // S -> B
$graph->addEdge('A', 'C');  // A -> C
$graph->addEdge('A', 'D');  // A -> D
$graph->addEdge('B', 'G');  // B -> G
$graph->addEdge('B', 'H');  // B -> H
$graph->addEdge('C', 'E');  // C -> E
$graph->addEdge('C', 'F');  // C -> F
$graph->addEdge('G', 'I');  // G -> I
$graph->addEdge('E', 'K');  // E -> K

echo "RWS traversal starting from vertex 'S':\n";
echo "--------------------------------------\n";

// Perform random search from S to K - 100 steps maximum
$searchResult = $graph->rws('S', 'K', 100);
$graph->printRwsPath($searchResult);
