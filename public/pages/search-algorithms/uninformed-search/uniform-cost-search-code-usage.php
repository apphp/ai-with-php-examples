<?php

// Create the graph and add vertices with their levels
$graph = new Graph();

// Add all vertices with their respective levels
$graph->addVertex('S', 0); // Starting node at level 0
$graph->addVertex('A', 1);
$graph->addVertex('B', 1);
$graph->addVertex('C', 2);
$graph->addVertex('D', 2);
$graph->addVertex('E', 3);
$graph->addVertex('F', 3);
$graph->addVertex('G', 4); // There are multiple G nodes in different levels, but we'll use the target G

// Add edges with their weights according to the diagram
$graph->addEdge('S', 'A', 1);
$graph->addEdge('S', 'B', 4);
$graph->addEdge('A', 'C', 3);
$graph->addEdge('A', 'D', 2);
$graph->addEdge('B', 'G', 5);
$graph->addEdge('C', 'E', 5);
$graph->addEdge('D', 'F', 4);
$graph->addEdge('D', 'G', 3);
$graph->addEdge('E', 'G', 5);

// Perform UCS from S to G
echo "UCS traversal starting from vertex 'S':\n";
$result = $graph->ucs('S', 'G');

// Print the result
echo "\nUCS Path Result:\n";
$graph->printUcsPath($result);

echo "\nThe output should show S -> A -> D -> G as the optimal path";
echo "\nwith a total cost of 1 + 2 + 3 = 6";

