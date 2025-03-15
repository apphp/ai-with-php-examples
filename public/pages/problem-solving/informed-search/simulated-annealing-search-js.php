
<!-- React component inline -->
<script type="text/babel">
    const { useState, useEffect, useRef } = React;

    const SimulatedAnnealingAnimation = () => {
        // Canvas references
        const landscapeCanvasRef = useRef(null);
        const graphCanvasRef = useRef(null);

        // Animation state
        const [animating, setAnimating] = useState(false);
        const [speed, setSpeed] = useState(1);
        const [currentStep, setCurrentStep] = useState(0);
        const [currentTemperature, setCurrentTemperature] = useState(1000);
        const [currentEnergy, setCurrentEnergy] = useState(0);
        const [bestEnergy, setBestEnergy] = useState(0);
        const [currentX, setCurrentX] = useState(0);
        const [bestX, setBestX] = useState(0);
        const [energyHistory, setEnergyHistory] = useState([]);
        const [tempHistory, setTempHistory] = useState([]);
        const [pathHistory, setPathHistory] = useState([]);
        const [message, setMessage] = useState('Click "Start" to begin the simulation');

        // Constants
        const maxSteps = 500;
        const initialTemp = 1000;
        const minTemp = 0.1;
        const coolingRate = 0.99;
        const canvasWidth = 600;
        const canvasHeight = 300;
        const graphHeight = 150;

        // Energy landscape function (a complex function with multiple local minima)
        const landscape = (x) => {
            return 30 * Math.sin(0.1 * x) +
                20 * Math.sin(0.15 * x) +
                50 * Math.sin(0.04 * x) +
                10 * Math.sin(0.3 * x) +
                150; // Base height
        };

        // Generate a random nearby solution
        const getNeighbor = (x, temp) => {
            // Step size is proportional to current temperature
            const stepSize = Math.min(Math.max(30 * (temp / initialTemp), 5), 50);
            return x + (Math.random() * 2 - 1) * stepSize;
        };

        // Acceptance probability
        const acceptanceProbability = (currentEnergy, newEnergy, temp) => {
            if (newEnergy < currentEnergy) return 1.0;
            return Math.exp((currentEnergy - newEnergy) / temp);
        };

        // Initialize the simulation
        useEffect(() => {
            // Set initial position
            const startX = Math.random() * canvasWidth;
            const startEnergy = landscape(startX);

            setCurrentX(startX);
            setCurrentEnergy(startEnergy);
            setBestX(startX);
            setBestEnergy(startEnergy);
            setEnergyHistory([startEnergy]);
            setTempHistory([initialTemp]);
            setPathHistory([{x: startX, y: startEnergy, accepted: true}]);

            // Initialize algorithm log
            const logDiv = document.getElementById('algorithm-log');
            if (logDiv) {
                logDiv.innerHTML = '<div class="log-entry-info">Simulation initialized. Starting position: x=' +
                    startX.toFixed(2) + ', energy=' + startEnergy.toFixed(2) + '</div>';
            }

            drawLandscape();
            drawGraphs();

            return () => {
                // Cleanup animation
                setAnimating(false);
            };
        }, []);

        // Draw energy landscape
        const drawLandscape = () => {
            const canvas = landscapeCanvasRef.current;
            if (!canvas) return;

            const ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvasWidth, canvasHeight);

            // Draw landscape background
            const gradient = ctx.createLinearGradient(0, 0, 0, canvasHeight);
            gradient.addColorStop(0, '#e6f7ff');
            gradient.addColorStop(1, '#ffffff');
            ctx.fillStyle = gradient;
            ctx.fillRect(0, 0, canvasWidth, canvasHeight);

            // Draw grid lines
            ctx.strokeStyle = '#e0e0e0';
            ctx.lineWidth = 1;
            for (let x = 0; x < canvasWidth; x += 50) {
                ctx.beginPath();
                ctx.moveTo(x, 0);
                ctx.lineTo(x, canvasHeight);
                ctx.stroke();
            }
            for (let y = 0; y < canvasHeight; y += 50) {
                ctx.beginPath();
                ctx.moveTo(0, y);
                ctx.lineTo(canvasWidth, y);
                ctx.stroke();
            }

            // Draw the energy landscape
            ctx.beginPath();
            ctx.moveTo(0, canvasHeight - landscape(0));
            for (let x = 1; x <= canvasWidth; x++) {
                const y = landscape(x);
                ctx.lineTo(x, canvasHeight - y);
            }
            ctx.strokeStyle = '#333';
            ctx.lineWidth = 2;
            ctx.stroke();

            // Fill the area under the curve
            ctx.lineTo(canvasWidth, canvasHeight);
            ctx.lineTo(0, canvasHeight);
            ctx.closePath();
            ctx.fillStyle = 'rgba(100, 149, 237, 0.2)';
            ctx.fill();

            // Mark local minima
            const localMinima = [50, 160, 270, 370, 520];
            localMinima.forEach((x, i) => {
                const y = landscape(x);
                const isGlobal = i === 4; // Last one is global minimum

                ctx.beginPath();
                ctx.arc(x, canvasHeight - y, 6, 0, Math.PI * 2);
                ctx.fillStyle = isGlobal ? 'rgba(0, 0, 255, 0.7)' : 'rgba(255, 0, 0, 0.5)';
                ctx.fill();

                ctx.font = '10px Arial';
                ctx.fillStyle = '#333';
                ctx.textAlign = 'center';
                ctx.fillText(isGlobal ? 'Global Min' : 'Local Min', x, canvasHeight - y - 15);
            });

            // Draw solution path
            if (pathHistory.length > 1) {
                ctx.beginPath();
                ctx.moveTo(pathHistory[0].x, canvasHeight - pathHistory[0].y);

                for (let i = 1; i < pathHistory.length; i++) {
                    const point = pathHistory[i];
                    if (point.accepted) {
                        ctx.lineTo(point.x, canvasHeight - point.y);
                    } else {
                        // Draw a dashed line for rejected solutions
                        ctx.setLineDash([2, 2]);
                        ctx.lineTo(point.x, canvasHeight - point.y);
                        ctx.stroke();
                        ctx.setLineDash([]);
                        ctx.beginPath();
                        ctx.moveTo(pathHistory[i-1].x, canvasHeight - pathHistory[i-1].y);
                    }
                }

                ctx.strokeStyle = 'rgba(255, 165, 0, 0.8)';
                ctx.lineWidth = 2;
                ctx.stroke();
            }

            // Draw current position
            ctx.beginPath();
            ctx.arc(currentX, canvasHeight - currentEnergy, 8, 0, Math.PI * 2);
            ctx.fillStyle = 'rgba(255, 0, 0, 0.8)';
            ctx.fill();
            ctx.strokeStyle = '#000';
            ctx.lineWidth = 1;
            ctx.stroke();

            // Draw best solution
            ctx.beginPath();
            ctx.arc(bestX, canvasHeight - bestEnergy, 8, 0, Math.PI * 2);
            ctx.fillStyle = 'rgba(0, 128, 0, 0.8)';
            ctx.fill();
            ctx.strokeStyle = '#000';
            ctx.lineWidth = 1;
            ctx.stroke();
        };

        // Draw graph showing temperature and energy over time
        const drawGraphs = () => {
            const canvas = graphCanvasRef.current;
            if (!canvas || energyHistory.length === 0) return;

            const ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvasWidth, graphHeight);

            // Fill background
            ctx.fillStyle = '#f5f5f5';
            ctx.fillRect(0, 0, canvasWidth, graphHeight);

            // Draw grid lines
            ctx.strokeStyle = '#e0e0e0';
            ctx.lineWidth = 1;
            for (let x = 0; x < canvasWidth; x += 50) {
                ctx.beginPath();
                ctx.moveTo(x, 0);
                ctx.lineTo(x, graphHeight);
                ctx.stroke();
            }
            for (let y = 0; y < graphHeight; y += 25) {
                ctx.beginPath();
                ctx.moveTo(0, y);
                ctx.lineTo(canvasWidth, y);
                ctx.stroke();
            }

            // Draw axes labels
            ctx.font = '12px Arial';
            ctx.fillStyle = '#333';
            ctx.textAlign = 'left';
            ctx.fillText('Energy & Temperature', 10, 15);
            ctx.textAlign = 'right';
            ctx.fillText('Steps', canvasWidth - 10, graphHeight - 5);

            if (energyHistory.length <= 1) return;

            // Find min and max values for scaling
            const maxEnergy = Math.max(...energyHistory);
            const minEnergy = Math.min(...energyHistory);
            const energyRange = maxEnergy - minEnergy;

            // Scale the histories to fit the canvas
            const scaleX = canvasWidth / (maxSteps > 0 ? maxSteps : 1);
            const scaleEnergyY = (graphHeight - 20) / (energyRange > 0 ? energyRange : 1);
            const scaleTempY = (graphHeight - 20) / initialTemp;

            // Draw energy history
            ctx.beginPath();
            for (let i = 0; i < energyHistory.length; i++) {
                const x = i * scaleX;
                const y = graphHeight - 10 - (energyHistory[i] - minEnergy) * scaleEnergyY;

                if (i === 0) {
                    ctx.moveTo(x, y);
                } else {
                    ctx.lineTo(x, y);
                }
            }
            ctx.strokeStyle = 'blue';
            ctx.lineWidth = 2;
            ctx.stroke();

            // Draw temperature history
            ctx.beginPath();
            for (let i = 0; i < tempHistory.length; i++) {
                const x = i * scaleX;
                const y = graphHeight - 10 - tempHistory[i] * scaleTempY;

                if (i === 0) {
                    ctx.moveTo(x, y);
                } else {
                    ctx.lineTo(x, y);
                }
            }
            ctx.strokeStyle = 'red';
            ctx.lineWidth = 2;
            ctx.stroke();

            // Add legend
            ctx.fillStyle = 'blue';
            ctx.fillRect(canvasWidth - 100, 10, 10, 10);
            ctx.fillStyle = '#333';
            ctx.textAlign = 'left';
            ctx.fillText('Energy', canvasWidth - 85, 20);

            ctx.fillStyle = 'red';
            ctx.fillRect(canvasWidth - 100, 30, 10, 10);
            ctx.fillStyle = '#333';
            ctx.fillText('Temperature', canvasWidth - 85, 40);
        };

        // Run a single step of the algorithm
        const runStep = () => {
            if (currentStep >= maxSteps || currentTemperature <= minTemp) {
                setAnimating(false);
                setMessage(`Simulation complete. Best solution found has energy: ${bestEnergy.toFixed(2)}`);
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
            setPathHistory(prev => [...prev, {
                x: boundedX,
                y: newEnergy,
                accepted
            }]);

            // Update current solution if accepted
            if (accepted) {
                setCurrentX(boundedX);
                setCurrentEnergy(newEnergy);

                // Update best solution if better
                if (newEnergy < bestEnergy) {
                    setBestX(boundedX);
                    setBestEnergy(newEnergy);
                }
            }

            // Update temperature
            const newTemp = currentTemperature * coolingRate;
            setCurrentTemperature(newTemp);

            // Update histories
            setEnergyHistory(prev => [...prev, accepted ? newEnergy : prev[prev.length - 1]]);
            setTempHistory(prev => [...prev, newTemp]);

            // Increment step
            setCurrentStep(prev => prev + 1);

            // Update message
            const stepMessage = `Step ${currentStep + 1}: Temperature = ${newTemp.toFixed(2)}, ` +
                `New solution ${accepted ? 'ACCEPTED' : 'REJECTED'} (probability: ${ap.toFixed(4)})`;
            setMessage(stepMessage);

            // Log to algorithm log
            const logDiv = document.getElementById('algorithm-log');
            if (logDiv) {
                const logEntry = document.createElement('div');
                logEntry.textContent = `[${new Date().toLocaleTimeString()}] ${stepMessage}`;
                if (accepted) {
                    logEntry.className = 'log-entry-accepted';
                } else {
                    logEntry.className = 'log-entry-rejected';
                }
                logDiv.appendChild(logEntry);
                logDiv.scrollTop = logDiv.scrollHeight;
            }

            // Redraw visuals
            drawLandscape();
            drawGraphs();
        };

        // Animation loop
        useEffect(() => {
            let animationId;
            let stepCounter = 0;

            const animate = () => {
                // Handle fractional speeds
                stepCounter += speed;

                // Only run steps when we have accumulated enough for at least one step
                while (stepCounter >= 1) {
                    runStep();
                    stepCounter -= 1;
                }

                if (animating && currentStep < maxSteps && currentTemperature > minTemp) {
                    animationId = requestAnimationFrame(animate);
                } else {
                    setAnimating(false);
                }
            };

            if (animating) {
                animationId = requestAnimationFrame(animate);
            }

            return () => {
                if (animationId) {
                    cancelAnimationFrame(animationId);
                }
            };
        }, [animating, currentStep, currentTemperature, currentX, currentEnergy, bestX, bestEnergy, speed]);

        // Toggle animation
        const toggleAnimation = () => {
            setAnimating(!animating);
        };

        // Reset simulation
        const resetSimulation = () => {
            setAnimating(false);
            setCurrentStep(0);
            setCurrentTemperature(initialTemp);

            const startX = Math.random() * canvasWidth;
            const startEnergy = landscape(startX);

            setCurrentX(startX);
            setCurrentEnergy(startEnergy);
            setBestX(startX);
            setBestEnergy(startEnergy);
            setEnergyHistory([startEnergy]);
            setTempHistory([initialTemp]);
            setPathHistory([{x: startX, y: startEnergy, accepted: true}]);

            setMessage('Click "Start" to begin the simulation');

            // Clear algorithm log
            const logDiv = document.getElementById('algorithm-log');
            if (logDiv) {
                logDiv.innerHTML = '<div class="log-entry-info">Simulation reset. Ready to start.</div>';
            }

            drawLandscape();
            drawGraphs();
        };

        return (
            <div className="row g-4 bg-light p-4 rounded shadow">
                {/* Left panel - Visualizations */}
                <div className="col-md-6">
                    <h2 className="mb-4 fw-bold">Simulated Annealing Visualization</h2>

                    <div className="bg-white p-3 rounded shadow mb-4">
                        <div className="mb-2 d-flex justify-content-between align-items-center">
                            <h3 className="fs-5 fw-semibold">Energy Landscape</h3>
                            <div className="small text-secondary">Step: {currentStep} / {maxSteps}</div>
                        </div>

                        <canvas
                            ref={landscapeCanvasRef}
                            width={canvasWidth}
                            height={canvasHeight}
                            className="border rounded"
                        />

                        <div className="row row-cols-2 row-cols-md-4 g-2 mt-2 small">
                            <div className="col">
                                <div className="legend-item">
                                    <div className="legend-marker" style={{backgroundColor: '#FF0000'}}></div>
                                    <span>Current Solution</span>
                                </div>
                            </div>
                            <div className="col">
                                <div className="legend-item">
                                    <div className="legend-marker" style={{backgroundColor: '#008000'}}></div>
                                    <span>Best Solution</span>
                                </div>
                            </div>
                            <div className="col">
                                <div className="legend-item">
                                    <div className="legend-marker" style={{backgroundColor: '#FF0000', opacity: 0.5}}></div>
                                    <span>Local Minima</span>
                                </div>
                            </div>
                            <div className="col">
                                <div className="legend-item">
                                    <div className="legend-marker" style={{backgroundColor: '#0000FF', opacity: 0.7}}></div>
                                    <span>Global Minimum</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div className="bg-white p-3 rounded shadow mb-4">
                        <h3 className="fs-5 fw-semibold mb-2">Energy & Temperature Over Time</h3>
                        <canvas
                            ref={graphCanvasRef}
                            width={canvasWidth}
                            height={graphHeight}
                            className="border rounded"
                        />
                    </div>
                </div>

                {/* Right panel - Controls and Info */}
                <div className="col-md-6">
                    <div className="bg-white p-3 rounded shadow mb-4">
                        <h3 className="fs-5 fw-semibold mb-2">Algorithm Status</h3>

                        <div className="row row-cols-1 row-cols-md-2 g-3 mb-3">
                            <div className="col">
                                <p className="small fw-medium mb-1">Temperature:</p>
                                <div className="d-flex align-items-center">
                                    <div className="progress flex-grow-1" style={{height: '8px'}}>
                                        <div
                                            className="progress-bar bg-danger"
                                            style={{width: `${Math.max(0, Math.min(100, (currentTemperature / initialTemp) * 100))}%`}}
                                        ></div>
                                    </div>
                                    <span className="ms-2 small">{currentTemperature.toFixed(2)}</span>
                                </div>
                            </div>

                            <div className="col">
                                <p className="small fw-medium mb-1">Current Energy:</p>
                                <div className="fs-5 fw-semibold">{currentEnergy.toFixed(2)}</div>
                            </div>

                            <div className="col">
                                <p className="small fw-medium mb-1">Best Energy:</p>
                                <div className="fs-5 fw-semibold text-success">{bestEnergy.toFixed(2)}</div>
                            </div>

                            <div className="col">
                                <p className="small fw-medium mb-1">Acceptance Probability:</p>
                                <div className="fs-6">
                                    P = e<sup>-ΔE/T</sup> = e<sup>-(E<sub>new</sub>-E<sub>current</sub>)/T</sup>
                                </div>
                            </div>
                        </div>

                        <div className="bg-info bg-opacity-10 p-3 rounded border border-info border-opacity-25">
                            <p className="small mb-0">{message}</p>
                        </div>
                    </div>

                    <div className="mb-4 d-flex flex-wrap gap-2 align-items-center">
                        <button
                            onClick={toggleAnimation}
                            className={`btn ${animating ? 'btn-danger' : 'btn-success'}`}
                        >
                            {animating ? 'Pause' : 'Start'}
                        </button>

                        <button
                            onClick={resetSimulation}
                            className="btn btn-secondary"
                        >
                            Reset
                        </button>

                        <div className="d-flex align-items-center ms-2">
                            <span className="me-2 small fw-medium">Speed:</span>
                            <select
                                value={speed}
                                onChange={(e) => setSpeed(Number(e.target.value))}
                                className="form-select form-select-sm"
                            >
                                <option value="0.25">0.25x</option>
                                <option value="0.5">0.5x</option>
                                <option value="0.75">0.75x</option>
                                <option value="1">1x</option>
                                <option value="1.5">1.5x</option>
                                <option value="2">2x</option>
                                <option value="3">3x</option>
                                <option value="5">5x</option>
                                <option value="10">10x</option>
                            </select>
                        </div>
                    </div>

                    <div className="bg-light bg-opacity-75 p-3 rounded border mb-4">
                        <h3 className="fs-5 fw-semibold mb-2">How Simulated Annealing Works</h3>
                        <div className="small">
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
                            <p className="mb-0">
                                <strong>Key Insight:</strong> The acceptance probability (P = e<sup>-ΔE/T</sup>) allows the
                                algorithm to escape local minima while eventually settling in a good solution.
                            </p>
                        </div>
                    </div>

                    <div id="algorithm-log" className="algorithm-log p-3 rounded shadow-inner"></div>
                </div>
            </div>
        );
    };

    // Mount the component to the DOM
    ReactDOM.createRoot(document.getElementById('root')).render(
        <React.StrictMode>
            <SimulatedAnnealingAnimation />
        </React.StrictMode>
    );
</script>
