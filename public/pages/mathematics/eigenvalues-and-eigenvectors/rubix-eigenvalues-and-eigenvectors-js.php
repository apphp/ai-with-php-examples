<script type="text/babel">
    // Constants
    const targetMatrix = [[4, 1], [2, 3]];
    const eigenvalues = [5, 2];
    const eigenvectors = [[1, 1], [2, -1]];

    // Event bus for communication between components
    const eventBus = {
        listeners: {},
        subscribe(event, callback) {
            if (!this.listeners[event]) {
                this.listeners[event] = [];
            }
            this.listeners[event].push(callback);
            return () => this.unsubscribe(event, callback);
        },
        emit(event, data) {
            if (this.listeners[event]) {
                this.listeners[event].forEach(callback => callback(data));
            }
        },
        unsubscribe(event, callback) {
            if (this.listeners[event]) {
                this.listeners[event] = this.listeners[event].filter(cb => cb !== callback);
            }
        }
    };

    function MatrixDisplay({ matrix }) {
        return (
            <div className="matrix">
                [
                {matrix.map((row, i) => (
                    <div key={i} style={{marginLeft: '1em'}}>
                        {row.map(v => v.toFixed(2)).join(', ')}
                    </div>
                ))}
                ]
            </div>
        );
    }

    function Visualization({ t, showVectors }) {
        // Interpolate current matrix
        const matrix = [
            [1 + (targetMatrix[0][0] - 1) * t, targetMatrix[0][1] * t],
            [targetMatrix[1][0] * t, 1 + (targetMatrix[1][1] - 1) * t]
        ];

        // Create circle points
        const points = [];
        for (let angle = 0; angle < Math.PI * 2; angle += 0.1) {
            points.push([Math.cos(angle) * 15, Math.sin(angle) * 15]);
        }

        // Transform points
        const transformedPoints = points.map(([x, y]) => [
            matrix[0][0] * x + matrix[0][1] * y,
            matrix[1][0] * x + matrix[1][1] * y
        ]);

        // Scale eigenvalues
        const currentEigenvalues = eigenvalues.map(λ => 1 + (λ - 1) * t);

        return (
            <div>
                <h2></h2>
                <svg width="100%" height="650" viewBox="-40 -40 80 80">
                    {/* Grid with numbers */}
                    <g stroke="#eee" strokeWidth="0.1">
                        {Array.from({length: 81}).map((_, i) => {
                            const pos = i - 40;
                            return (
                                <g key={i}>
                                    <line x1={pos} y1="-40" x2={pos} y2="40" />
                                    <line x1="-40" y1={pos} x2="40" y2={pos} />
                                    {pos % 5 === 0 && pos !== 0 && (
                                        <>
                                            <text
                                                x={pos}
                                                y="1.5"
                                                textAnchor="middle"
                                                fontSize="1"
                                                fill="#555"
                                            >
                                                {pos}
                                            </text>
                                            <text
                                                x="1.5"
                                                y={-pos}
                                                textAnchor="start"
                                                fontSize="1"
                                                fill="#555"
                                            >
                                                {pos}
                                            </text>
                                        </>
                                    )}
                                </g>
                            );
                        })}
                    </g>

                    {/* Axes */}
                    <g stroke="#666" strokeWidth="0.2">
                        <line x1="-40" y1="0" x2="40" y2="0" markerEnd="url(#arrow)" />
                        <line x1="0" y1="40" x2="0" y2="-40" markerEnd="url(#arrow)" />
                        <text
                            x="0.8"
                            y="1.3"
                            fontSize="1"
                            fill="#666"
                        >
                            0
                        </text>
                    </g>

                    {/* Unit circle and transformation */}
                    <path
                        d={`M ${points[0].join(' ')} ${points.slice(1).map(p => 'L ' + p.join(' '))}`}
                        stroke="#aaa"
                        strokeWidth="0.1"
                        fill="none"
                    />
                    <path
                        d={`M ${transformedPoints[0].join(' ')} ${transformedPoints.slice(1).map(p => 'L ' + p.join(' '))}`}
                        stroke="blue"
                        strokeWidth="0.1"
                        fill="none"
                    />

                    {/* Eigenvectors */}
                    {showVectors && eigenvectors.map((vec, i) => {
                        const color = i === 0 ? "red" : "green";
                        const scaledVec = [vec[0] * 15, vec[1] * 15];
                        return (
                            <g key={i} stroke={color} strokeWidth="0.2">
                                {/* Original vector */}
                                <line
                                    x1="0"
                                    y1="0"
                                    x2={scaledVec[0]}
                                    y2={-scaledVec[1]}
                                    markerEnd="url(#arrow)"
                                />
                                {/* Transformed vector */}
                                <line
                                    x1="0"
                                    y1="0"
                                    x2={scaledVec[0] * currentEigenvalues[i]}
                                    y2={-scaledVec[1] * currentEigenvalues[i]}
                                    strokeDasharray="0.5"
                                    markerEnd="url(#arrow)"
                                />
                            </g>
                        );
                    })}

                    {/* Arrow marker */}
                    <defs>
                        <marker
                            id="arrow"
                            viewBox="0 0 10 10"
                            refX="5"
                            refY="5"
                            markerWidth="6"
                            markerHeight="6"
                            orient="auto-start-reverse"
                        >
                            <path d="M 0 0 L 10 5 L 0 10 z" fill="currentColor"/>
                        </marker>
                    </defs>
                </svg>
            </div>
        );
    }

    function Controls({ t, setT, showVectors, setShowVectors }) {
        const matrix = [
            [1 + (targetMatrix[0][0] - 1) * t, targetMatrix[0][1] * t],
            [targetMatrix[1][0] * t, 1 + (targetMatrix[1][1] - 1) * t]
        ];
        const currentEigenvalues = eigenvalues.map(λ => 1 + (λ - 1) * t);

        return (
            <div>
                <h2>Controls</h2>
                <div className="control-panel">
                                <span>
                                    Transformation Progress: {t.toFixed(2)}
                                    <input
                                        type="range"
                                        min="0"
                                        max="1"
                                        step="0.01"
                                        value={t}
                                        onChange={e => setT(parseFloat(e.target.value))}
                                    />
                                </span>
                    <br/>
                    <label>
                        <input
                            type="checkbox"
                            checked={showVectors}
                            onChange={e => setShowVectors(e.target.checked)}
                        /> Show Eigenvectors
                    </label>
                </div>

                <div className="math-section">
                    <h2>Current Matrix</h2>
                    <MatrixDisplay matrix={matrix} />

                    <h2>Target Matrix</h2>
                    <MatrixDisplay matrix={targetMatrix} />

                    <h2>Eigenvalues</h2>
                    <div className="vector">λ₁ = {currentEigenvalues[0].toFixed(2)}</div>
                    <div className="vector">λ₂ = {currentEigenvalues[1].toFixed(2)}</div>

                    <h2>Eigenvectors</h2>
                    <div className="vector">v₁ = [{eigenvectors[0].join(', ')}]</div>
                    <div className="vector">v₂ = [{eigenvectors[1].join(', ')}]</div>
                </div>
            </div>
        );
    }

    // Main App Component (Chart)
    function App() {
        const [t, setT] = React.useState(1);
        const [showVectors, setShowVectors] = React.useState(true);

        React.useEffect(() => {
            const unsubscribeT = eventBus.subscribe('updateT', setT);
            const unsubscribeVectors = eventBus.subscribe('updateVectors', setShowVectors);
            return () => {
                unsubscribeT();
                unsubscribeVectors();
            };
        }, []);

        return (
            <div className="chart-container">
                <Visualization t={t} showVectors={showVectors} />
            </div>
        );
    }

    // Controls Component
    function ControlsComponent() {
        const [t, setT] = React.useState(1);
        const [showVectors, setShowVectors] = React.useState(true);

        const handleTChange = (newT) => {
            setT(newT);
            eventBus.emit('updateT', newT);
        };

        const handleVectorsChange = (show) => {
            setShowVectors(show);
            eventBus.emit('updateVectors', show);
        };

        return (
            <Controls
                t={t}
                setT={handleTChange}
                showVectors={showVectors}
                setShowVectors={handleVectorsChange}
            />
        );
    }

    // Mount components separately
    ReactDOM.createRoot(document.getElementById('app')).render(<App />);
    ReactDOM.createRoot(document.getElementById('controls')).render(<ControlsComponent />);
</script>

<style>
    .chart-container {
        /*max-width: 1200px;*/
        margin: 0 auto;
        background-color: white;
        padding: 0px;
    }
    .controls-container {
        background-color: white;
        padding: 0px;
        border-radius: 8px;
        width: 100%;
        box-sizing: border-box;
    }
    .matrix {
        font-family: monospace;
        white-space: pre;
        margin: 10px 0;
        font-size: 0.85em;
    }
    input[type="range"] {
        width: 100%;
        margin: 10px 0;
        height: 20px;
        -webkit-appearance: none;
        background: transparent;
    }
    input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none;
        height: 14px;
        width: 14px;
        border-radius: 50%;
        background: #007bff;
        cursor: pointer;
        margin-top: -5px;
    }
    input[type="range"]::-webkit-slider-runnable-track {
        width: 100%;
        height: 6px;
        background: #ddd;
        border-radius: 3px;
        cursor: pointer;
    }
    .math-section {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 4px;
        margin-bottom: 15px;
    }
    h2 {
        color: #333;
        margin: 20px 0 10px 0;
        font-size: 1em;
    }
    .vector {
        color: #666;
        margin: 5px 0;
        font-family: monospace;
        font-size: 0.9em;
    }
    [data-theme="dark"] .controls-container {
        background-color: #434343;
        color: #a9a9a9;
        padding: 0px 5px;
    }
    [data-theme="dark"] .controls-container * {
        color: #a9a9a9;
    }
    [data-theme="dark"] .math-section {
        background-color: #434343;
        color: #a9a9a9;
    }
    [data-theme="dark"] .math-section * {
        color: #a9a9a9;
    }
</style>
