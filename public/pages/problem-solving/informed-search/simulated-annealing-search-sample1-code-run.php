<?php

use app\classes\Graph;

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);

$resultDebugOptions = ['Debug' => '1'];
$resultDebug = isset($_GET['resultDebug']) && is_string($_GET['resultDebug']) ? $_GET['resultDebug'] : '';
verify_fields($resultDebug, array_values($resultDebugOptions), '');

$coolingRateOptions = ['Cooling' => range(0.99, 0.09, -0.01)];
$coolingRate = $_GET['coolingRate'] ?? '';
$roundedArray = array_map(fn($v) => round($v, 2), $coolingRateOptions['Cooling']);
verify_fields($coolingRate, $roundedArray, 0.99);

$stopTemperatureOptions = ['Stop T&deg;' => range(99, 0.09, -0.1)];
$stopTemperature = $_GET['stopTemperature'] ?? '';
$roundedArray = array_map(fn($v) => round($v, 1), $stopTemperatureOptions['Stop T&deg;']);
$stopTemperatureOptions = ['Stop T&deg;' => $roundedArray];
verify_fields($stopTemperature, $roundedArray, 0.1);

ob_start();
//////////////////////////////

include('simulated-annealing-search-sample1-code-usage.php');

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
            <a href="<?= create_href('problem-solving', 'informed-search', 'simulated-annealing-search-sample1') ?>" class="btn btn-sm btn-outline-primary">Show
                Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        Simulated Annealing (SA) is an optimization algorithm inspired by the annealing process in metallurgy, where materials are heated and slowly
        cooled to reach a stable state with minimal energy. It is used to find approximate solutions to optimization problems by iteratively exploring
        potential solutions and occasionally accepting worse solutions to escape local optima.
        <br>
        The goal in this example here is to find the minimum point of $f(x) = x²$, which is clearly at $x = 0$, where the function value is also $0$.
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/simulated-annealing-search-sample1-code-usage.php'); ?>
</div>


<div class="container-fluid px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-7 px-1 pe-4">
            <?php
                echo Graph::drawQuadraticFunction([
                    ['x' => $initialSolution, 'label' => 'Initial Solution'],
                    ['x' => $optimalSolution, 'label' => 'Optimal Solution']
                ]);
            ?>
        </div>

        <div class="col-md-12 col-lg-5 p-0 m-0">
            <div>
                <div>
                    <b>Result Format:</b>
                </div>
                <form class="mt-2" action="<?= APP_SEO_LINKS ? create_href('problem-solving', 'informed-search', 'simulated-annealing-search-sample1-code-run') : 'index.php'; ?>" type="GET">
                    <?= !APP_SEO_LINKS ? create_form_fields('problem-solving', 'informed-search', 'simulated-annealing-search-code-run') : ''; ?>
                    <?= create_form_features($coolingRateOptions, [$coolingRate], fieldName: 'coolingRate', type: 'number', step: 0.01, precisionCompare: true, class: 'w-20', initId: 0); ?>
                    <?= create_form_features($stopTemperatureOptions, [$stopTemperature], fieldName: 'stopTemperature', type: 'number', step: 0.1, precisionCompare: true, class: 'w-20', style: 'width:55px;', initId: 1); ?>
                    <?= create_form_features($resultDebugOptions, [$resultDebug], fieldName: 'resultDebug', type: 'single-checkbox', class: ''); ?>

                    <div class="form-check form-check-inline float-end p-0 m-0 me-1">
                        <button type="submit" class="btn btn-sm btn-outline-primary">Re-generate</button>
                    </div>
                    <div class=" clearfix "></div>
                </form>
            </div>

            <hr>

            <?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, showResult: false); ?>
            <code class="_code-result">
                <pre>Start temprature: 1000&deg;<br>Stop temprature: <?=$stopTemperature?>&deg;<br>Cooling Rate: <?=$coolingRate?><br><?= $result; ?></pre>
            </code>

            <div class="mb-1">
                <b>Debug:</b>
            </div>
            <code class="code-result" id="expandable-div">
                <!-- Expand button -->
                <?php if($resultDebug && $debugResult !== '--'): ?>
                    <div class="bd-fullscreen cursor-pointer">
                        <i id="expandable-div-icon" class="fas fa-expand fa-inverse" title="Open in Full Screen"></i>
                    </div>
                <?php endif; ?>
                <pre class="pre-wrap" id="expandable-pre-wrap" style="<?=$resultDebug ? 'min-height:100px; max-height:1000px' : ''?>"><?= $debugResult; ?></pre>
            </code>
        </div>

    </div>
</div>
