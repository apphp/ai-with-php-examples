<?php
    include_once('scalars-code.php');

$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

// Examples
$a = 5;
$b = 2;
$vector = [1, 2, 3];
$angle = M_PI / 4;

// Arithmetic Operations
echo "Arithmetic Operations:\n---------\n";
print_r(Scalar::arithmeticOperations($a, $b));
echo "\n";

// Scalar-Vector Operations
echo "Scalar-Vector Multiplication:\n---------\n";
print_r(Scalar::scalarVectorMultiplication(2, $vector));
echo "\n";

echo "Scalar-Vector Addition:\n---------\n";
print_r(Scalar::scalarVectorAddition(2, $vector));
echo "\n";

// Scalar Functions
echo "Scalar Functions:\n---------\n";
print_r(Scalar::scalarFunctions(-3.7));
echo "\n";

// Trigonometric Operations
echo "Trigonometric Operations:\n---------\n";
print_r(Scalar::trigonometricOperations($angle));
echo "\n";

// Random Number Generation
echo "Random Number Generation:\n---------\n";
print_r(Scalar::randomNumbers());
echo "\n";

// Comparison Operations
echo "Comparison Operations:\n---------\n";
print_r(Scalar::comparisonOperations($a, $b));
echo "\n";

// Bitwise Operations
echo "Bitwise Operations:\n---------\n";
print_r(Scalar::bitwiseOperations($a, $b));


//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Scalars</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="index.php?section=mathematics&subsection=scalars&page=index" class="btn btn-sm btn-outline-primary">Show Code</a>
        </div>
    </div>
</div>

<div>
    <h2 class="h4">Scalar Operations with PHP</h2>
    <p>
        In PHP it can be written as a class Scalar with implementation of a set of scalar operations.
        This class is a PHP implementation of scalar operations commonly used in linear algebra and, by extension, in various AI and machine learning
        algorithms. It provides a robust set of methods for performing vectors calculations, making it a valuable tool for developers working on AI
        projects in PHP.
    </p>
</div>

<div>
    Result:
    <span class="float-end">Time running: <?= running_time($microtimeEnd, $microtimeStart); ?> sec.</span>
    <div class="bd-clipboard">
        <button id="copyButton" type="button" class="btn-clipboard" onclick="copyToClipboard()">
            Copy
        </button>
        &nbsp;
    </div>
    <code id="code" class="code-result">
        <pre><?= $result; ?></pre>
    </code>
</div>
