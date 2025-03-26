<?php

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Informed (Heuristic) Search</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Simulated Annealing Search <small>(process visualization)</small></h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?= create_href('problem-solving', 'informed-search', 'simulated-annealing-search-sample2') ?>" class="btn btn-sm btn-outline-primary">Show
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
<!--    --><?php //= create_example_of_use_links(__DIR__ . '/simulated-annealing-search-code-usage.php'); ?>
</div>

<div class="column-layout">
    <!-- Left Column -->
    <div class="left-column">
        <div class="panel">
            <h3 class="h5">Objective Function: f(x) = x²</h3>
            <div class="legend">
                <div class="legend-item">
                    <div class="legend-color" style="background-color: #00ff00;"></div>
                    <span>Accepted moves</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background-color: #ff7300;"></div>
                    <span>Rejected moves</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background-color: #ff0000;"></div>
                    <span>Current solution</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background-color: #2196f3;"></div>
                    <span>Best solution</span>
                </div>
            </div>
            <div class="canvas-container">
                <canvas id="functionCanvas"></canvas>
            </div>
        </div>

        <div class="panel">
            <h3 class="h5">Temperature & Energy Over Time</h3>
            <div class="legend">
                <div class="legend-item">
                    <div class="legend-color" style="background-color: #8884d8;"></div>
                    <span>Temperature</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background-color: #82ca9d;"></div>
                    <span>Energy</span>
                </div>
            </div>
            <div class="canvas-container">
                <canvas id="temperatureCanvas"></canvas>
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="right-column">
        <div class="panel">
            <h3 class="h5">Parameters</h3>
            <div class="grid">
                <div class="form-group">
                    <label for="initialTemperature">Initial Temp(&deg;)</label>
                    <input
                        type="number"
                        id="initialTemperature"
                        title="Initial Temperature"
                        value="1000"
                        step="1"
                        min="1"
                        max="2000"
                    />
                </div>
                <div class="form-group">
                    <label for="coolingRate">Cooling Rate</label>
                    <input
                        type="number"
                        id="coolingRate"
                        title="Cooling Rate"
                        value="0.99"
                        step="0.01"
                        min="0.01"
                        max="1"
                    />
                </div>
                <div class="form-group">
                    <label for="stopTemperature">Stop Temp(&deg;)</label>
                    <input
                        type="number"
                        id="stopTemperature"
                        title="Stop Temperature"
                        step="0.1"
                        value="0.1"
                        min="0.1"
                        max="50"
                    />
                </div>
                <div class="form-group">
                    <label for="initialSolution">Initial Solution</label>
                    <input
                        type="number"
                        id="initialSolution"
                        title="Initial Solution"
                        value="10"
                        step="1"
                        min="-100"
                        max="100"
                    />
                </div>
            </div>

            <div class="button-group">
                <button id="startBtn">Start Simulation</button>
                <button id="pauseBtn" disabled>Pause</button>
                <button id="resetBtn">Reset</button>
            </div>
        </div>

        <div class="panel">
            <h3 class="h5">Iteration Log</h3>
            <div id="logContainer" class="log-container">
                <div class="log-entry">Waiting for simulation to start...</div>
            </div>
        </div>

        <div id="bestResultContainer" class="best-result" style="display: none;">
            <h3 class="h5">Best Solution Found</h3>
            <div class="results-grid">
                <div>
                    <p>Solution:</p>
                    <p id="bestSolution" class="results-value">0.0000</p>
                </div>
                <div>
                    <p>Energy Value:</p>
                    <p id="bestEnergy" class="results-value">0.0000</p>
                </div>
                <div>
                    <p>Found at Iteration:</p>
                    <p id="bestIteration" class="results-value">0</p>
                </div>
            </div>
        </div>

        <div id="resultsContainer" style="display: none;" class="results">
            <h3 class="h5">Final Results</h3>
            <div class="results-grid">
                <div>
                    <p>Final Solution:</p>
                    <p id="optimalSolution" class="results-value">0.0000</p>
                </div>
                <div>
                    <p>Final Energy Value:</p>
                    <p id="finalEnergy" class="results-value">0.0000</p>
                </div>
                <div>
                    <p>Total Iterations:</p>
                    <p id="iterationCount" class="results-value">0</p>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .column-layout {
        display: flex;
        gap: 20px;
    }
    .left-column, .right-column {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .panel {
        background-color: #f9f9f9;
        border-radius: .2rem;
        padding: 15px;
        margin-bottom: 20px;
    }
    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
        gap: 15px;
    }
    .form-group {
        margin-bottom: 10px;
    }
    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }
    input {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: .2rem;
    }
    .button-group {
        display: flex;
        gap: 10px;
        margin-top: 10px;
    }
    button {
        background-color: #4a90e2;
        color: white;
        border: none;
        padding: 6px 8px;
        border-radius: .2rem;
        cursor: pointer;
        font-size: 16px;
        flex: 1;
    }
    button:hover {
        background-color: #3a80d2;
    }
    button:disabled {
        background-color: #ccc;
        cursor: not-allowed;
    }
    #pauseBtn {
        background-color: #f44336;
    }
    #pauseBtn:hover {
        background-color: #d32f2f;
    }
    #pauseBtn:disabled{
        background-color: #ccc;
    }
    #resetBtn {
        background-color: #ff9800;
    }
    #resetBtn:hover {
        background-color: #f57c00;
    }
    .canvas-container {
        width: 100%;
        height: 300px;
        margin-bottom: 10px;
        border: 1px solid #ddd;
        border-radius: .2rem;
        position: relative;
    }
    canvas {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    .results {
        background-color: #e8f5e9;
        padding: 15px 15px 0px 15px;
        border-radius: .2rem;
        margin-bottom: 20px;
    }
    .best-result {
        background-color: #e3f2fd;
        padding: 15px 15px 0px 15px;
        border-radius: .2rem;
        margin-bottom: 20px;
    }
    .results-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
        gap: 5px;
        border: 1px solid #ccc;
        border-radius: .2rem;
        padding: 10px 10px 0px 10px;
        margin-bottom: 15px;
    }
    .results-value {
        font-size: 20px;
        font-weight: bold;
        margin-top: 5px;
    }
    .log-container {
        height: 225px;
        overflow-y: auto;
        border: 1px solid #ddd;
        border-radius: .2rem;
        padding: 10px 5px 0px 5px;
        font-family: monospace;
        font-size: 12px;
        background-color: #f8f8f8;
    }
    .log-entry {
        margin-bottom: 5px;
        padding: 2px 5px;
        border-bottom: 1px solid #eee;
    }
    .log-accepted {
        background-color: rgba(0, 255, 0, 0.1);
    }
    .log-rejected {
        background-color: rgba(255, 115, 0, 0.1);
    }
    .log-best {
        background-color: rgba(33, 150, 243, 0.2);
        font-weight: bold;
        border-left: 3px solid #2196f3;
    }
    .legend {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 10px;
    }
    .legend-item {
        display: flex;
        align-items: center;
        margin-right: 15px;
        margin-bottom: 5px;
    }
    .legend-color {
        width: 12px;
        height: 12px;
        margin-right: 5px;
        border-radius: 50%;
    }
    .validation-error-text {
        border-color: red;
    }
    @media (max-width: 992px) {
        .column-layout {
            flex-direction: column;
        }
        .button-group {
            flex-direction: column;
        }
        .grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 576px) {
        .grid {
            grid-template-columns: 1fr;
        }
        .results-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<?php include('simulated-annealing-search-sample2-code-js.php'); ?>
