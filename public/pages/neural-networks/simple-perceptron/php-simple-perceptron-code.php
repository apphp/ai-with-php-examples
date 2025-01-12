<?php

class Perceptron {
    private $weights;
    private $bias;
    private $learningRate;

    public function __construct($inputSize = 25, $learningRate = 0.01) { // Reduced learning rate
        // Initialize weights with smaller random values
        $this->weights = array_map(function() {
            return rand(-5, 5) / 10; // Smaller initial weights
        }, array_fill(0, $inputSize, 0));

        $this->bias = rand(-5, 5) / 10;
        $this->learningRate = $learningRate;
    }

    private function activate($sum) {
        // Step function
        return $sum >= 0 ? 1 : 0;
    }

    public function predict($input) {
        if (is_array($input[0])) {
            $input = array_merge(...$input);
        }

        $sum = $this->bias;
        for ($i = 0; $i < count($input); $i++) {
            $sum += $input[$i] * $this->weights[$i];
        }

        return $this->activate($sum);
    }

    public function train($input, $target, $epochs = 1000) { // Increased epochs
        if (is_array($input[0])) {
            $input = array_merge(...$input);
        }

        for ($epoch = 0; $epoch < $epochs; $epoch++) {
            $prediction = $this->predict($input);
            $error = $target - $prediction;

            // Update weights only if there's an error
            if ($error != 0) {
                for ($i = 0; $i < count($input); $i++) {
                    $this->weights[$i] += $this->learningRate * $error * $input[$i];
                }
                $this->bias += $this->learningRate * $error;
            }
        }
    }

    // Added method to get current weights for debugging
    public function getWeights() {
        return $this->weights;
    }
}



// Initialize perceptron
$perceptron = new Perceptron(25, 0.01);

// Training cycle
$trainingCycles = 10; // Number of complete training cycles
for ($cycle = 0; $cycle < $trainingCycles; $cycle++) {
    // Train with all variants of 5
    foreach ($digit5Variants as $index => $digit5) {
        $perceptron->train($digit5, 1, 1000);
        //echo "Training cycle $cycle, 5-variant $index completed\n";
    }

    // Train with all non-5 digits
    foreach ($nonDigit5Variants as $index => $nonDigit5) {
        $perceptron->train($nonDigit5, 0, 1000);
        //echo "Training cycle $cycle, non-5-variant $index completed\n";
    }
}


// Function to display the digit pattern
function displayDigit($digit) {
    echo '<div style="font-family: monospace; line-height:0.9; background: #f0f0f0; padding: 0px; display: inline-block; margin: 5px;">';
    foreach ($digit as $row) {
        foreach ($row as $cell) {
            echo '<span style="background-color: ' . ($cell ? '#009bd6' : '#f2f2f2') . ';">&nbsp;</span>';
        }
        echo '<br>';
    }
    echo '</div>';
}

// Run tests
echo "\nTesting the perceptron:\n";
foreach ($testCases as $index => $test) {
    echo "Test case " . ($index + 1) . ":\n";
    displayDigit($test);
    $result = $perceptron->predict($test) ? 'Yes' : 'No';
    echo "Prediction: " . $result . "\n\n";
}



// Debug information
//echo "Final weights:\n";
//print_r($perceptron->getWeights());
