<?php

// Create a custom problem by extending the class
use app\classes\search\SimulatedAnnealing;

// Example usage
$initialSolution = 9;
$sa = new SimulatedAnnealing(1000, 0.99, 0.1);
$optimalSolution = $sa->optimize($initialSolution, 5);

$resultDebug ??= false;
$debugResult = $resultDebug ? $sa->printIterationLog(detailed: true) : '--';

echo "Optimal Solution: " . $optimalSolution . "\n";
