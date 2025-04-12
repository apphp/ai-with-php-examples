<?php

// Example usage:
$weightMatrix = [[-1, 2], [1, -2]];  // Weight matrix W
$inputVector = [5, 3];             // Input vector x
$bias = [-10, 2];                  // Bias vector b

// Example usage with values that will produce both positive and negative results
$transform = new LinearTransformation($weightMatrix);

// Apply linear transformation with bias
$linearResult = $transform->linearLayer($inputVector, $bias);

// Apply ReLU activation
$activated = $transform->relu($linearResult);

echo "Original values: [<span id='output-vector'>" . implode(', ', $linearResult) . "</span>]\n";
echo "ReLU Output: [<span id='relu-vector'>" . implode(', ', $activated) . '</span>]';
