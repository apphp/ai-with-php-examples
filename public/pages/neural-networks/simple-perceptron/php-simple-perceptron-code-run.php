<?php

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('data/digits.php');
include('php-simple-perceptron-code.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Basic Neural Network</h1>
</div>

<?= create_show_code_button('Basic Neural Network with Pure PHP', 'neural-networks', 'simple-perceptron', 'php-simple-perceptron'); ?>

<div>
    <p>
        Basic Neural Network with no hidden layers (simple perceptron)
    </p>
</div>

<div class="row">
    <?php
//        echo "<h3>Testing the perceptron:</h3>";
        echo '<div class="col me-4">';
        echo '<div class="d-flex">Valid Digit 5 (five)</div>';
        echo '<div class="d-flex" style="border: 1px solid #ccc">';
        foreach ($digit5Variants as $index => $test) {
            echo "<div>";
            displayDigit($test);
            echo "</div>";
        }
        echo "</div>";
        echo "</div>";

    echo '<div class="col me-4">';
        echo '<div class="d-flex">Not Valid Digit 5 (five)</div>';
        echo '<div class="d-flex" style="border: 1px solid #ccc">';
        foreach ($nonDigit5Variants as $index => $test) {
            echo "<div>";
            displayDigit($test);
            echo "</div>";
        }
    echo "</div>";
    echo "</div>";

    echo '<div class="col me-4">';
    echo '<div class="d-flex">Testing Digits</div>';
    echo '<div class="d-flex" style="border: 1px solid #ccc">';
        foreach ($testCases as $index => $test) {
            echo "<div>";
            displayDigit($test);
            echo "</div>";
        }
    echo "</div>";
    echo "</div>";
//        $testData = [
//            'hours study,previous score',
//            '6,82  // New student: 6 hours study, 82% previous score',
//            '1,50  // New student: 1 hour study, 50% previous score'
//        ];
//        echo create_dataset_and_test_data_links(__DIR__ . '/data/exams.csv', $testData);
    ?>
</div>



<br>

<div class="mb-1">
    <b>Result:</b>
    <span class="float-end">Memory: <?= memory_usage($memoryEnd, $memoryStart); ?> Mb</span>
    <span class="float-end me-2">Time running: <?= running_time($microtimeEnd, $microtimeStart); ?> sec.</span>
</div>
<code class="code-result">
    <pre><?= $result; ?></pre>
</code>

