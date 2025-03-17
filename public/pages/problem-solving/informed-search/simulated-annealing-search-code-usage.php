<?php

// Create a custom problem by extending the class
use app\classes\search\SimulatedAnnealing;

// Example of usage
$resultDebug ??= false;
$coolingRate ??= 0.99;

$initialSolution = 9;
$sa = new SimulatedAnnealing(1000, $coolingRate, 0.1);
$optimalSolution = $sa->optimize($initialSolution, 5);

$debugResult = $resultDebug ? $sa->printIterationLog(detailed: true) : '--';

echo "Optimal Solution: " . $optimalSolution . "\n";
