<?php

// Create the graph and add vertices with their levels
$graph = new InformedSearchGraph();

// Add vertices with their heuristic values
$graph->addVertex('A', 0, 1);  // Root node with h=1
$graph->addVertex('B', 1, 1);  // h=1 (not shown in image but inferred)
$graph->addVertex('C', 1, 3);  // h=3
$graph->addVertex('D', 2, 2);  // h=2
$graph->addVertex('E', 2, 2);  // h=2
$graph->addVertex('F', 2, 3);  // h=3
$graph->addVertex('G', 2, 0);  // h=0 (goal node)

// Add edges
$graph->addEdge('A', 'B');
$graph->addEdge('A', 'C');
$graph->addEdge('B', 'D');
$graph->addEdge('B', 'E');
$graph->addEdge('C', 'F');
$graph->addEdge('C', 'G');

// Print the initial graph structure
echo "Graph structure:\n";
$graph->printGraph();
echo "\n";

// Try beam search with width = 2
echo "Attempting beam search with beam width = 2...\n";
$path = $graph->beamSearch('A', 'G', 2);

if ($path === null) {
    echo "Beam search failed to find the goal node G!\n";
    echo "\nHere's why:\n";
    echo "1. Start at A: OPEN = {A}\n";
    echo "2. Expand A → {B(h=1), C(h=3)}, both kept since beam width = 2\n";
    echo "3. Expand B, C → {D(h=2), E(h=2)} from B, and {F(h=3), G(h=0)} from C\n";
    echo "4. Keep only 2 best by heuristic: {D(h=2), E(h=2)}, G is discarded!\n";
    echo "5. Continue with D, E but no path to G exists from these nodes\n";
} else {
    echo "Path found:\n";
    $graph->printPath($path);
}

// Try with beam width = 3 to show it can work with larger width
echo "\nTrying again with beam width = 3...\n";
$path = $graph->beamSearch('A', 'G', 3);

if ($path !== null) {
    echo "Path found:\n";
    $graph->printPath($path);
}

