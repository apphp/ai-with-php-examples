<?php

use app\classes\search\SimulatedAnnealing;

// Example of usage
$resultDebug ??= false;
$coolingRate ??= 0.99;
$stopTemperature ??= 0.1;

$initialSolution = 9;
$sa = new SimulatedAnnealing(1000, $coolingRate, $stopTemperature);
$optimalSolution = $sa->optimize($initialSolution, 5);

$debugResult = $resultDebug ? $sa->printIterationLog(detailed: true) : '--';

echo 'Optimal Solution: ' . $optimalSolution . "\n";
