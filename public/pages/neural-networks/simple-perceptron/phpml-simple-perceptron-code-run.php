<?php

use app\classes\Chart;

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

<?= create_show_code_button('Basic Neural Network with PHP-ML', 'neural-networks', 'simple-perceptron', 'phpml-simple-perceptron'); ?>

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
        echo create_dataset_and_test_data_links(__DIR__ . '/data/exams.csv', $testData);
    ?>
</div>

<div class="container-fluid px-2">
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
                    predictionLabel: 'Test Data',
                    predictionSamples: $testSamples,
                );
                ?>
            </div>
        </div>
        <div class="col-md-12 col-lg-5 p-0 m-0">
            <?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>
        </div>
    </div>
</div>

