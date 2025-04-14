<?php

echo 'Creating Tensors:';
echo "\n---------\n";

// Create a scalar (0D tensor)
$scalar = new Tensor([[5]]);
echo "\nScalar: ";
print_r($scalar->getData());

// Create a vector (1D tensor)
$vector = new Tensor([1, 2, 3, 4]);
echo "\nVector: ";
print_r($vector->getData());

// Create a matrix (2D tensor)
$matrix = new Tensor([
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9],
]);

echo "\n\nMatrix: ";
echo "\n---------\n";
print_r($matrix->getData());

// Create a 3D tensor
$tensor3D = new Tensor([
    [
        [1, 2],
        [3, 4],
    ],
    [
        [5, 6],
        [7, 8],
    ],
]);

echo "\n\n3D Tensor: ";
echo "\n---------\n";
print_r($tensor3D->getData());
