<?php

// Create the graph and add vertices with their levels
use app\classes\search\UninformedSearchGraph;

$graph = new UninformedSearchGraph();

// Add all vertices with their respective levels
$graph->addVertex('S', 0);  // Start node at level 0
$graph->addVertex('A', 1);
$graph->addVertex('B', 1);
$graph->addVertex('C', 2);
$graph->addVertex('D', 2);
$graph->addVertex('I', 2);
$graph->addVertex('J', 2);
$graph->addVertex('E', 3);
$graph->addVertex('F', 3);
$graph->addVertex('G', 3);
$graph->addVertex('H', 3);

// Add edges according to the graph structure
$graph->addEdge('S', 'A');
$graph->addEdge('S', 'B');
$graph->addEdge('A', 'C');
$graph->addEdge('A', 'D');
$graph->addEdge('B', 'I');
$graph->addEdge('B', 'J');
$graph->addEdge('C', 'E');
$graph->addEdge('C', 'F');
$graph->addEdge('D', 'G');
$graph->addEdge('I', 'H');

// Try DLS with different depth limits
$depths = [1, 2, 3];

echo "DLS traversal starting from vertex 'S':\n";
echo "--------------------------------------\n";

foreach ($depths as $maxDepth) {
    echo "\nTrying DLS with max depth = $maxDepth to find node 'J':\n";
    $searchResult = $graph->dls('S', $maxDepth, 'J');

    echo $searchResult['found']
        ? "✓ Target 'J' found within depth limit!\n"
        : "✗ Target 'J' not found within depth limit of {$searchResult['maxDepth']}\n";

    echo "Path explored:\n";
    foreach ($searchResult['path'] as $node) {
        echo sprintf(
            "  Node: %s (Level %d, Search Depth %d)\n",
            $node['vertex'],
            $node['level'],
            $node['depth']
        );
    }
}
