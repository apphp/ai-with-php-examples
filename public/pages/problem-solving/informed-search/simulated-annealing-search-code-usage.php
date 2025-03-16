<?php

// Create a custom problem by extending the class
use app\classes\search\SimulatedAnnealing;

// Example usage
$sa = new SimulatedAnnealing(1000, 0.99, 0.1);
$optimalSolution = $sa->optimize(10);

echo "Optimal Solution: " . $optimalSolution . "\n";
