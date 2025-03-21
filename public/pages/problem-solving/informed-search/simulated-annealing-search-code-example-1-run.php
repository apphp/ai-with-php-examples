<?php

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Informed (Heuristic) Search</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Simulated Annealing Search Visualization</h2>
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
<!--    --><?php //= create_example_of_use_links(__DIR__ . '/simulated-annealing-search-code-usage.php'); ?>
</div>


<div class="">
    <div class="panel">
        <h3 class="h5">Parameters</h3>
        <div class="grid">
            <div class="form-group">
                <label for="initialTemperature">Initial Temperature</label>
                <input
                    type="number"
                    id="initialTemperature"
                    value="1000"
                />
            </div>
            <div class="form-group">
                <label for="coolingRate">Cooling Rate</label>
                <input
                    type="number"
                    id="coolingRate"
                    value="0.99"
                    step="0.01"
                    min="0.01"
                    max="0.99"
                />
            </div>
            <div class="form-group">
                <label for="stopTemperature">Stop Temperature</label>
                <input
                    type="number"
                    id="stopTemperature"
                    value="0.1"
                />
            </div>
            <div class="form-group">
                <label for="initialSolution">Initial Solution</label>
                <input
                    type="number"
                    id="initialSolution"
                    value="10"
                />
            </div>
        </div>

        <button id="startBtn">
            Start Simulation
        </button>
    </div>

    <div id="bestResultContainer" class="best-result mb-4" style="display: none;">
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

    <div class="two-column">
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

    <div class="panel">
        <h3 class="h5">Iteration Log</h3>
        <div id="logContainer" class="log-container">
            <div class="log-entry">Waiting for simulation to start...</div>
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

<style>
    .panel {
        background-color: #f9f9f9;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
    }
    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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
        border-radius: 4px;
    }
    button {
        background-color: #4a90e2;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }
    button:hover {
        background-color: #3a80d2;
    }
    button:disabled {
        background-color: #ccc;
        cursor: not-allowed;
    }
    .canvas-container {
        width: 100%;
        height: 300px;
        margin-bottom: 20px;
        border: 1px solid #ddd;
        border-radius: 4px;
        position: relative;
    }
    canvas {
        position: absolute;
        top: 0;
        left: 0;
    }
    .results {
        background-color: #e8f5e9;
        padding: 15px;
        border-radius: 8px;
        margin-top: 20px;
    }
    .best-result {
        background-color: #e3f2fd;
        padding: 15px;
        border-radius: 8px;
        margin-top: 20px;
        border-left: 4px solid #2196f3;
    }
    .results-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }
    .results-value {
        font-size: 24px;
        font-weight: bold;
    }
    .log-container {
        height: 300px;
        overflow-y: auto;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 10px;
        font-family: monospace;
        font-size: 14px;
        background-color: #f8f8f8;
    }
    .log-entry {
        margin-bottom: 5px;
        padding: 5px;
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
    .two-column {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    @media (max-width: 768px) {
        .two-column {
            grid-template-columns: 1fr;
        }
    }
    .legend {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 10px;
    }
    .legend-item {
        display: flex;
        align-items: center;
        margin-right: 20px;
        margin-bottom: 5px;
    }
    .legend-color {
        width: 15px;
        height: 15px;
        margin-right: 5px;
        border-radius: 50%;
    }
</style>

<script>
    // Get DOM elements
    const initialTemperatureInput = document.getElementById('initialTemperature');
    const coolingRateInput = document.getElementById('coolingRate');
    const stopTemperatureInput = document.getElementById('stopTemperature');
    const initialSolutionInput = document.getElementById('initialSolution');
    const startBtn = document.getElementById('startBtn');
    const functionCanvas = document.getElementById('functionCanvas');
    const temperatureCanvas = document.getElementById('temperatureCanvas');
    const logContainer = document.getElementById('logContainer');
    const resultsContainer = document.getElementById('resultsContainer');
    const bestResultContainer = document.getElementById('bestResultContainer');
    const optimalSolutionEl = document.getElementById('optimalSolution');
    const finalEnergyEl = document.getElementById('finalEnergy');
    const iterationCountEl = document.getElementById('iterationCount');
    const bestSolutionEl = document.getElementById('bestSolution');
    const bestEnergyEl = document.getElementById('bestEnergy');
    const bestIterationEl = document.getElementById('bestIteration');

    // Set canvas dimensions based on container
    function resizeCanvases() {
        const functionContainer = functionCanvas.parentElement;
        const temperatureContainer = temperatureCanvas.parentElement;

        functionCanvas.width = functionContainer.offsetWidth;
        functionCanvas.height = functionContainer.offsetHeight;
        temperatureCanvas.width = temperatureContainer.offsetWidth;
        temperatureCanvas.height = temperatureContainer.offsetHeight;
    }

    // Call resize initially
    resizeCanvases();

    // Resize when window changes
    window.addEventListener('resize', resizeCanvases);

    // Initialize canvas contexts
    const functionCtx = functionCanvas.getContext('2d');
    const temperatureCtx = temperatureCanvas.getContext('2d');

    // Simulation variables
    let iterations = [];
    let simulationInterval = null;
    let running = false;
    let bestSolution = null;
    let bestEnergy = Infinity;
    let bestIteration = 0;

    // Objective function: f(x) = x^2
    function objectiveFunction(x) {
        return Math.pow(x, 2);
    }

    // Generate a random neighbor solution
    function getRandomNeighbor(x, temp) {
        // The step size is related to the current temperature
        return x + ((Math.random() - 0.5) * 2 * temp / 100);
    }

    // Calculate acceptance probability
    function acceptanceProbability(currentEnergy, newEnergy, temperature) {
        if (newEnergy < currentEnergy) {
            return 1.0;
        }
        return Math.exp((currentEnergy - newEnergy) / temperature);
    }

    // Add log entry
    function addLogEntry(message, isAccepted, isBest = false) {
        const logEntry = document.createElement('div');
        let className = `log-entry ${isAccepted ? 'log-accepted' : 'log-rejected'}`;
        if (isBest) {
            className += ' log-best';
        }
        logEntry.className = className;
        logEntry.textContent = message;
        logContainer.appendChild(logEntry);
        logContainer.scrollTop = logContainer.scrollHeight;
    }

    // Clear log
    function clearLog() {
        logContainer.innerHTML = '';
    }

    // Draw function canvas with grid
    function drawFunctionCanvas() {
        const width = functionCanvas.width;
        const height = functionCanvas.height;

        // Clear canvas
        functionCtx.clearRect(0, 0, width, height);

        // Set the display range for Y values
        const minYDisplay = -40;
        const maxYDisplay = 150;
        const yRange = maxYDisplay - minYDisplay;

        // Calculate vertical center position (where y=0 should be drawn)
        const yZeroPosition = height * ((maxYDisplay) / yRange);

        // Draw grid
        functionCtx.strokeStyle = '#e0e0e0';
        functionCtx.lineWidth = 0.5;

        // Vertical grid lines
        for (let x = 0; x <= width; x += 10) {
            functionCtx.beginPath();
            functionCtx.moveTo(x, 0);
            functionCtx.lineTo(x, height);
            functionCtx.stroke();
        }

        // Horizontal grid lines
        for (let y = 0; y <= height; y += 10) {
            functionCtx.beginPath();
            functionCtx.moveTo(0, y);
            functionCtx.lineTo(width, y);
            functionCtx.stroke();
        }

        // Draw axes
        functionCtx.strokeStyle = '#000';
        functionCtx.lineWidth = 1;
        functionCtx.beginPath();

        // X axis (at y=0 position)
        functionCtx.moveTo(0, yZeroPosition);
        functionCtx.lineTo(width, yZeroPosition);

        // Y axis (at center of width)
        functionCtx.moveTo(width/2, 0);
        functionCtx.lineTo(width/2, height);
        functionCtx.stroke();

        // Draw axis labels
        functionCtx.fillStyle = '#000';
        functionCtx.font = '12px Arial';

        // X-axis labels
        const xLabels = [-25, -20, -15, -10, -5, 0, 5, 10, 15, 20, 25];
        const scale = 10; // Scale factor for visualization

        xLabels.forEach(x => {
            const px = width/2 + x * scale;
            functionCtx.fillText(x.toString(), px - 5, yZeroPosition + 15);
        });

        // Y-axis labels (show values from minYDisplay to maxYDisplay)
        const yLabels = [-50, -25, 0, 25, 50, 75, 100, 125, 150];

        yLabels.forEach(y => {
            // Calculate position using the full range
            const py = height - ((y - minYDisplay) / yRange) * height;
            if (py >= 0 && py <= height) { // Only draw if within canvas
                functionCtx.fillText(y.toString(), width/2 + 5, py + 5);
            }
        });

        // Draw function f(x) = x^2
        functionCtx.strokeStyle = '#8884d8';
        functionCtx.lineWidth = 2;
        functionCtx.beginPath();

        for (let px = 0; px < width; px++) {
            const x = (px - width/2) / scale;
            const y = objectiveFunction(x);

            // Only draw if within display range
            if (y >= minYDisplay && y <= maxYDisplay) {
                // Convert y value to canvas position
                const py = height - ((y - minYDisplay) / yRange) * height;

                if (px === 0) {
                    functionCtx.moveTo(px, py);
                } else {
                    functionCtx.lineTo(px, py);
                }
            }
        }

        functionCtx.stroke();

        // Draw iterations (points)
        if (iterations && iterations.length > 0) {
            iterations.forEach((iter, index) => {
                // Only draw points within display range
                if (iter.energy >= minYDisplay && iter.energy <= maxYDisplay) {
                    const px = width/2 + iter.solution * scale;
                    // Convert energy value to canvas position
                    const py = height - ((iter.energy - minYDisplay) / yRange) * height;

                    functionCtx.fillStyle = iter.accepted ? '#00ff00' : '#ff7300';
                    functionCtx.beginPath();
                    functionCtx.arc(px, py, 3, 0, Math.PI * 2);
                    functionCtx.fill();
                }
            });

            // Draw current solution
            const current = iterations[iterations.length - 1];
            if (current.energy >= minYDisplay && current.energy <= maxYDisplay) {
                const px = width/2 + current.solution * scale;
                // Convert energy value to canvas position
                const py = height - ((current.energy - minYDisplay) / yRange) * height;

                functionCtx.fillStyle = '#ff0000';
                functionCtx.beginPath();
                functionCtx.arc(px, py, 5, 0, Math.PI * 2);
                functionCtx.fill();
            }

            // Draw best solution found
            if (bestSolution !== null && bestEnergy >= minYDisplay && bestEnergy <= maxYDisplay) {
                const px = width/2 + bestSolution * scale;
                // Convert energy value to canvas position
                const py = height - ((bestEnergy - minYDisplay) / yRange) * height;

                // Draw a blue circle for best solution
                functionCtx.fillStyle = '#2196f3';
                functionCtx.beginPath();
                functionCtx.arc(px, py, 6, 0, Math.PI * 2);
                functionCtx.fill();

                // Draw a diamond around best solution
                functionCtx.strokeStyle = '#2196f3';
                functionCtx.lineWidth = 2;
                functionCtx.beginPath();
                functionCtx.moveTo(px, py - 10);
                functionCtx.lineTo(px + 10, py);
                functionCtx.lineTo(px, py + 10);
                functionCtx.lineTo(px - 10, py);
                functionCtx.closePath();
                functionCtx.stroke();
            }
        }
    }

    // Draw temperature canvas with grid
    function drawTemperatureCanvas() {
        const width = temperatureCanvas.width;
        const height = temperatureCanvas.height;

        // Clear canvas
        temperatureCtx.clearRect(0, 0, width, height);

        if (!iterations || iterations.length === 0) {
            return;
        }

        // Draw grid
        temperatureCtx.strokeStyle = '#e0e0e0';
        temperatureCtx.lineWidth = 0.5;

        // Vertical grid lines
        for (let x = 50; x <= width; x += 50) {
            temperatureCtx.beginPath();
            temperatureCtx.moveTo(x, 10);
            temperatureCtx.lineTo(x, height - 30);
            temperatureCtx.stroke();
        }

        // Horizontal grid lines
        for (let y = 10; y <= height - 30; y += 50) {
            temperatureCtx.beginPath();
            temperatureCtx.moveTo(50, y);
            temperatureCtx.lineTo(width - 10, y);
            temperatureCtx.stroke();
        }

        // Find max values for scaling
        const maxTemp = Math.max(...iterations.map(i => i.temperature));
        const maxEnergy = Math.max(...iterations.map(i => i.energy));
        const maxIter = iterations.length;

        // Draw axes
        temperatureCtx.strokeStyle = '#000';
        temperatureCtx.lineWidth = 1;
        temperatureCtx.beginPath();
        temperatureCtx.moveTo(50, 10);
        temperatureCtx.lineTo(50, height - 30);
        temperatureCtx.lineTo(width - 10, height - 30);
        temperatureCtx.stroke();

        // Draw labels
        temperatureCtx.fillStyle = '#000';
        temperatureCtx.font = '12px Arial';
        temperatureCtx.fillText('Temperature / Energy', 10, 10);
        temperatureCtx.fillText('Iterations', width - 60, height - 10);

        // Draw temperature line
        if (maxIter > 0) {
            temperatureCtx.strokeStyle = '#8884d8';
            temperatureCtx.lineWidth = 2;
            temperatureCtx.beginPath();

            iterations.forEach((iter, index) => {
                const px = 50 + (index / maxIter) * (width - 60);
                const py = (height - 30) - (iter.temperature / maxTemp) * (height - 40);

                if (index === 0) {
                    temperatureCtx.moveTo(px, py);
                } else {
                    temperatureCtx.lineTo(px, py);
                }
            });

            temperatureCtx.stroke();

            // Draw energy line
            temperatureCtx.strokeStyle = '#82ca9d';
            temperatureCtx.lineWidth = 2;
            temperatureCtx.beginPath();

            iterations.forEach((iter, index) => {
                const px = 50 + (index / maxIter) * (width - 60);
                const py = (height - 30) - (iter.energy / maxEnergy) * (height - 40);

                if (index === 0) {
                    temperatureCtx.moveTo(px, py);
                } else {
                    temperatureCtx.lineTo(px, py);
                }
            });

            temperatureCtx.stroke();

            // Mark the best solution found
            if (bestIteration > 0) {
                const px = 50 + (bestIteration / maxIter) * (width - 60);
                const py = (height - 30) - (bestEnergy / maxEnergy) * (height - 40);

                temperatureCtx.fillStyle = '#2196f3';
                temperatureCtx.beginPath();
                temperatureCtx.arc(px, py, 5, 0, Math.PI * 2);
                temperatureCtx.fill();
            }
        }
    }

    // Update best solution display
    function updateBestSolutionDisplay() {
        if (bestSolution !== null) {
            bestResultContainer.style.display = 'block';
            bestSolutionEl.textContent = bestSolution.toFixed(4);
            bestEnergyEl.textContent = bestEnergy.toFixed(4);
            bestIterationEl.textContent = bestIteration;
        }
    }

    // Run the simulation
    function runSimulation() {
        // Prevent multiple runs
        if (running) return;

        // Set running state
        running = true;
        startBtn.textContent = 'Running...';
        startBtn.disabled = true;

        // Hide results
        resultsContainer.style.display = 'none';
        bestResultContainer.style.display = 'none';

        // Clear log
        clearLog();

        // Reset best solution tracking
        bestSolution = null;
        bestEnergy = Infinity;
        bestIteration = 0;

        // Get parameters
        const initialTemperature = parseFloat(initialTemperatureInput.value);
        const coolingRate = parseFloat(coolingRateInput.value);
        const stopTemperature = parseFloat(stopTemperatureInput.value);
        const initialSolution = parseFloat(initialSolutionInput.value);

        // Initialize variables
        let currentSolution = initialSolution;
        let currentEnergy = objectiveFunction(currentSolution);
        let temperature = initialTemperature;
        let iterationCount = 0;

        // Reset iterations
        iterations = [];

        // Check if initial solution is the best so far
        if (currentEnergy < bestEnergy) {
            bestSolution = currentSolution;
            bestEnergy = currentEnergy;
            bestIteration = iterationCount;
            updateBestSolutionDisplay();
        }

        // Add initial state
        iterations.push({
            iteration: iterationCount,
            temperature: temperature,
            solution: currentSolution,
            energy: currentEnergy,
            accepted: true,
            type: 'initial'
        });

        // Log initial state
        addLogEntry(`Initial state: x = ${currentSolution.toFixed(4)}, f(x) = ${currentEnergy.toFixed(4)}, T = ${temperature.toFixed(2)}`, true);

        // Draw initial state
        drawFunctionCanvas();
        drawTemperatureCanvas();

        // Start simulation interval
        simulationInterval = setInterval(() => {
            if (temperature <= stopTemperature || iterationCount > 1000) {
                // Stop simulation
                clearInterval(simulationInterval);
                running = false;
                startBtn.textContent = 'Start Simulation';
                startBtn.disabled = false;

                // Show results
                resultsContainer.style.display = 'block';
                optimalSolutionEl.textContent = iterations[iterations.length - 1].solution.toFixed(4);
                finalEnergyEl.textContent = iterations[iterations.length - 1].energy.toFixed(4);
                iterationCountEl.textContent = iterations.length - 1;

                // Log final state
                addLogEntry(`Simulation complete: Final solution = ${iterations[iterations.length - 1].solution.toFixed(4)}, Energy = ${iterations[iterations.length - 1].energy.toFixed(4)}`, true);
                addLogEntry(`BEST SOLUTION FOUND: x = ${bestSolution.toFixed(4)}, f(x) = ${bestEnergy.toFixed(4)} at iteration ${bestIteration}`, true, true);

                return;
            }

            // Generate new solution
            const newSolution = getRandomNeighbor(currentSolution, temperature);
            const newEnergy = objectiveFunction(newSolution);
            const acceptance = acceptanceProbability(currentEnergy, newEnergy, temperature);
            const accepted = acceptance > Math.random();

            iterationCount++;

            // Add to iterations
            iterations.push({
                iteration: iterationCount,
                temperature: temperature,
                solution: newSolution,
                energy: newEnergy,
                acceptance: acceptance,
                accepted: accepted,
                type: 'proposed'
            });

            // Log iteration
            let isBest = false;
            if (newEnergy < bestEnergy) {
                bestSolution = newSolution;
                bestEnergy = newEnergy;
                bestIteration = iterationCount;
                updateBestSolutionDisplay();
                isBest = true;
            }

            if (accepted) {
                if (isBest) {
                    addLogEntry(`Iteration ${iterationCount}: x = ${newSolution.toFixed(4)}, f(x) = ${newEnergy.toFixed(4)}, T = ${temperature.toFixed(2)}, ACCEPTED (NEW BEST)`, true, true);
                } else {
                    addLogEntry(`Iteration ${iterationCount}: x = ${newSolution.toFixed(4)}, f(x) = ${newEnergy.toFixed(4)}, T = ${temperature.toFixed(2)}, ACCEPTED`, true);
                }

                // Update current solution if accepted
                currentSolution = newSolution;
                currentEnergy = newEnergy;
            } else {
                addLogEntry(`Iteration ${iterationCount}: x = ${newSolution.toFixed(4)}, f(x) = ${newEnergy.toFixed(4)}, T = ${temperature.toFixed(2)}, REJECTED`, false);
            }

            // Cool down
            temperature *= coolingRate;

            // Update visualization
            drawFunctionCanvas();
            drawTemperatureCanvas();
        }, 50); // Update every 50ms for animation
    }

    // Add event listener for button
    startBtn.addEventListener('click', runSimulation);

    // Initial draw
    drawFunctionCanvas();
    drawTemperatureCanvas();
</script>

