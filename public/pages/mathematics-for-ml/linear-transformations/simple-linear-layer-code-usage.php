<?php

// Example usage:
$weightMatrix = [[2, -1], [1, 3]];  // Weight matrix W
$inputVector = [1, 2];              // Input vector x
$bias = [1, 0];                     // Bias vector b

$linearTransform = new LinearTransformation($weightMatrix);
$resultVector = $linearTransform->linearLayer($inputVector, $bias);

echo "Output after Linear Layer: [<span id='output-vector'>" . implode(', ', $resultVector) . '</span>]';
