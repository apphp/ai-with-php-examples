<?php

use app\classes\Graph;

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Informed (Heuristic) Search</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Simulated Annealing Search <small>(process visualization)</small></h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?= create_href('problem-solving', 'informed-search', 'simulated-annealing-search-sample3') ?>" class="btn btn-sm btn-outline-primary">Show
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
    <!--    --><?php //= create_example_of_use_links(__DIR__ . '/simulated-annealing-search-code-usage.php'); ?>
</div>



<div class="_container py-4">
<!--    <div id="root"></div>-->

    <div class="row">
        <div class="col-md-6">
            <div class="bg-white p-3 rounded mb-4">
                <div class="mb-2 d-flex justify-content-between align-items-center">
                    <h3 class="fs-5 fw-semibold">Energy Landscape</h3>
                    <div class="small text-secondary">Step: <span id="step-counter">0 / 500</span></div>
                </div>

                <canvas
                    id="landscape-canvas"
                    class="border rounded"
                ></canvas>

                <div class="row row-cols-2 row-cols-md-4 g-2 mt-2 small">
                    <div class="col">
                        <div class="legend-item">
                            <div class="legend-marker" style="background-color: #FF0000;"></div>
                            <span>Current Solution</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="legend-item">
                            <div class="legend-marker" style="background-color: #008000;"></div>
                            <span>Best Solution</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="legend-item">
                            <div class="legend-marker" style="background-color: #FF0000; opacity: 0.5;"></div>
                            <span>Local Minima</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="legend-item">
                            <div class="legend-marker" style="background-color: #0000FF; opacity: 0.7;"></div>
                            <span>Global Minimum</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-3 mb-4">
                <h3 class="fs-5 fw-semibold mb-2">Energy & Temperature Over Time</h3>
                <canvas
                    id="graph-canvas"
                    class="border rounded"
                ></canvas>
            </div>
        </div>

        <!-- Right panel - Controls and Info -->
        <div class="col-md-6">
            <div class="bg-white p-3 mb-4">
                <h3 class="fs-5 fw-semibold mb-2">Algorithm Status</h3>

                <div class="row row-cols-1 row-cols-md-2 g-3 mb-3">
                    <div class="col">
                        <p class="small fw-medium mb-1">Temperature:</p>
                        <div class="d-flex align-items-center">
                            <div class="progress flex-grow-1" style="height: 8px;">
                                <div
                                    id="temperature-bar"
                                    class="progress-bar bg-danger"
                                    style="width: 100%;"
                                ></div>
                            </div>
                            <span id="temperature-value" class="ms-2 small">1000.00</span>
                        </div>
                    </div>

                    <div class="col">
                        <p class="small fw-medium mb-1">Current Energy:</p>
                        <div id="current-energy" class="fs-5 fw-semibold">0.00</div>
                    </div>

                    <div class="col">
                        <p class="small fw-medium mb-1">Best Energy:</p>
                        <div id="best-energy" class="fs-5 fw-semibold text-success">0.00</div>
                    </div>

                    <div class="col">
                        <p class="small fw-medium mb-1">Acceptance Probability:</p>
                        <div class="fs-6">
                            P = e<sup>-ΔE/T</sup> = e<sup>-(E<sub>new</sub>-E<sub>current</sub>)/T</sup>
                        </div>
                    </div>
                </div>

                <div class="bg-info bg-opacity-10 p-3 rounded border border-info border-opacity-25">
                    <p id="message-display" class="small mb-0">Click "Start" to begin the simulation</p>
                </div>
            </div>

            <div class="mb-4 d-flex flex-wrap gap-2 align-items-center">
                <button
                    id="start-pause-btn"
                    class="btn btn-success"
                >
                    Start
                </button>

                <button
                    id="reset-btn"
                    class="btn btn-secondary"
                >
                    Reset
                </button>

                <div class="d-flex align-items-center ms-2">
                    <span class="me-2 small fw-medium">Speed:</span>
                    <select
                        id="speed-select"
                        class="form-select form-select-sm"
                    >
                        <option value="0.25">0.25x</option>
                        <option value="0.5">0.5x</option>
                        <option value="0.75">0.75x</option>
                        <option value="1" selected>1x</option>
                        <option value="1.5">1.5x</option>
                        <option value="2">2x</option>
                        <option value="3">3x</option>
                        <option value="5">5x</option>
                        <option value="10">10x</option>
                    </select>
                </div>
            </div>

            <div class="bg-light bg-opacity-75 p-3 rounded border mb-4">
                <h3 class="fs-5 fw-semibold mb-2">How Simulated Annealing Works</h3>
                <div class="small">
                    <p>
                        <strong>1. High Temperature Phase:</strong> The algorithm explores widely,
                        accepting many worse solutions to escape local minima.
                    </p>
                    <p>
                        <strong>2. Cooling Process:</strong> As temperature decreases, the algorithm becomes
                        more selective about which solutions to accept.
                    </p>
                    <p>
                        <strong>3. Convergence:</strong> At low temperatures, the algorithm converges to
                        a near-optimal solution, making only small adjustments.
                    </p>
                    <p class="mb-0">
                        <strong>Key Insight:</strong> The acceptance probability (P = e<sup>-ΔE/T</sup>) allows the
                        algorithm to escape local minima while eventually settling in a good solution.
                    </p>
                </div>
            </div>

            <div id="algorithm-log" class="algorithm-log p-3 rounded shadow-inner"></div>
        </div>
    </div>
</div>

<style>
    .algorithm-log {
        max-height: 250px;
        overflow-y: auto;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        font-family: monospace;
        font-size: 0.8rem;
    }

    .log-entry-accepted {
        color: #28a745;
        margin-bottom: 2px;
    }

    .log-entry-rejected {
        color: #dc3545;
        margin-bottom: 2px;
    }

    .log-entry-info {
        color: #0d6efd;
        margin-bottom: 2px;
    }

    .shadow-inner {
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.06);
    }

    .legend-item {
        display: flex;
        align-items: center;
        font-size: 0.8rem;
    }

    .legend-marker {
        width: 12px;
        height: 12px;
        margin-right: 6px;
        border-radius: 2px;
    }
</style>


<?php include('simulated-annealing-search-sample3-code-js.php'); ?>


