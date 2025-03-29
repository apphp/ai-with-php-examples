<script>

// Get DOM elements
const initialTemperatureInput = document.getElementById('initialTemperature');
const coolingRateInput = document.getElementById('coolingRate');
const stopTemperatureInput = document.getElementById('stopTemperature');
const initialSolutionInput = document.getElementById('initialSolution');
const startBtn = document.getElementById('startBtn');
const pauseBtn = document.getElementById('pauseBtn');
const resetBtn = document.getElementById('resetBtn');
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
    const scale = 20; // Scale factor for visualization

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
    const xOffset = 20;

    // Draw axes
    temperatureCtx.strokeStyle = '#000';
    temperatureCtx.lineWidth = 1;
    temperatureCtx.beginPath();
    temperatureCtx.moveTo(xOffset, 30);
    temperatureCtx.lineTo(xOffset, height - 30);
    temperatureCtx.lineTo(width - 10, height - 30);
    temperatureCtx.stroke();

    // Draw labels
    temperatureCtx.fillStyle = '#000';
    temperatureCtx.font = '12px Arial';
    temperatureCtx.fillText('Temperature / Energy', 10, 20);
    temperatureCtx.fillText('Iterations', width - 60, height - 10);

    // Draw temperature line
    if (maxIter > 0) {
        temperatureCtx.strokeStyle = '#8884d8';
        temperatureCtx.lineWidth = 2;
        temperatureCtx.beginPath();

        iterations.forEach((iter, index) => {
            const px = xOffset + (index / maxIter) * (width - 60);
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
            const px = xOffset + (index / maxIter) * (width - 60);
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
            const px = xOffset + (bestIteration / maxIter) * (width - 60);
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

// Initialize the simulation with default parameters
function initializeSimulation() {
    // Get default parameters
    const initialSolution = parseFloat(initialSolutionInput.value);
    const currentEnergy = objectiveFunction(initialSolution);
    const initialTemperature = parseFloat(initialTemperatureInput.value);

    // Create initial state
    iterations = [{
        iteration: 0,
        temperature: initialTemperature,
        solution: initialSolution,
        energy: currentEnergy,
        accepted: true,
        type: 'initial'
    }];

    // Set best solution to initial
    bestSolution = initialSolution;
    bestEnergy = currentEnergy;
    bestIteration = 0;

    // Add initial log
    addLogEntry(`Initial position: x = ${initialSolution.toFixed(4)}, f(x) = ${currentEnergy.toFixed(4)}`, true);

    // Draw initial state
    drawFunctionCanvas();
    drawTemperatureCanvas();

    // Show best solution
    updateBestSolutionDisplay();
}

// Reset the simulation
function resetSimulation() {
    // Stop any running simulation
    if (running) {
        clearInterval(simulationInterval);
        running = false;
    }

    removeAllValidationErrors();

    // Reset UI
    startBtn.textContent = 'Start Simulation';
    startBtn.disabled = false;
    pauseBtn.disabled = true;

    // Hide results
    resultsContainer.style.display = 'none';

    // Clear log
    clearLog();

    // Re-initialize with default values
    initializeSimulation();
}

// Pause the simulation
function pauseSimulation() {
    if (!running) return;

    clearInterval(simulationInterval);
    running = false;

    startBtn.textContent = 'Resume Simulation';
    startBtn.disabled = false;
    pauseBtn.disabled = true;

    addLogEntry('Simulation paused.', false);
}

// Function to validate all number input fields
function validateAllNumberInputs() {
    // Get all number input fields with a more reliable selector
    const numberInputs = document.querySelectorAll('input[type="number"]');

    let isValid = true;
    let firstInvalidInput = null;

    // Check each input field
    for (const input of numberInputs) {
        // Skip if input doesn't exist
        if (!input) continue;

        // Get validation attributes
        const value = input.value.trim();
        const numValue = parseFloat(value);
        const min = parseFloat(input.getAttribute('min'));
        const max = parseFloat(input.getAttribute('max'));
        const step = parseFloat(input.getAttribute('step') || '1');
        const name = input.getAttribute('title') || 'This field';

        // Reset previous error styling
        input.style.borderColor = '';

        // Check for empty value
        if (value === '' || isNaN(numValue)) {
            showError(input, `${name} must have a numeric value`);
            isValid = false;
            firstInvalidInput = firstInvalidInput || input;
            continue;
        }

        // Check min value if specified
        if (!isNaN(min) && numValue < min) {
            showError(input, `${name} must be at least ${min}`);
            isValid = false;
            firstInvalidInput = firstInvalidInput || input;
            continue;
        }

        // Check max value if specified
        if (!isNaN(max) && numValue > max) {
            showError(input, `${name} must be at most ${max}`);
            isValid = false;
            firstInvalidInput = firstInvalidInput || input;
            continue;
        }

        // Improved step validation with better floating point handling
        if (!isNaN(step) && step > 0) {
            const baseline = !isNaN(min) ? min : 0;
            const diff = Math.abs(numValue - baseline);
            const remainder = diff / step;
            const roundedRemainder = Math.round(remainder);

            if (Math.abs(remainder - roundedRemainder) > 0.000001) {
                showError(input, `${name} must be in increments of ${step} from ${baseline}`);
                isValid = false;
                firstInvalidInput = firstInvalidInput || input;
            }
        }
    }

    // Focus on the first invalid input if any
    if (firstInvalidInput) {
        firstInvalidInput.focus();
    }

    return isValid;
}

// Function to show error for an input
function showError(input, message) {
    // Add red border to highlight the error
    input.classList.add('validation-error-field');

    // Create or update error message
    let errorElement = document.getElementById(`${input.id}-error`);
    if (!errorElement) {
        errorElement = document.createElement('div');
        errorElement.id = `${input.id}-error`;
        errorElement.style.color = 'red';
        errorElement.classList.add('validation-error-text');
        errorElement.style.fontSize = '12px';
        errorElement.style.marginTop = '5px';
        input.parentNode.appendChild(errorElement);
    }

    errorElement.textContent = message;

    // Remove error message after 5 seconds
    setTimeout(() => {
        if (errorElement.parentNode) {
            errorElement.parentNode.removeChild(errorElement);
        }
        input.style.borderColor = '';
    }, 5000);
}

// Function to remove all validation error elements
function removeAllValidationErrors() {
    const errorElements = document.querySelectorAll('.validation-error-text');
    errorElements.forEach(element => {
        element.parentNode.removeChild(element);
    });

    const elements = document.querySelectorAll('.validation-error-text');
    elements.forEach(element => {
        element.classList.remove('validation-error-text');
    });
}

// Run the simulation
function runSimulation(event) {
    // Prevent multiple runs
    if (running) return;

    // Validate all number inputs before starting simulation
    if (!validateAllNumberInputs()) {
        event.preventDefault();
        return false;
    }

    // Set running state
    running = true;
    startBtn.textContent = 'Running...';
    startBtn.disabled = true;
    pauseBtn.disabled = false;

    // Check if this is a fresh start or resume
    const isFreshStart = iterations.length <= 1;

    if (isFreshStart) {
        // Hide results
        resultsContainer.style.display = 'none';

        // Clear log
        clearLog();

        // Reset best solution tracking
        bestSolution = null;
        bestEnergy = Infinity;
        bestIteration = 0;
    }

    // Get parameters
    const initialTemperature = parseFloat(initialTemperatureInput.value);
    const coolingRate = parseFloat(coolingRateInput.value);
    const stopTemperature = parseFloat(stopTemperatureInput.value);
    const initialSolution = parseFloat(initialSolutionInput.value);

    let currentSolution, currentEnergy, temperature, iterationCount;

    if (isFreshStart) {
        // Initialize variables for fresh start
        currentSolution = initialSolution;
        currentEnergy = objectiveFunction(currentSolution);
        temperature = initialTemperature;
        iterationCount = 0;

        // Reset iterations
        iterations = [{
            iteration: iterationCount,
            temperature: temperature,
            solution: currentSolution,
            energy: currentEnergy,
            accepted: true,
            type: 'initial'
        }];

        // Check if initial solution is the best so far
        bestSolution = currentSolution;
        bestEnergy = currentEnergy;
        bestIteration = iterationCount;
        updateBestSolutionDisplay();

        // Log initial state
        addLogEntry(`Initial state: x = ${currentSolution.toFixed(4)}, f(x) = ${currentEnergy.toFixed(4)}, T° = ${temperature.toFixed(2)}`, true);
    } else {
        // Resume from current state
        const currentState = iterations[iterations.length - 1];
        currentSolution = currentState.solution;
        currentEnergy = currentState.energy;
        temperature = currentState.temperature;
        iterationCount = iterations.length - 1;

        // Log resume state
        addLogEntry(`Resuming simulation from iteration ${iterationCount} with T = ${temperature.toFixed(2)}`, true);
    }

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
            pauseBtn.disabled = true;

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
                addLogEntry(`Iteration ${iterationCount}: x = ${newSolution.toFixed(4)}, f(x) = ${newEnergy.toFixed(4)}, T° = ${temperature.toFixed(2)}, ACCEPTED (NEW BEST)`, true, true);
            } else {
                addLogEntry(`Iteration ${iterationCount}: x = ${newSolution.toFixed(4)}, f(x) = ${newEnergy.toFixed(4)}, T° = ${temperature.toFixed(2)}, ACCEPTED`, true);
            }

            // Update current solution if accepted
            currentSolution = newSolution;
            currentEnergy = newEnergy;
        } else {
            addLogEntry(`Iteration ${iterationCount}: x = ${newSolution.toFixed(4)}, f(x) = ${newEnergy.toFixed(4)}, T° = ${temperature.toFixed(2)}, REJECTED`, false);
        }

        // Cool down
        temperature *= coolingRate;

        // Update visualization
        drawFunctionCanvas();
        drawTemperatureCanvas();
    }, 50); // Update every 50ms for animation
}

// Add event listeners for buttons
startBtn.addEventListener('click', runSimulation);
pauseBtn.addEventListener('click', pauseSimulation);
resetBtn.addEventListener('click', resetSimulation);

// Initialize the simulation on load
initializeSimulation();

</script>
