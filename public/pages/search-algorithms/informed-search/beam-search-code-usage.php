<?php

// Create the graph and add vertices with their levels
$graph = new InformedSearchGraph();

// Add vertices with their levels and heuristic values
// Format: vertex name, level, heuristic value
$graph->addVertex('A', 0, 0);  // Start node
$graph->addVertex('B', 1, 1);
$graph->addVertex('C', 1, 2);
$graph->addVertex('D', 1, 3);
$graph->addVertex('E', 2, 3);
$graph->addVertex('F', 2, 1);
$graph->addVertex('G', 3, 3);  // Goal node, h=0

// Add edges with their costs
// From level 0 to level 1
$graph->addEdge('A', 'B', 2.0);
$graph->addEdge('A', 'C', 1.0);
$graph->addEdge('A', 'D', 2.0);

// From level 1 to level 2
$graph->addEdge('B', 'E', 3.0);
$graph->addEdge('C', 'F', 2.0);

// From level 2 to level 3 (goal)
$graph->addEdge('E', 'G', 4.0);
$graph->addEdge('F', 'G', 3.0);
$graph->addEdge('D', 'G', 3.0);

// Try different beam widths
$beamWidths = [1, 2, 3];

// Perform greedy search from S to G
echo "Performing Beam Search from A to G:\n";
echo "------------------------------------\n\n";

// Init beam
$beam ??= 1;

foreach ($beamWidths as $width) {

    // Show only specified width
    if ($width != $beam){
        continue;
    }

    echo "Beam Search (width = $width):\n";
    echo "=========================\n";
    $searchResult = $graph->beamSearch('A', 'G', $width);

    if ($searchResult) {
        $graph->printPath($searchResult);
    } else {
        echo "No path found!\n";
    }
    echo "\n";
}

