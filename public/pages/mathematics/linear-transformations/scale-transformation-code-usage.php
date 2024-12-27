<?php

// Example 1: 2x2 matrix (scale transformation)
$scale = [
    [2, 0],
    [0, 3]
];

$vector2D = [1, 2];

$transformation2D = new LinearTransformation($scale);
$result2D = $transformation2D->transform($vector2D);

echo "2D Transformation Result: [" . implode(", ", $result2D) . "]\n";
