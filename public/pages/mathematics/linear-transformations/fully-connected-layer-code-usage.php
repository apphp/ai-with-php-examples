<?php

// Example usage:
$weightMatrix = [[3, 2], [-1, 4]];  // Weight matrix W
$inputVector = [1, 2];              // Input vector x
$bias = [1, -2];                    // Bias vector b

$linearTransform = new LinearTransformation($weightMatrix);
$resultVector = $linearTransform->linearTransform($weightMatrix, $bias, $inputVector);

echo "Output after Fully Connected Layer: [<span id='output-vector'>" . implode(", ", $resultVector) . "</span>]";
