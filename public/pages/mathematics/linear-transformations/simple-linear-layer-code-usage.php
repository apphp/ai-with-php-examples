<?php

// Example usage:
$weightMatrix = [[2, -1], [1, 3]];  // Weights
$bias = [1, 0];             // Biases
$inputVector = [1, 2];             // Input

$linearTransform = new LinearTransformation($weightMatrix);
$result = $linearTransform->linearLayer($inputVector, $bias);
echo "Output after Linear Layer: [<span id='output-vector'>" . implode(", ", $result) . "</span>]";
