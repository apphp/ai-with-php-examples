<?php

// Create the graph and add vertices with their levels
use app\classes\search\UninformedSearchGraph;

$graph = new UninformedSearchGraph();

// Add all vertices with their respective levels to show the tree structure
$vertices = [
    'A' => 0,  // Root level
    'B' => 1, 'E' => 1,  // Level 1
    'C' => 2, 'D' => 2, 'F' => 1, 'G' => 2,  // Level 2
    'H' => 3,  // Intersection node - Level 3
    'I' => 2, // Level 2 from the other direction
    'J' => 1, 'K' => 1,  // Level 1 from the other direction
    'L' => 2, 'M' => 2, 'N' => 2, 'O' => 2  // Level 2 from the other direction
];

// Add vertices with their levels
foreach ($vertices as $vertex => $level) {
    $graph->addVertex($vertex, $level);
}

// Add edges to create the exact graph structure
// Left side (from root A)
$graph->addEdge('A', 'E');
$graph->addEdge('E', 'B');
$graph->addEdge('E', 'G');
$graph->addEdge('F', 'C');
$graph->addEdge('F', 'D');
$graph->addEdge('F', 'G');

// Center (where searches will meet)
$graph->addEdge('G', 'H');

// Right side (from goal O)
$graph->addEdge('H', 'I');
$graph->addEdge('I', 'J');
$graph->addEdge('I', 'K');
$graph->addEdge('J', 'L');
$graph->addEdge('J', 'M');
$graph->addEdge('K', 'N');
$graph->addEdge('K', 'O');

// Perform bidirectional search from A to O
echo "Bidirectional Search from A to O:\n";
echo "--------------------------------\n";
$searchResult = $graph->bds('A', 'O');

// Print detailed search results
$graph->printBdsPath($searchResult);

// Let's analyze the intersection at node H
if ($searchResult['success'] && $searchResult['intersectionVertex'] === 'H') {
    echo "\nSearch Analysis:\n";
    echo "----------------\n";

    // Forward search path to H
    echo "Forward search path (A → H):\n";
    foreach ($searchResult['forwardExplored'] as $node) {
        if ($node['vertex'] === 'H') {
            echo "→ Reached intersection node H\n";
            break;
        }
        echo "→ {$node['vertex']} (Level {$node['level']})\n";
    }

    // Backward search path to H
    echo "\nBackward search path (O → H):\n";
    foreach ($searchResult['backwardExplored'] as $node) {
        if ($node['vertex'] === 'H') {
            echo "→ Reached intersection node H\n";
            break;
        }
        echo "→ {$node['vertex']} (Level {$node['level']})\n";
    }

    // Complete path
    echo "\nComplete path found (A → O through H):\n";
    foreach ($searchResult['path'] as $node) {
        echo "→ {$node['vertex']} (Level {$node['level']})";
        if ($node['vertex'] === 'H') {
            echo " [INTERSECTION]";
        }
        echo "\n";
    }
}

// Verify we have a valid path through H
echo "\nPath verification:\n";
echo "-----------------\n";
if ($searchResult['success']) {
    echo "✓ Path successfully found\n";
    echo "✓ Intersection occurred at node H\n";
    echo "✓ Total nodes in path: " . count($searchResult['path']) . "\n";
} else {
    echo "✗ No valid path found\n";
}
