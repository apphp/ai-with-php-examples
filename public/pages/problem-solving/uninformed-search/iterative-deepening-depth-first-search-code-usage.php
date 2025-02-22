<?php

// Create the graph and add vertices with their levels
use app\public\include\classes\search\UninformedSearchGraph;

$graph = new UninformedSearchGraph();

// Add all vertices with their respective levels
$graph->addVertex('S', 0);  // Start node at level 0
$graph->addVertex('A', 1);
$graph->addVertex('B', 1);
$graph->addVertex('C', 2);
$graph->addVertex('D', 2);
$graph->addVertex('E', 2);
$graph->addVertex('F', 2);  // Target node
$graph->addVertex('G', 3);
$graph->addVertex('H', 3);
$graph->addVertex('I', 3);
$graph->addVertex('J', 3);

// Add edges based on the graph structure
$graph->addEdge('S', 'A');
$graph->addEdge('S', 'B');
$graph->addEdge('A', 'C');
$graph->addEdge('A', 'D');
$graph->addEdge('B', 'E');
$graph->addEdge('B', 'F');
$graph->addEdge('C', 'G');
$graph->addEdge('C', 'H');
$graph->addEdge('D', 'I');
$graph->addEdge('E', 'J');

// Perform IDDFS to find node 'F'
echo "Performing IDDFS to find node 'F':\n";
echo "---------------------------------\n";

$searchResult = $graph->iddfs('S', 'F');

// Output the DFS traversal
echo "\nSearch Results:\n";
echo "Target found: " . ($searchResult['success'] ? "Yes" : "No") . "\n";
echo "Final depth: " . $searchResult['final_depth'] . "\n\n";

// Print paths explored at each depth
foreach ($searchResult['paths'] as $depthResult) {
    echo "Depth " . $depthResult['depth_limit'] . ":\n";
    foreach ($depthResult['path'] as $node) {
        echo sprintf("  Node: %s (Level %d)\n",
            $node['vertex'],
            $node['level']
        );
    }
    echo "  Found: " . ($depthResult['found'] ? "Yes" : "No") . "\n\n";
}

// Example output for comparison with BFS
echo "BFS traversal for comparison:\n";
$bfsPath = $graph->bfs('S');
$graph->printPath($bfsPath);
echo "\n";

// Example output for comparison with DFS
echo "DFS traversal for comparison:\n";
$dfsPath = $graph->dfs('S', 'F');
$graph->printPath($dfsPath);
