<?php

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('phpml-simple-perceptron-code.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Basic Neural Network</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Basic Neural Network with PHP-ML</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-0">
            <a href="<?=create_href('neural-networks', 'simple-perceptron', 'phpml-simple-perceptron')?>" class="btn btn-sm btn-outline-primary">Show Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        Basic Neural Network with no hidden layers (simple perceptron)
    </p>
</div>

<div>
    <?php
        $testData = [
            'hours study,previous score',
            '6,82  // New student: 6 hours study, 82% previous score',
            '1,50  // New student: 1 hour study, 50% previous score'
        ];
        echo create_dataset_and_test_data_links(__DIR__ . '/exams.csv', $testData);
    ?>
</div>

<div class="container px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-7 px-1 pe-4">
            <p><b>Chart: Linear Separation</b></p>
            <div style="height:350px;">
                <?php
                echo Chart::drawLinearSeparation(
                    samples:  $samples,
                    labels: $labels,
                    separationBorder: 80,
                    classOneValue: 'pass',
                    classTwoValue: 'fail',
                    classOneLabel: 'Passed',
                    classTwoLabel: 'Failed',
                );
                ?>
            </div>
        </div>
        <div class="col-md-12 col-lg-5 p-0 m-0">
            <div class="mb-1">
                <b>Result:</b>
                <span class="float-end">Memory: <?= memory_usage($memoryEnd, $memoryStart); ?> Mb</span>
                <span class="float-end me-2">Time running: <?= running_time($microtimeEnd, $microtimeStart); ?> sec.</span>
            </div>
            <code class="code-result">
                <pre><?= $result; ?></pre>
            </code>
        </div>
    </div>
</div>

