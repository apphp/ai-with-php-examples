<script>
document.addEventListener('DOMContentLoaded', function () {
    // Canvas references
    const landscapeCanvas = document.getElementById('landscape-canvas');
    const graphCanvas = document.getElementById('graph-canvas');
    const landscapeCtx = landscapeCanvas.getContext('2d');
    const graphCtx = graphCanvas.getContext('2d');

    // DOM elements
    const startPauseButton = document.getElementById('start-pause-btn');
    const resetButton = document.getElementById('reset-btn');
    const speedSelect = document.getElementById('speed-select');
    const stepCounter = document.getElementById('step-counter');
    const temperatureValue = document.getElementById('temperature-value');
    const temperatureBar = document.getElementById('temperature-bar');
    const currentEnergyValue = document.getElementById('current-energy');
    const bestEnergyValue = document.getElementById('best-energy');
    const messageDisplay = document.getElementById('message-display');
    const algorithmLog = document.getElementById('algorithm-log');

    // New input elements
    const initialTempInput = document.getElementById('initial-temp');
    const coolingRateInput = document.getElementById('cooling-rate');
    const stopTempInput = document.getElementById('stop-temp');
    const initialSolutionSelect = document.getElementById('initial-solution');

    // Animation state
    let animating = false;
    let speed = 1;
    let currentStep = 0;
    let currentTemperature = parseFloat(initialTempInput.value);
    let currentEnergy = 0;
    let bestEnergy = 0;
    let currentX = 0;
    let bestX = 0;
    let energyHistory = [];
    let tempHistory = [];
    let pathHistory = [];
    let animationId = null;
    let stepCounter_internal = 0;
    let prevBestEnergy = Infinity;

    // Constants
    const maxSteps = 500;
    const canvasWidth = 600;
    const canvasHeight = 300;
    const graphHeight = 175;

    // Energy landscape function (a complex function with multiple local minima)
    function landscape(x) {
        return 30 * Math.sin(0.1 * x) +
            20 * Math.sin(0.15 * x) +
            50 * Math.sin(0.04 * x) +
            10 * Math.sin(0.3 * x) +
            150; // Base height
    }

    // Generate a random nearby solution
    function getNeighbor(x, temp) {
        // Step size is proportional to current temperature
        const initialTemp = parseFloat(initialTempInput.value);
        const stepSize = Math.min(Math.max(30 * (temp / initialTemp), 5), 50);
        return x + (Math.random() * 2 - 1) * stepSize;
    }

    // Acceptance probability
    function acceptanceProbability(currentEnergy, newEnergy, temp) {
        if (newEnergy < currentEnergy) return 1.0;
        return Math.exp((currentEnergy - newEnergy) / temp);
    }

    // Draw energy landscape
    function drawLandscape() {
        // ... (existing drawing code unchanged)
        landscapeCtx.clearRect(0, 0, canvasWidth, canvasHeight);

        // Draw landscape background
        const gradient = landscapeCtx.createLinearGradient(0, 0, 0, canvasHeight);
        gradient.addColorStop(0, '#e6f7ff');
        gradient.addColorStop(1, '#ffffff');
        landscapeCtx.fillStyle = gradient;
        landscapeCtx.fillRect(0, 0, canvasWidth, canvasHeight);

        // Draw grid lines
        landscapeCtx.strokeStyle = '#e0e0e0';
        landscapeCtx.lineWidth = 1;
        for (let x = 0; x < canvasWidth; x += 50) {
            landscapeCtx.beginPath();
            landscapeCtx.moveTo(x, 0);
            landscapeCtx.lineTo(x, canvasHeight);
            landscapeCtx.stroke();
        }
        for (let y = 0; y < canvasHeight; y += 50) {
            landscapeCtx.beginPath();
            landscapeCtx.moveTo(0, y);
            landscapeCtx.lineTo(canvasWidth, y);
            landscapeCtx.stroke();
        }

        // Draw the energy landscape
        landscapeCtx.beginPath();
        landscapeCtx.moveTo(0, canvasHeight - landscape(0));
        for (let x = 1; x <= canvasWidth; x++) {
            const y = landscape(x);
            landscapeCtx.lineTo(x, canvasHeight - y);
        }
        landscapeCtx.strokeStyle = '#333';
        landscapeCtx.lineWidth = 2;
        landscapeCtx.stroke();

        // Fill the area under the curve
        landscapeCtx.lineTo(canvasWidth, canvasHeight);
        landscapeCtx.lineTo(0, canvasHeight);
        landscapeCtx.closePath();
        landscapeCtx.fillStyle = 'rgba(100, 149, 237, 0.2)';
        landscapeCtx.fill();

        // Mark local minima
        const localMinima = [50, 160, 270, 370, 520];
        localMinima.forEach((x, i) => {
            const y = landscape(x);
            const isGlobal = i === 4; // Last one is global minimum

            landscapeCtx.beginPath();
            landscapeCtx.arc(x, canvasHeight - y, 6, 0, Math.PI * 2);
            landscapeCtx.fillStyle = isGlobal ? 'rgba(0, 0, 255, 0.7)' : 'rgba(255, 0, 0, 0.5)';
            landscapeCtx.fill();

            landscapeCtx.font = '10px Arial';
            landscapeCtx.fillStyle = '#333';
            landscapeCtx.textAlign = 'center';
            landscapeCtx.fillText(isGlobal ? 'Global Min' : 'Local Min', x, canvasHeight - y - 15);
        });

        // Draw solution path
        if (pathHistory.length > 1) {
            landscapeCtx.beginPath();
            landscapeCtx.moveTo(pathHistory[0].x, canvasHeight - pathHistory[0].y);

            for (let i = 1; i < pathHistory.length; i++) {
                const point = pathHistory[i];
                if (point.accepted) {
                    landscapeCtx.lineTo(point.x, canvasHeight - point.y);
                } else {
                    // Draw a dashed line for rejected solutions
                    landscapeCtx.setLineDash([2, 2]);
                    landscapeCtx.lineTo(point.x, canvasHeight - point.y);
                    landscapeCtx.stroke();
                    landscapeCtx.setLineDash([]);
                    landscapeCtx.beginPath();
                    landscapeCtx.moveTo(pathHistory[i - 1].x, canvasHeight - pathHistory[i - 1].y);
                }
            }

            landscapeCtx.strokeStyle = 'rgba(255, 165, 0, 0.8)';
            landscapeCtx.lineWidth = 2;
            landscapeCtx.stroke();
        }

        // Draw current position
        landscapeCtx.beginPath();
        landscapeCtx.arc(currentX, canvasHeight - currentEnergy, 8, 0, Math.PI * 2);
        landscapeCtx.fillStyle = 'rgba(255, 0, 0, 0.8)';
        landscapeCtx.fill();
        landscapeCtx.strokeStyle = '#000';
        landscapeCtx.lineWidth = 1;
        landscapeCtx.stroke();

        // Draw best solution
        landscapeCtx.beginPath();
        landscapeCtx.arc(bestX, canvasHeight - bestEnergy, 8, 0, Math.PI * 2);
        landscapeCtx.fillStyle = 'rgba(0, 128, 0, 0.8)';
        landscapeCtx.fill();
        landscapeCtx.strokeStyle = '#000';
        landscapeCtx.lineWidth = 1;
        landscapeCtx.stroke();
    }

    // Draw graph showing temperature and energy over time
    function drawGraphs() {
        // ... (existing graph drawing code unchanged)
        if (energyHistory.length === 0) return;

        graphCtx.clearRect(0, 0, canvasWidth, graphHeight);

        // Fill background
        graphCtx.fillStyle = '#f5f5f5';
        graphCtx.fillRect(0, 0, canvasWidth, graphHeight);

        // Draw grid lines
        graphCtx.strokeStyle = '#e0e0e0';
        graphCtx.lineWidth = 1;
        for (let x = 0; x < canvasWidth; x += 50) {
            graphCtx.beginPath();
            graphCtx.moveTo(x, 0);
            graphCtx.lineTo(x, graphHeight);
            graphCtx.stroke();
        }
        for (let y = 0; y < graphHeight; y += 25) {
            graphCtx.beginPath();
            graphCtx.moveTo(0, y);
            graphCtx.lineTo(canvasWidth, y);
            graphCtx.stroke();
        }

        // Draw axes labels
        graphCtx.font = '12px Arial';
        graphCtx.fillStyle = '#333';
        graphCtx.textAlign = 'left';
        graphCtx.fillText('Energy & Temperature', 10, 15);
        graphCtx.textAlign = 'right';
        graphCtx.fillText('Steps', canvasWidth - 10, graphHeight - 5);

        if (energyHistory.length <= 1) return;

        // Find min and max values for scaling
        const maxEnergy = Math.max(...energyHistory);
        const minEnergy = Math.min(...energyHistory);
        const energyRange = maxEnergy - minEnergy;

        // Scale the histories to fit the canvas
        const scaleX = canvasWidth / (maxSteps > 0 ? maxSteps : 1);
        const scaleEnergyY = (graphHeight - 20) / (energyRange > 0 ? energyRange : 1);
        const initialTemp = parseFloat(initialTempInput.value);
        const scaleTempY = (graphHeight - 20) / initialTemp;

        // Draw energy history
        graphCtx.beginPath();
        for (let i = 0; i < energyHistory.length; i++) {
            const x = i * scaleX;
            const y = graphHeight - 10 - (energyHistory[i] - minEnergy) * scaleEnergyY;

            if (i === 0) {
                graphCtx.moveTo(x, y);
            } else {
                graphCtx.lineTo(x, y);
            }
        }
        graphCtx.strokeStyle = 'blue';
        graphCtx.lineWidth = 2;
        graphCtx.stroke();

        // Draw temperature history
        graphCtx.beginPath();
        for (let i = 0; i < tempHistory.length; i++) {
            const x = i * scaleX;
            const y = graphHeight - 10 - tempHistory[i] * scaleTempY;

            if (i === 0) {
                graphCtx.moveTo(x, y);
            } else {
                graphCtx.lineTo(x, y);
            }
        }
        graphCtx.strokeStyle = 'red';
        graphCtx.lineWidth = 2;
        graphCtx.stroke();

        // Add legend
        graphCtx.fillStyle = 'blue';
        graphCtx.fillRect(canvasWidth - 100, 10, 10, 10);
        graphCtx.fillStyle = '#333';
        graphCtx.textAlign = 'left';
        graphCtx.fillText('Energy', canvasWidth - 85, 20);

        graphCtx.fillStyle = 'red';
        graphCtx.fillRect(canvasWidth - 100, 30, 10, 10);
        graphCtx.fillStyle = '#333';
        graphCtx.fillText('Temperature', canvasWidth - 85, 40);
    }

    // Run a single step of the algorithm
    function runStep() {
        let stopTemp = parseFloat(stopTempInput.value);
        if (currentStep >= maxSteps || currentTemperature <= stopTemp) {
            animating = false;
            startPauseButton.textContent = 'Start';
            startPauseButton.className = 'btn btn-success';
            messageDisplay.textContent = `Simulation complete. Best solution found has energy: ${bestEnergy.toFixed(2)}`;
            return;
        }

        // Generate a new candidate solution
        const newX = getNeighbor(currentX, currentTemperature);
        const boundedX = Math.max(0, Math.min(canvasWidth, newX)); // Keep within canvas
        const newEnergy = landscape(boundedX);

        // Determine whether to accept the new solution
        const ap = acceptanceProbability(currentEnergy, newEnergy, currentTemperature);
        const accepted = Math.random() < ap;

        // Update path history
        pathHistory.push({
            x: boundedX,
            y: newEnergy,
            accepted
        });

        // Flag to track if this is a new best solution
        let isNewBest = false;

        // Update current solution if accepted
        if (accepted) {
            currentX = boundedX;
            currentEnergy = newEnergy;

            // Update best solution if better
            if (newEnergy < bestEnergy) {
                isNewBest = true;
                prevBestEnergy = bestEnergy;
                bestX = boundedX;
                bestEnergy = newEnergy;
            }
        }

        // Update temperature
        const coolingRate = parseFloat(coolingRateInput.value);
        const newTemp = currentTemperature * coolingRate;
        currentTemperature = newTemp;

        // Update histories
        energyHistory.push(accepted ? newEnergy : energyHistory[energyHistory.length - 1]);
        tempHistory.push(newTemp);

        // Increment step
        currentStep++;

        // Update UI
        updateUI();

        // Format iteration log entry with the requested format
        let logEntryText = `Iteration ${currentStep}: x = ${boundedX.toFixed(4)}, f(x) = ${newEnergy.toFixed(4)}, T° = ${newTemp.toFixed(2)}, ${accepted ? 'ACCEPTED' : 'REJECTED'}${isNewBest ? ' (NEW BEST)' : ''}`;
        if (currentStep >= maxSteps || currentTemperature <= stopTemp) {
            logEntryText = `Simulation complete. Best solution found has energy: ${bestEnergy.toFixed(2)}`;
        }

        // Update message
        messageDisplay.textContent = logEntryText;

        // Log to algorithm log
        const logEntry = document.createElement('div');
        logEntry.textContent = logEntryText;

        if (isNewBest) {
            logEntry.className = 'log-entry-best';
            logEntry.style.fontWeight = 'bold';
        } else if (accepted) {
            logEntry.className = 'log-entry-accepted';
        } else {
            logEntry.className = 'log-entry-rejected';
        }

        algorithmLog.appendChild(logEntry);
        algorithmLog.scrollTop = algorithmLog.scrollHeight;

        // Redraw visuals
        drawLandscape();
        drawGraphs();
    }

    // Update UI elements
    function updateUI() {
        stepCounter.textContent = `${currentStep} / ${maxSteps}`;
        temperatureValue.textContent = currentTemperature.toFixed(2);
        const initialTemp = parseFloat(initialTempInput.value);
        temperatureBar.style.width = `${Math.max(0, Math.min(100, (currentTemperature / initialTemp) * 100))}%`;
        currentEnergyValue.textContent = currentEnergy.toFixed(2);
        bestEnergyValue.textContent = bestEnergy.toFixed(2);
    }

    // Animation loop
    function animate() {
        // Handle fractional speeds
        stepCounter_internal += speed;

        // Only run steps when we have accumulated enough for at least one step
        while (stepCounter_internal >= 1) {
            runStep();
            stepCounter_internal -= 1;
        }

        const stopTemp = parseFloat(stopTempInput.value);
        if (animating && currentStep < maxSteps && currentTemperature > stopTemp) {
            animationId = requestAnimationFrame(animate);
        } else {
            animating = false;
            startPauseButton.textContent = 'Start';
            startPauseButton.className = 'btn btn-success';
        }
    }

    // Toggle animation
    function toggleAnimation() {
        animating = !animating;
        if (animating) {
            startPauseButton.textContent = 'Pause';
            startPauseButton.className = 'btn btn-danger';
            animationId = requestAnimationFrame(animate);
        } else {
            startPauseButton.textContent = 'Start';
            startPauseButton.className = 'btn btn-success';
            if (animationId) {
                cancelAnimationFrame(animationId);
            }
        }
    }

    // Reset simulation
    function resetSimulation() {
        // Stop animation
        animating = false;
        startPauseButton.textContent = 'Start';
        startPauseButton.className = 'btn btn-success';
        if (animationId) {
            cancelAnimationFrame(animationId);
        }

        // Get selected starting position
        let startX;
        const initialSolution = initialSolutionSelect.value;

        switch (initialSolution) {
            case 'leftmost':
                startX = 50; // Near the leftmost local minimum
                break;
            case 'rightmost':
                startX = 520; // Near the rightmost (global) minimum
                break;
            case 'center':
                startX = 300; // Center of the canvas
                break;
            case 'random':
            default:
                startX = Math.random() * canvasWidth;
                break;
        }

        currentStep = 0;
        currentTemperature = parseFloat(initialTempInput.value);
        const startEnergy = landscape(startX);

        currentX = startX;
        currentEnergy = startEnergy;
        bestX = startX;
        bestEnergy = startEnergy;
        prevBestEnergy = Infinity;
        energyHistory = [startEnergy];
        tempHistory = [currentTemperature];
        pathHistory = [{x: startX, y: startEnergy, accepted: true}];

        messageDisplay.textContent = 'Click "Start" to begin the simulation';

        // Clear algorithm log
        algorithmLog.innerHTML = '<div class="log-entry-info">Simulation reset. Ready to start.</div>';

        // Update UI
        updateUI();

        // Redraw visuals
        drawLandscape();
        drawGraphs();
    }

    // Event listeners
    startPauseButton.addEventListener('click', toggleAnimation);
    resetButton.addEventListener('click', resetSimulation);
    speedSelect.addEventListener('change', function () {
        speed = parseFloat(this.value);
    });

    // Add event listeners for the new input fields to update values when changed
    initialTempInput.addEventListener('change', function() {
        if (!animating) {
            currentTemperature = parseFloat(this.value);
            updateUI();
        }
    });

    // Add event listeners for parameter changes to reset simulation
    coolingRateInput.addEventListener('change', resetSimulation);
    stopTempInput.addEventListener('change', resetSimulation);
    initialSolutionSelect.addEventListener('change', resetSimulation);

    // Initialize the simulation
    function init() {
        landscapeCanvas.width = canvasWidth;
        landscapeCanvas.height = canvasHeight;
        graphCanvas.width = canvasWidth;
        graphCanvas.height = graphHeight;

        // Set initial values from inputs
        currentTemperature = parseFloat(initialTempInput.value);

        // Set initial position based on the selected option
        let startX;
        const initialSolution = initialSolutionSelect.value;

        switch (initialSolution) {
            case 'leftmost':
                startX = 50; // Near the leftmost local minimum
                break;
            case 'rightmost':
                startX = 520; // Near the rightmost (global) minimum
                break;
            case 'center':
                startX = 300; // Center of the canvas
                break;
            case 'random':
            default:
                startX = Math.random() * canvasWidth;
                break;
        }

        const startEnergy = landscape(startX);

        currentX = startX;
        currentEnergy = startEnergy;
        bestX = startX;
        bestEnergy = startEnergy;
        prevBestEnergy = Infinity;
        energyHistory = [startEnergy];
        tempHistory = [currentTemperature];
        pathHistory = [{x: startX, y: startEnergy, accepted: true}];

        // Initialize algorithm log
        algorithmLog.innerHTML = '<div class="log-entry-info">Simulation initialized. Starting position: x=' +
            startX.toFixed(2) + ', energy=' + startEnergy.toFixed(2) + '</div>';

        messageDisplay.textContent = 'Click "Start" to begin the simulation';

        // Update UI
        updateUI();

        // Draw initial state
        drawLandscape();
        drawGraphs();
    }

    // Add styles for new log entry class
    const styleElement = document.createElement('style');
    styleElement.textContent = `
    .log-entry-best {
        color: #228B22;
        font-weight: bold;
        margin-bottom: 2px;
    }
`;
    document.head.appendChild(styleElement);

    // Start the simulation
    init();
});
</script>
