<?php
    include_once('vectors-code.php');
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Vectors</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="index.php?section=mathematics&subsection=vectors&page=index" class="btn btn-sm btn-outline-primary">Show Code</a>
        </div>
    </div>
</div>

<div>
    <h2 class="h4">Vector Operations with PHP</h2>
    <p>
        In PHP it can be written as a class Vector with implementation of a set of vector operations.
        This class is a PHP implementation of vector operations commonly used in linear algebra and, by extension, in various AI and machine learning
        algorithms. It provides a robust set of methods for performing vectors calculations, making it a valuable tool for developers working on AI
        projects in PHP.
    </p>
</div>

<div>
    Result:

    <div class="bd-clipboard">
        <button id="copyButton" type="button" class="btn-clipboard" onclick="copyToClipboard()">
            Copy
        </button>
        &nbsp;
    </div>
    <code id="code" class="code-result">
        <pre>
<?php
    // Example usage
    $v1 = new Vector([2, 3]);
    $v2 = new Vector([1, -1]);

    // Addition and Subtraction (from previous example)
    $sum = $v1->add($v2);
    echo "Addition: $v1 + $v2 = $sum\n";

    $difference = $v1->subtract($v2);
    echo "Subtraction: $v1 - $v2 = $difference\n";

    // Scalar Multiplication
    $scalar = 3;
    $v3 = new Vector([2, -1]);
    $scalarProduct = $v3->scalarMultiply($scalar);
    echo "Scalar Multiplication: $scalar * $v3 = $scalarProduct\n";

    // Dot Product
    $v4 = new Vector([1, 2]);
    $v5 = new Vector([3, 4]);
    $dotProduct = $v4->dotProduct($v5);
    echo "Dot Product: $v4 · $v5 = $dotProduct\n";

    // Cross Product
    $v6 = new Vector([1, 0, 0]);
    $v7 = new Vector([0, 1, 0]);
    $crossProduct = $v6->crossProduct($v7);
    echo "Cross Product: $v6 × $v7 = $crossProduct";
?>
        </pre>
    </code>
</div>
