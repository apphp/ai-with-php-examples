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
        <br>
        The goal in this example here is to find the minimum point of a complex function with several local minima.
        It animates the optimization process step-by-step, showing accepted/rejected solutions, energy and temperature changes, and tracks the best-found solution. The goal is to illustrate how simulated annealing works through interactive visuals and graphs.
    </p>
</div>

<div class="py-4">
    <div class="row">
        <!-- Canvas container adjustments -->
        <div class="col-md-6">
            <div class="bg-lightgray p-3 rounded mb-4">
                <div class="mb-2 d-flex justify-content-between align-items-center">
                    <h3 class="fs-5 fw-semibold">Energy Landscape</h3>
                    <div class="small text-secondary">Step: <span id="step-counter">0 / 500</span></div>
                </div>

                <div class="canvas-container">
                    <canvas
                        id="landscape-canvas"
                        class="border rounded w-100"
                    ></canvas>
                </div>

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

            <div class="bg-lightgray p-3 mb-4 time-block-wrapper">
                <h3 class="fs-5 fw-semibold mb-2">Energy & Temperature Over Time</h3>

                <div class="canvas-container">
                    <canvas
                        id="graph-canvas"
                        class="border rounded w-100"
                    ></canvas>
                </div>
            </div>
        </div>

        <!-- Right panel - Controls and Info -->
        <div class="col-md-6">
            <div class="p-3 mb-3 bg-lightgray rounded">
                <h3 class="fs-5 fw-semibold mb-3">Algorithm Settings</h3>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="initial-temp" class="form-label small fw-medium">Initial Temp(°)</label>
                        <input type="number" class="form-control form-control-sm" id="initial-temp" value="1000" min="1" max="5000">
                    </div>
                    <div class="col-md-6">
                        <label for="cooling-rate" class="form-label small fw-medium">Cooling Rate</label>
                        <input type="number" class="form-control form-control-sm" id="cooling-rate" value="0.99" min="0.8" max="0.999" step="0.001">
                    </div>
                    <div class="col-md-6">
                        <label for="stop-temp" class="form-label small fw-medium">Stop Temp(°)</label>
                        <input type="number" class="form-control form-control-sm" id="stop-temp" value="0.1" min="0.01" max="10" step="0.01">
                    </div>
                    <div class="col-md-6">
                        <label for="initial-solution" class="form-label small fw-medium">Initial Solution</label>
                        <select class="form-select form-select-sm" id="initial-solution">
                            <option value="random" selected>Random</option>
                            <option value="leftmost">Leftmost</option>
                            <option value="rightmost">Rightmost</option>
                            <option value="center">Center</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="p-3 mb-4 bg-lightgray rounded">
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

                <div class="bg-info bg-opacity-10 p-3 border border-info border-opacity-25">
                    <p id="message-display" class="small mb-0">Click "Start" to begin the simulation</p>
                </div>
            </div>

            <div class="p-3 bg-lightgray rounded mb-4 d-flex flex-wrap gap-2 align-items-center">
                <button id="start-pause-btn" class="btn btn-success">
                    Start
                </button>

                <button id="reset-btn" class="btn btn-secondary">
                    Reset
                </button>

                <div class="d-flex align-items-center ms-2">
                    <span class="me-2 small fw-medium">Speed:</span>
                    <select id="speed-select" class="form-select form-select-sm">
                        <option value="0.1">0.1x</option>
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

            <div class="p-3 bg-lightgray rounded">
                <h3 class="fs-5 fw-semibold mb-2">Iteration Log</h3>
                <div id="algorithm-log" class="algorithm-log p-2 rounded"></div>
            </div>
        </div>
    </div>
</div>

<style>
    .canvas-container {
        width: 100%;
        position: relative;
    }

    /* Base styling for the algorithm interface */
    .algorithm-log {
        max-height: 250px;
        overflow-y: auto;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        font-family: monospace;
        font-size: 12px;
    }

    .log-entry-accepted {
        color: rgb(33, 37, 41);
        margin-bottom: 2px;
        background-color: rgba(0, 255, 0, 0.1);
        margin-bottom: 3px;
        padding: 3px;
    }

    .log-entry-rejected {
        color: rgb(33, 37, 41);
        margin-bottom: 2px;
        background-color: rgba(255, 115, 0, 0.1);
        margin-bottom: 3px;
        padding: 3px;
    }

    .log-entry-info {
        color: #0d6efd;
        margin-bottom: 2px;
        padding: 3px;
    }

    .log-entry-best {
        background-color: rgba(0, 255, 0, 0.2) !important;
        font-weight: bold;
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

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .canvas-container {
            min-height: 200px;
        }

        #landscape-canvas {
            min-height: 200px;
        }

        #graph-canvas {
            min-height: 100px;
        }

        .time-block-wrapper {
            padding-bottom: 0px !important;
        }
    }
</style>


<?php include('simulated-annealing-search-sample3-code-js.php'); ?>


