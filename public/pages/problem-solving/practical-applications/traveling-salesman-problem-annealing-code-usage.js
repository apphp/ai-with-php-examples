<script type="text/babel">
    const {useState, useEffect, useRef} = React;

    const SimulatedAnnealingVisualization = () => {
    // Ref for the log container to enable auto-scrolling
    const logContainerRef = useRef(null);
    const [temperature, setTemperature] = useState(1000);
    const [iteration, setIteration] = useState(0);
    const [currentRoute, setCurrentRoute] = useState([]);
    const [bestRoute, setBestRoute] = useState([]);
    const [bestDistance, setBestDistance] = useState(Number.MAX_VALUE);
    const [running, setRunning] = useState(false);
    const [log, setLog] = useState([]);

    const cities = [
{name: 'New York', x: 300, y: 100},
{name: 'Los Angeles', x: 100, y: 400},
{name: 'Chicago', x: 400, y: 200},
{name: 'Houston', x: 200, y: 350},
{name: 'Phoenix', x: 300, y: 350},
{name: 'Boston', x: 500, y: 80},
    ];

    // Generate a random route
    const generateRandomRoute = () => {
    const indices = Array.from({ length: cities.length }, (_, i) => i);
    // Fisher-Yates shuffle algorithm
    for (let i = indices.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [indices[i], indices[j]] = [indices[j], indices[i]];
}
    return indices;
};

    // Calculate distance between two cities
    const distance = (city1, city2) => {
    const dx = city1.x - city2.x;
    const dy = city1.y - city2.y;
    return Math.sqrt(dx * dx + dy * dy);
};

    // Calculate total route distance
    const calculateRouteDistance = (route) => {
    let total = 0;
    for (let i = 0; i < route.length; i++) {
    const from = cities[route[i]];
    const to = cities[route[(i + 1) % route.length]];
    total += distance(from, to);
}
    return total;
};

    // Generate a neighbor by swapping two cities
    const getNeighbor = (route) => {
    const newRoute = [...route];
    const i = Math.floor(Math.random() * route.length);
    let j = Math.floor(Math.random() * route.length);
    while (j === i) {
    j = Math.floor(Math.random() * route.length);
}

    // Swap
    const temp = newRoute[i];
    newRoute[i] = newRoute[j];
    newRoute[j] = temp;

    return newRoute;
};

    // Acceptance probability function
    const acceptanceProbability = (currentDistance, newDistance, temp) => {
    if (newDistance < currentDistance) {
    return 1.0;
}
    return Math.exp((currentDistance - newDistance) / temp);
};

    // Reset and start new simulation
    const start = () => {
    const initialRoute = generateRandomRoute();
    const initialDistance = calculateRouteDistance(initialRoute);

    setTemperature(1000);
    setIteration(0);
    setCurrentRoute(initialRoute);
    setBestRoute(initialRoute);
    setBestDistance(initialDistance);
    setLog([`Starting with random route, initial distance: ${initialDistance.toFixed(1)}`]);
    setRunning(true);
};

    // Stop the simulation
    const stop = () => {
    setRunning(false);
    setLog(prev => {
    const newLog = [...prev, `Simulation stopped manually at iteration ${iteration}`];
    setTimeout(() => scrollToBottom(), 0);
    return newLog;
});
};

    // Function to scroll the log container to the bottom
    const scrollToBottom = () => {
    if (logContainerRef.current) {
    logContainerRef.current.scrollTop = logContainerRef.current.scrollHeight;
}
};

    // Initialization effect - generate random initial route
    useEffect(() => {
    const initialRoute = generateRandomRoute();
    setCurrentRoute(initialRoute);
    setBestRoute(initialRoute);
    setBestDistance(calculateRouteDistance(initialRoute));
}, []);

    // Run one iteration of simulated annealing
    useEffect(() => {
    if (!running) return;

    const timer = setTimeout(() => {
    if (temperature > 0.1) {
    // Get a new solution
    const neighbor = getNeighbor(currentRoute);
    const currentDist = calculateRouteDistance(currentRoute);
    const neighborDist = calculateRouteDistance(neighbor);

    // Add log for every iteration
    const probability = acceptanceProbability(currentDist, neighborDist, temperature);
    const accepted = Math.random() < probability;

    setLog(prev => {
    const newLog = [...prev,
    `Iteration ${iteration}: Temp=${temperature.toFixed(2)}, ` +
    `Current=${currentDist.toFixed(1)}, Neighbor=${neighborDist.toFixed(1)}, ` +
    `Prob=${probability.toFixed(4)}, ${accepted ? 'Accepted' : 'Rejected'}`
    ];
    // Schedule scroll to bottom after state update
    setTimeout(() => scrollToBottom(), 0);
    return newLog;
});

    // Decide whether to accept new solution
    if (accepted) {
    setCurrentRoute(neighbor);

    // Update best solution if we found a better one
    if (neighborDist < bestDistance) {
    setBestRoute(neighbor);
    setBestDistance(neighborDist);
    setLog(prev => {
    const newLog = [...prev, `Iteration ${iteration}: Found better route with distance ${neighborDist.toFixed(1)}`];
    setTimeout(() => scrollToBottom(), 0);
    return newLog;
});
}
}

    // Cool down
    setTemperature(temp => temp * 0.99);
    setIteration(iter => iter + 1);
} else {
    setRunning(false);
    setLog(prev => {
    const newLog = [...prev, `Optimization complete! Best distance: ${bestDistance.toFixed(1)}`];
    setTimeout(() => scrollToBottom(), 0);
    return newLog;
});
}
}, 100);

    return () => clearTimeout(timer);
}, [running, temperature, iteration, currentRoute, bestRoute, bestDistance]);

    // Get coordinates for drawing a route
    const getPathCoordinates = (route) => {
    return route.map(i => `${cities[i].x},${cities[i].y}`).join(' ') +
    ` ${cities[route[0]].x},${cities[route[0]].y}`;
};

    return (
    <div className="container-fluid p-0 m-0">
    <div className="row">
    <div className="col-lg-7 mb-4 mb-md-0">
    <div className="card h-100">
    <div className="card-body p-0">
    <svg width="100%" _height="700" viewBox="0 0 600 500" preserveAspectRatio="xMidYMid meet">
{/* Background grid */}
    {Array.from({length: 11}, (_, i) => (
        <line
            key={`vgrid-${i}`}
            x1={50 + i * 50}
            y1={50}
            x2={50 + i * 50}
            y2={450}
            stroke="#eee"
            strokeWidth="1"
        />
    ))}
    {Array.from({length: 9}, (_, i) => (
        <line
            key={`hgrid-${i}`}
            x1={50}
            y1={50 + i * 50}
            x2={550}
            y2={50 + i * 50}
            stroke="#eee"
            strokeWidth="1"
        />
    ))}

    {/* Grid coordinates */}
    {Array.from({length: 11}, (_, i) => (
        <text
            key={`vgrid-text-${i}`}
            x={50 + i * 50}
            y={470}
            textAnchor="middle"
            fill="#999"
            fontSize="10"
        >
            {i}
        </text>
    ))}
    {Array.from({length: 9}, (_, i) => (
        <text
            key={`hgrid-text-${i}`}
            x={40}
            y={55 + i * 50}
            textAnchor="end"
            fill="#999"
            fontSize="10"
        >
            {i}
        </text>
    ))}

    {/* City nodes */}
    {cities.map((city, i) => (
        <g key={i}>
            <circle
                cx={city.x}
                cy={city.y}
                r={10}
                fill="#3498db"
            />
            <text
                x={city.x}
                y={city.y - 15}
                textAnchor="middle"
                fill="#333"
                fontSize="12"
            >
                {city.name}
            </text>
        </g>
    ))}

    {/* Current route */}
    {currentRoute.length > 0 && (
        <polyline
            points={getPathCoordinates(currentRoute)}
            fill="none"
            stroke="#e74c3c"
            strokeWidth="2"
            strokeDasharray="5,5"
        />
    )}

    {/* Best route */}
    {bestRoute.length > 0 && (
        <polyline
            points={getPathCoordinates(bestRoute)}
            fill="none"
            stroke="#27ae60"
            strokeWidth="3"
        />
    )}
</svg>
</div>
</div>
</div>

<div className="col-lg-5">
    <div className="row gy-4"> {/* Bootstrap 5 uses gy-4 for row gaps */}
        {/* Algorithm Status */}
        <div className="col-12">
            <div className="card">
                <div className="card-body">
                    <h5 className="card-title">Algorithm Status</h5>
                    <div className="row">
                        <div className="col-6 fw-bold">Temperature:</div>
                        <div className="col-6">{temperature.toFixed(2)}&deg;</div>

                        <div className="col-6 fw-bold">Cooling Factor:</div>
                        <div className="col-6">0.99</div>

                        <div className="col-6 fw-bold">Iteration:</div>
                        <div className="col-6">{iteration}</div>

                        <div className="col-6 fw-bold">Current Distance:</div>
                        <div className="col-6">{currentRoute.length > 0 ? calculateRouteDistance(currentRoute).toFixed(1) : 'N/A'}</div>

                        <div className="col-6 fw-bold">Best Distance:</div>
                        <div className="col-6">{bestRoute.length > 0 ? bestDistance.toFixed(1) : 'N/A'}</div>
                    </div>
                </div>
            </div>
        </div>

        {/* Control buttons */}
        <div className="col-12">
            <div className="card">
                <div className="card-body d-flex justify-content-center gap-3">
                    <button
                        onClick={start}
                        disabled={running}
                        className="btn btn-primary"
                    >
                        {running ? 'Running...' : 'Start Simulation'}
                    </button>
                    <button
                        onClick={stop}
                        disabled={!running}
                        className="btn btn-danger"
                    >
                        Stop
                    </button>
                </div>
            </div>
        </div>

        {/* Legend section */}
        <div className="col-12">
            <div className="card bg-light">
                <div className="card-body">
                    <h5 className="card-title">Legend</h5>
                    <div className="d-flex align-items-center mb-2">
                        <div style={{
                            width: '24px',
                            height: '3px',
                            backgroundColor: '#e74c3c',
                            marginRight: '8px'
                        }}></div>
                        <span>Current Solution (being explored)</span>
                    </div>
                    <div className="d-flex align-items-center">
                        <div style={{
                            width: '24px',
                            height: '3px',
                            backgroundColor: '#27ae60',
                            marginRight: '8px'
                        }}></div>
                        <span>Best Solution Found</span>
                    </div>
                </div>
            </div>
        </div>

        {/* Event Log section */}
        <div className="col-12">
            <div className="card">
                <div className="card-body">
                    <h5 className="card-title">Event Log</h5>
                    <div
                        ref={logContainerRef}
                        style={{height: '200px', overflowY: 'auto'}}
                        className="small"
                    >
                        {log.map((entry, i) => (
                            <div key={i} className="mb-1">{entry}</div>
                        ))}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
);
};

// Mount the component to the DOM
ReactDOM.createRoot(document.getElementById('root')).render(
<React.StrictMode>
    <SimulatedAnnealingVisualization/>
</React.StrictMode>
);
</script>
