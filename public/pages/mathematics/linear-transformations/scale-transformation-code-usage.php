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

//// Example 2: 3x3 matrix
//$matrix3D = [
//    [1, 0, 2],
//    [0, 3, 1],
//    [2, 1, 1]
//];
//$vector3D = [1, 2, 3];
//
//$transformation3D = new LinearTransformation($matrix3D);
//$result3D = $transformation3D->transform($vector3D);
//echo "3D Transformation Result: [" . implode(", ", $result3D) . "]\n";
//
//// Example 3: 2x3 matrix (projection)
//$projection = [
//    [1, 2, 1],
//    [0, 1, 2]
//];
//$vector3to2 = [1, 2, 3];
//
//$transformationProj = new LinearTransformation($projection);
//$resultProj = $transformationProj->transform($vector3to2);
//echo "Projection Result: [" . implode(", ", $resultProj) . "]\n";
//

