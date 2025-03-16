<?php

use app\classes\Chart;
use app\classes\search\SearchVisualizer;

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);

$availableTypes = ['Simple' => 'simple', 'Steepest Ascent' => 'steepest', 'Stochastic' => 'stochastic'];
$searchType = isset($_GET['searchType']) && is_string($_GET['searchType']) ? $_GET['searchType'] : '';
verify_fields($searchType, array_values($availableTypes), reset($availableTypes));

ob_start();
//////////////////////////////

include('simulated-annealing-search-code-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Informed (Heuristic) Search</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Simulated Annealing Search</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?= create_href('problem-solving', 'informed-search', 'simulated-annealing-search') ?>" class="btn btn-sm btn-outline-primary">Show
                Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        Simulated Annealing (SA) is an optimization algorithm inspired by the annealing process in metallurgy, where materials are heated and slowly
        cooled to reach a stable state with minimal energy. It is used to find approximate solutions to optimization problems by iteratively exploring
        potential solutions and occasionally accepting worse solutions to escape local optima.
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/simulated-annealing-search-code-usage.php'); ?>
</div>


<div class="container-fluid px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-7 px-1 pe-4">

            <canvas id="myChart"></canvas>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    const ctx = document.getElementById('myChart').getContext('2d');

                    // Generate x values from -10 to 10
                    const xValues = [];
                    const yValues = [];
                    for (let x = -10; x <= 10; x += 0.5) {
                        xValues.push(x);
                        yValues.push(x * x);
                    }

                    // Special point
                    const specialPoint = { x: <?=$optimalSolution?>, y: <?=$optimalSolution^2?> }; // Example: (3, 9)

                    new Chart(ctx, {
                        type: 'scatter',
                        data: {
                            datasets: [
                                {
                                    label: 'y = x²',
                                    data: xValues.map((x, i) => ({ x, y: yValues[i] })),
                                    borderColor: 'blue',
                                    showLine: true,
                                    fill: false,
                                    tension: 0.2
                                },
                                {
                                    label: 'Best Solution',
                                    data: [specialPoint],
                                    backgroundColor: 'red',
                                    pointRadius: 6
                                }
                            ]
                        },
                        options: {
                            scales: {
                                x: { type: 'linear', position: 'bottom' },
                                y: { type: 'linear' }
                            }
                        }
                    });
                });
            </script>

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
