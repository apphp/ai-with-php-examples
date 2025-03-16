<?php

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('simulated-annealing-process-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Practical Applications</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Traveling Salesman Problem</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?= create_href('problem-solving', 'practical-applications', 'simulated-annealing-process') ?>"
               class="btn btn-sm btn-outline-primary">Show
                Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        ...
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/traveling-salesman-problem-code-usage.php'); ?>
</div>

<div class="container-fluid px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-12 px-1 pe-4">
            <p><b>Graph:</b></p>

            <div id="root" class="_container py-4"></div>

            <!-- React component inline -->
            <script type="text/babel">
                const { useState, useEffect, useRef } = React;

                // import React, { useState, useEffect } from 'react';

                const SimulatedAnnealingVisualization = () => {
                    const [temperature, setTemperature] = useState(1000);
                    const [iteration, setIteration] = useState(0);
                    const [currentRoute, setCurrentRoute] = useState([0, 1, 2, 3, 4, 5]);
                    const [bestRoute, setBestRoute] = useState([0, 1, 2, 3, 4, 5]);
                    const [bestDistance, setBestDistance] = useState(Number.MAX_VALUE);
                    const [running, setRunning] = useState(false);
                    const [log, setLog] = useState([]);

                    const cities = [
                        { name: 'New York', x: 300, y: 100 },
                        { name: 'Los Angeles', x: 100, y: 400 },
                        { name: 'Chicago', x: 400, y: 200 },
                        { name: 'Houston', x: 200, y: 350 },
                        { name: 'Phoenix', x: 300, y: 350 },
                        { name: 'Boston', x: 500, y: 80 },
                    ];

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
                        setTemperature(1000);
                        setIteration(0);
                        setCurrentRoute([0, 1, 2, 3, 4, 5]);
                        setBestRoute([0, 1, 2, 3, 4, 5]);
                        setBestDistance(calculateRouteDistance([0, 1, 2, 3, 4, 5]));
                        setLog([]);
                        setRunning(true);
                    };

                    // Run one iteration of simulated annealing
                    useEffect(() => {
                        if (!running) return;

                        const timer = setTimeout(() => {
                            if (temperature > 0.1) {
                                // Get a new solution
                                const neighbor = getNeighbor(currentRoute);
                                const currentDist = calculateRouteDistance(currentRoute);
                                const neighborDist = calculateRouteDistance(neighbor);

                                // Decide whether to accept new solution
                                if (Math.random() < acceptanceProbability(currentDist, neighborDist, temperature)) {
                                    setCurrentRoute(neighbor);

                                    // Update best solution if we found a better one
                                    if (neighborDist < bestDistance) {
                                        setBestRoute(neighbor);
                                        setBestDistance(neighborDist);
                                        setLog(prev => [...prev, `Iteration ${iteration}: Found better route with distance ${neighborDist.toFixed(1)}`]);
                                    }
                                }

                                // Cool down
                                setTemperature(temp => temp * 0.99);
                                setIteration(iter => iter + 1);
                            } else {
                                setRunning(false);
                                setLog(prev => [...prev, `Optimization complete! Best distance: ${bestDistance.toFixed(1)}`]);
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
                        <div className="flex flex-col items-center w-full">
                            <h2 className="text-2xl font-bold mb-4">Simulated Annealing Visualization</h2>

                            <div className="flex w-full mb-4">
                                <div className="border border-gray-300 p-4 bg-white rounded-md mr-4" style={{ width: '600px', height: '500px' }}>
                                    <svg width="600" height="500">
                                        {/* Background grid */}
                                        {Array.from({ length: 11 }, (_, i) => (
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
                                        {Array.from({ length: 9 }, (_, i) => (
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
                                        {Array.from({ length: 11 }, (_, i) => (
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
                                        {Array.from({ length: 9 }, (_, i) => (
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
                                        <polyline
                                            points={getPathCoordinates(currentRoute)}
                                            fill="none"
                                            stroke="#e74c3c"
                                            strokeWidth="2"
                                            strokeDasharray="5,5"
                                        />

                                        {/* Best route */}
                                        <polyline
                                            points={getPathCoordinates(bestRoute)}
                                            fill="none"
                                            stroke="#27ae60"
                                            strokeWidth="3"
                                        />
                                    </svg>
                                </div>

                                <div className="flex flex-col flex-1">
                                    <div className="bg-white p-4 border border-gray-300 rounded-md mb-4">
                                        <h3 className="font-semibold mb-2">Algorithm Status</h3>
                                        <div className="grid grid-cols-2 gap-2">
                                            <div className="font-medium">Temperature:</div>
                                            <div>{temperature.toFixed(2)}</div>

                                            <div className="font-medium">Iteration:</div>
                                            <div>{iteration}</div>

                                            <div className="font-medium">Current Distance:</div>
                                            <div>{calculateRouteDistance(currentRoute).toFixed(1)}</div>

                                            <div className="font-medium">Best Distance:</div>
                                            <div>{bestDistance.toFixed(1)}</div>
                                        </div>
                                    </div>

                                    <div className="bg-white p-4 border border-gray-300 rounded-md flex-1 overflow-auto">
                                        <h3 className="font-semibold mb-2">Event Log</h3>
                                        <div className="text-sm">
                                            {log.map((entry, i) => (
                                                <div key={i} className="mb-1">{entry}</div>
                                            ))}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div className="flex justify-center">
                                <button
                                    onClick={start}
                                    disabled={running}
                                    className="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 disabled:bg-gray-400"
                                >
                                    {running ? 'Running...' : 'Start Simulation'}
                                </button>
                            </div>

                            <div className="mt-4 p-4 bg-gray-100 rounded-md w-full">
                                <h3 className="font-semibold mb-2">Legend</h3>
                                <div className="flex items-center mb-2">
                                    <div className="w-6 h-1 bg-red-500 mr-2"></div>
                                    <span>Current Solution (being explored)</span>
                                </div>
                                <div className="flex items-center">
                                    <div className="w-6 h-1 bg-green-600 mr-2"></div>
                                    <span>Best Solution Found</span>
                                </div>
                            </div>
                        </div>
                    );
                };

                // Mount the component to the DOM
                ReactDOM.createRoot(document.getElementById('root')).render(
                    <React.StrictMode>
                        <SimulatedAnnealingVisualization />
                    </React.StrictMode>
                );
            </script>
        </div>
    </div>
</div>

