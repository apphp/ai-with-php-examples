<?php

class Chart {

    public static function drawLinearSeparation(
        array $samples,
        array $labels,
        int $separationBorder = 75,
        string $classOneValue = '',
        string $classTwoValue = '',
        string $classOneLabel = '',
        string $classTwoLabel = '',
        string $predictionLabel = '',
        array $predictionSamples = [],
    ): string {
        $totalSamples = count($samples);

        $return = "
            <canvas id='myLinearSeparationChart'></canvas>

            <script>
                const ctx = document.getElementById('myLinearSeparationChart');" . PHP_EOL;

                // Passed data
                $return .= "const passData = [";
                    for ($i = 0; $i < $totalSamples; $i++) {
                        if ($labels[$i] === $classOneValue) {
                            $return .= '{ x: ' . $samples[$i][0] . ', y: ' . $samples[$i][1] . ' },';
                        }
                    }
                $return .= "];" . PHP_EOL;

                // Failed data
                $return .= "const failData = [";
                    for ($i = 0; $i < $totalSamples; $i++) {
                        if ($labels[$i] === $classTwoValue) {
                            $return .= '{ x: ' . $samples[$i][0] . ', y: ' . $samples[$i][1] . ' },';
                        }
                    }
                $return .= "];" . PHP_EOL;

                // Prediction data
                if ($predictionSamples) {
                    $return .= "const predictData = [";
                    foreach ($predictionSamples as $sample) {
                        $return .= '{ x: ' . $sample[0] . ', y: ' . $sample[1] . ' },';
                    }
                    $return .= "];" . PHP_EOL;
                }

                $return .= "
                // Generate separation line points
                const separationLineData = [];
                for (let x = 0; x <= ".$totalSamples."; x += 0.5) {
                    separationLineData.push({
                        x: x,
                        y: -5 * x + ".$separationBorder."
                    });
                }
    
                const chart = new Chart(ctx, {
                    type: 'scatter',
                    data: {
                        datasets: [{
                            label: '".$classOneLabel."',
                            data: passData,
                            backgroundColor: 'rgb(99, 190, 99)',
                            borderWidth: 1,
                            pointRadius: 5,
                            pointHoverRadius: 5,
                            pointStyle: 'circle'
                        },
                        {
                            label: '".$classTwoLabel."',
                            data: failData,
                            backgroundColor: 'rgb(99,190,255)',
                            borderWidth: function(context) {return context.raw.highlight ? 1 : 1;},
                            pointRadius: 5,
                            pointHoverRadius: 5,
                            pointStyle: 'circle'
                        },";

                        if ($predictionSamples) {
                            $return .= "{
                                label: '".$predictionLabel."',
                                data: predictData,
                                backgroundColor: 'rgb(255, 99, 132)',
                                borderWidth: function(context) {return context.raw.highlight ? 1 : 1;},
                                pointRadius: 5,
                                pointHoverRadius: 5,
                                pointStyle: 'circle'
                            },";
                        }

                        $return .= "{
                            label: 'Decision Boundary',
                            data: separationLineData,
                            type: 'line',
                            borderColor: 'rgb(128, 128, 128)',
                            borderDash: [5, 5],
                            borderWidth: 2,
                            pointRadius: 0,
                            fill: false
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                left: 10,
                                right: 10,
                                top: -100,    // Reduced top padding
                                bottom: 10
                            }
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Study Hours',
                                    font: {
                                        size: 14,
                                        weight: 'bold'
                                    }
                                },
                                min: 0,
                                max: 9
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Previous Score',
                                    font: {
                                        size: 14,
                                        weight: 'bold'
                                    }
                                },
                                min: 40,
                                max: 95
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    font: {
                                        size: 14
                                    }
                                }
                            },
                            title: {
                                display: true,
                                __text: '',
                                font: {
                                    size: 16,
                                    weight: 'bold'
                                },
                                padding: {
                                    top: 10,
                                    bottom: 30
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        if (context.dataset.label === 'Decision Boundary') {
                                            return '';
                                        }
                                        return context.dataset.label + ': ' + context.parsed.x + ' hours, ' + context.parsed.y + '%';
                                    }
                                }
                            }
                        }
                    }
                });
            </script>
        ";

        return $return;
    }

    public static function drawLinearRegression(
        array $samples,
        array $labels,
        string $xLabel = '',
        string $yLabel = '',
        string $datasetLabel = '',
        string $regressionLabel = '',
        array $predictionPoint = [],
        int $minX = 0,
        int $minY = 0,
        string $darkSwitch = ''
    ): string {

        $predictionX = '';
        $darkSwitch = $darkSwitch ?: ($_COOKIE['darkSwitch'] ?? '');

        // Add prediction point
        if (!empty($predictionPoint) && count($predictionPoint) == 2) {
            $predictionX = $predictionPoint[0];
            $samples[] = [$predictionX];
            $labels[] = $predictionPoint[1];
        }

        $return = "
            <canvas id='myLinearChart'></canvas>

            <script>
                const ctx = document.getElementById('myLinearChart');

                // Data points
                const data = [";

                    // Print data combining samples and labels
                    for ($i = 0; $i < count($samples); $i++) {
                        $highlight = ($samples[$i][0] == $predictionX) ? ', highlight: true' : '';
                        $return .= sprintf('{ x: %.0f, y: %.0f ' .$highlight."},\n",
                            $samples[$i][0],  // Square footage from samples
                            $labels[$i]       // Price from labels
                        );
                    }

                    $return .= "
                ];

                // Calculate linear regression
                function calculateRegression(data) {
                    const n = data.length;
                    let sumX = 0;
                    let sumY = 0;
                    let sumXY = 0;
                    let sumXX = 0;

                    data.forEach(point => {
                        sumX += point.x;
                        sumY += point.y;
                        sumXY += point.x * point.y;
                        sumXX += point.x * point.x;
                    });

                    const slope = (n * sumXY - sumX * sumY) / (n * sumXX - sumX * sumX);
                    const intercept = (sumY - slope * sumX) / n;

                    return { slope, intercept };
                }

                // Generate regression line points
                function generateRegressionLine(data, regression) {
                    const minX = Math.min(...data.map(point => point.x));
                    const maxX = Math.max(...data.map(point => point.x));

                    return [
                        { x: minX, y: regression.slope * minX + regression.intercept },
                        { x: maxX, y: regression.slope * maxX + regression.intercept }
                    ];
                }

                const regression = calculateRegression(data);
                const regressionLine = generateRegressionLine(data, regression);

                new Chart(ctx, {
                    type: 'scatter',
                    data: {
                        datasets: [
                            {
                                label: '".htmlspecialchars($datasetLabel)."',
                                data: data,
                                backgroundColor: function(context) {
                                    const point = context.raw;
                                    return point.highlight ?
                                        'rgba(255, 99, 132, 1)' :  // Bold point color
                                        'rgb(99,190,255)'; // Other points color
                                },
                                borderColor: function(context) {
                                    const point = context.raw;
                                    return point.highlight ?
                                        'rgba(255, 99, 132, 1)' :  // Bold point border
                                        'rgb(75,143,192)';   // Other points border
                                },
                                borderWidth: function(context) {return context.raw.highlight ? 1 : 1;},
                                pointRadius: function(context) {return context.raw.highlight ? 5 : 4;},
                                pointHoverRadius: function(context) {return context.raw.highlight ? 5 : 4;},
                                pointStyle: function(context) {return context.raw.highlight ? 'circle' : 'circle';}
                            },
                            {
                                label: '".htmlspecialchars($regressionLabel)."',
                                data: regressionLine,
                                type: 'line',
                                borderColor: '".($darkSwitch === 'dark' ? 'rgba(225, 225, 225, 0.4)' : 'rgba(225, 225, 225, 1)')."',
                                backgroundColor: '".($darkSwitch === 'dark' ? 'rgba(245, 245, 245, 0.9)' : 'rgba(245, 245, 245, 1)')."',
                                borderWidth: 2,
                                pointRadius: 0,
                                fill: false,
                                tension: 0
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    font: {
                                        size: 14
                                    }
                                }
                            },
                            __title: {
                                display: true,
                                text: '',
                                font: {
                                    size: 16,
                                    weight: 'bold'
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        if (context.datasetIndex === 0) {
                                            return `Square Feet: \${context.parsed.x}, Price: \$\${context.parsed.y.toLocaleString()}`;
                                        }
                                        return `Predicted Price: \$\${Math.round(context.parsed.y).toLocaleString()}`;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                type: 'linear',
                                position: 'bottom',
                                title: {
                                    display: true,
                                    text: '".htmlspecialchars($xLabel)."',
                                    font: {
                                        size: 14
                                    }
                                },
                                grid: {
                                    display: true,
                                    color: 'rgba(0, 0, 0, 0.1)'
                                },
                                ticks: {
                                    __stepSize: 50,
                                    padding: 1,
                                    maxTicksLimit: 1000,
                                    callback: function(value) {
                                       // return value.toLocaleString() + ' sq.ft';
                                       return value.toLocaleString();
                                    }
                                },
                                offset: true,
                            },
                            y: {
                                " . ($minY != 0 ? 'beginAtZero: false, min: '.$minY.',' : 'beginAtZero: true,') . "
                                title: {
                                    display: true,
                                    text: '".htmlspecialchars($yLabel)."',
                                    font: {
                                        size: 14
                                    }
                                },
                                grid: {
                                    display: true,
                                    color: 'rgba(0, 0, 0, 0.1)'
                                },
                                ticks: {
                                    callback: function(value) {
                                        //return '$' + value.toLocaleString();
                                        return value.toLocaleString();
                                    }
                                },
                                offset: false,
                            }
                        }
                    }
                });
            </script>";

        return $return;
    }

    public static function drawMultiLinearRegression(
        array $samples,
        array $labels,
        array $features,
        array $titles,
        string $targetLabel = '',
        string $mainTraceLabel = '',
        string $customTraceLabel = '',
        array $predictionSamples = [],
        array $predictionResults = [],
    ): string {

        $return = "
            <div id='my3DScatterChart' style='transform: translateY(-20px);'></div>

            <script>
                // Define data for the 3D scatter plot
                const scatterData = [";

                $useThirdArgument = count($features) === 3;

                // ----------------------------------------
                // DATASET
                // ----------------------------------------
                // Use 3rd argument
                if ($useThirdArgument) {
                    $maxSize = max(array_column($samples, 2));
                    $ind = 0;
                    foreach ($samples as $sample) {
                        $return .= "{";
                        $return .= 'x: [';
                        $return .= $sample[0] . ',';
                        $return .= '],' . "\n";
                        $return .= 'y: [';
                        $return .= $sample[1] . ',';
                        $return .= '],' . "\n";
                        $return .= 'z: [';
                        $return .= $labels[$ind++] . ',';
                        $return .= '],' . "\n";
                        $return .= "mode: 'markers',\n";
                        // Red color with high opacity
                        $return .= "marker: {size: ". (int)(6 * $sample[2] / $maxSize ).",color: 'rgba(99,190,255)'},\n";
                        $return .= "type: 'scatter3d',";
                        $return .= "name: '".htmlspecialchars($mainTraceLabel).' '.$ind."'";
                        $return .= "},";
                    }
                } else {
                    $return .= "{";

                    // Render x axis
                    $return .= 'x: [';
                    foreach ($samples as $sample) $return .= $sample[$features[0]] . ',';
                    $return .= '],' . "\n";

                    // Render y axis
                    $return .= 'y: [';
                    foreach ($samples as $sample) $return .= (isset($features[1]) ? $sample[$features[1]] : '0') . ',';
                    $return .= '],' . "\n";

                    // Render z axis
                    $return .= 'z: [';
                    foreach ($labels as $label) $return .= $label . ',';
                    $return .= '],' . "\n";

                    $return .= "
                    mode: 'markers', // Show as points
                    marker: {
                        size: 6,
                        color: 'rgba(99,190,255)' // Red color with opacity
                    },
                    type: 'scatter3d', // 3D scatter plot type
                    name: '".htmlspecialchars($mainTraceLabel)."'";

                    $return .= "},";
                }

                // ----------------------------------------
                // ADD ADDITIONAL POINTS IN RED
                // ----------------------------------------
                if (!empty($predictionSamples)) {
                    $return .= "{";
                    $return .= 'x: [';
                    foreach ($predictionSamples as $point) $return .= $point[$features[0]] . ',';
                    $return .= '],' . "\n";
                    $return .= 'y: [';
                    foreach ($predictionSamples as $point) $return .= (isset($features[1]) ? $point[$features[1]] : '0') . ',';
                    $return .= '],' . "\n";
                    $return .= 'z: [';
                    foreach ($predictionResults as $point) $return .= $point . ',';
                    $return .= '],' . "\n";
                    $return .= "mode: 'markers',\n";
                    // Red color with high opacity
                    if ($useThirdArgument) {
                        $return .= "marker: {size: ". (int)(6 * $sample[2] / $maxSize) . ", color: 'rgba(0,0,0,0.8)'},\n";
                    } else {
                        $return .= "marker: {size: 7, color: 'rgba(255,0,0,0.8)'},\n";
                    }
                    $return .= "type: 'scatter3d',";
                    $return .= "name: '".htmlspecialchars($customTraceLabel)."'";
                    $return .= "},";
                }

                $return .= "];

                // Define layout for the 3D scatter plot
                const layout = {
                    __title: '3D Scatter Plot',
                    scene: {
                        xaxis: { title: '".htmlspecialchars($titles[$features[0]])."' },
                        yaxis: { title: '".(isset($features[1]) ? htmlspecialchars($titles[$features[1]]) : '')."' },
                        zaxis: { title: '".htmlspecialchars($targetLabel)."' },
                        camera: {
                            eye: {
                                x: 0.9,
                                y: 2.1,
                                z: 0.7
                            }
                        }
                    },
                    margin: {
                        l: 100, r: 0, b: 0, t: 0
                    }, 
                };

                // Render the plot in the specified div
                Plotly.newPlot('my3DScatterChart', scatterData, layout);
            </script>";

        return $return;
    }

    public static function drawTreeDiagram(
        string $graph,
        string $steps,
        string $defaultMessage = '',
        string $style = '',
        string $startNode = 'S',
        string $endNode = 'K',
        string $intersectionNode = '',
    ): string {
        if(!$style){
            $style = '
                %% Apply styles
                    class '.$startNode.' sNode
                    class '.$endNode.' gNode
                    '.($intersectionNode ? 'class '.$intersectionNode.' iNode' : '').'
                
                %% Styling
                    classDef default fill:#d0e6b8,stroke:#2ea723,stroke-width:2px;
                    linkStyle default stroke:#2ea723,stroke-width:2px;
                    classDef sNode fill:#a0eFeF,stroke:#333,stroke-width:1px          
                    '.($intersectionNode ? 'classDef gNode fill:#a0eFeF,stroke:#333,stroke-width:1px' : 'classDef gNode fill:#FFB07A,stroke:#333,stroke-width:1px').'
                    '.($intersectionNode ? 'classDef iNode fill:#FFB07A,stroke:#333,stroke-width:1px' : '').'
                    
                    classDef default fill:#d0e6b8,stroke:#2ea723,stroke-width:2px
                    classDef visited fill:#ff9999,stroke:#ff0000,stroke-width:2px
                    classDef current fill:#ffff99,stroke:#ffa500,stroke-width:2px 
                    classDef finish fill:#ff8800,stroke:#333,stroke-width:1.5px 
                    
                %% Color visited edges
                    ${generateEdgeStyles()}
            ';
        }

        return '
        <div class="row pt-0" style="margin-top: -27px">
                <div class="col pt-1">
                    <div id="step-info" class="step-info">
                       '.$defaultMessage.'
                    </div>
                </div>
                <div class="col p-0">
                    <div class="controls">
                        <button id="prevBtn" class="btn-graph" onclick="prevStep()" disabled>Previous Step</button>
                        <button id="nextBtn" class="btn-graph" onclick="nextStep()">Next Step</button>
                        <button id="resetBtn" class="btn-graph" onclick="resetSearch()">Reset</button>
                    </div>
                </div>
            </div>
            <div class="container mb-5" style="overflow: hidden; min-height: 600px; width: 100%; position: relative;">
                <div id="diagram"></div>
            </div>
            
            <script>
                let treeSteps = '.$steps.';
                let currentStep = -1;
                let visitedNodes = [];
                let visitedEdges = [];

                function generateDiagram(steps) {
                    // Reset and rebuild visited nodes based on steps
                    visitedNodes = [];
                    visitedEdges = [];
                    
                    steps.forEach(step => {
                        if (step.reset) {
                            // Clear all visited nodes on reset
                            visitedNodes = [];
                            visitedEdges = [];
                        } else {
                            if (step.visit) visitedNodes.push(step.visit);
                            if (step.edge) visitedEdges.push(step.edge);
                        }
                    });
            
                    return `
                        '.$graph.'  
                        '.$style.'
                        ${visitedNodes.slice(0, -1).map(node => `class ${node} visited`).join("\n")}
                        ${visitedNodes.length > 0 
                            ? (visitedNodes[visitedNodes.length-1] == "'.($intersectionNode ?: $endNode).'") ? `class '.($intersectionNode ?: $endNode).' finish` 
                            : `class ${visitedNodes[visitedNodes.length-1]} current` : ""}
                    `;
                }
                
                function extractEdgesFromGraph(graphDefinition) {
                    // Split the graph definition into lines
                    const lines = graphDefinition.split("\n");
                    const edgeMap = {};
                    const weightMap = {};
                    let edgeIndex = 0;
                    let separatorType = "";
                
                    // Process each line to find edge definitions
                    lines.forEach(line => {
                        // Remove leading/trailing whitespace
                        line = line.trim();
                        
                        // Skip the graph TB line and empty lines
                        if (line.startsWith("graph TB") || !line) return;
                        
                        // Look for lines that define edges (containing -->)
                        separatorType = line.includes("-->") ? "-->" : (line.includes("---") ? "---" : "");

                        if (separatorType) {
                            // Remove any comments and trim
                            line = line.split("%")[0].trim();
                            
                            // Split the line into parts considering the edge weight
                            const parts = line.split(separatorType).map(part => part.trim());
                            
                            if (parts.length === 2) {
                                let sourceNode = parts[0];
                                let targetPart = parts[1];
                                
                                // Extract source node name
                                const sourceMatch = sourceNode.match(/\(\(([A-Z][0-9]?)\</);
                                if (!sourceMatch) {
                                    const simpleMatch = sourceNode.match(/\(\(([A-Z][0-9]?)\)\)/);
                                    sourceNode = simpleMatch ? simpleMatch[1] : sourceNode;
                                } else {
                                    sourceNode = sourceMatch[1];
                                }
                                
                                // Handle weight and target node
                                let weight = 1; // default weight
                                let targetNode = "";
                                
                                // Check if there is a weight
                                if (targetPart.includes("|")) {
                                    const weightMatch = targetPart.match(/\|(\d+)\|/);
                                    if (weightMatch) {
                                        weight = parseInt(weightMatch[1]);
                                    }
                                    // Extract the actual target part after the weight
                                    targetPart = targetPart.split("|").pop().trim();
                                }
                                
                                // Extract target node name
                                const targetMatch = targetPart.match(/\(\(([A-Z][0-9]?)\</);
                                if (!targetMatch) {
                                    const simpleMatch = targetPart.match(/\(\(([A-Z][0-9]?)\)\)/);
                                    targetNode = simpleMatch ? simpleMatch[1] : targetPart;
                                } else {
                                    targetNode = targetMatch[1];
                                }
                                
                                // Create directed edge mapping
                                const edge = `${sourceNode}-${targetNode}`;
                                
                                // Only add if not already in map
                                if (!(edge in edgeMap)) {
                                    edgeMap[edge] = edgeIndex;
                                    weightMap[edge] = weight;
                                    edgeIndex++;
                                }
                            }
                        }
                    });

                    return { edges: edgeMap, weights: weightMap };
                }
                
                function generateEdgeStyles() {
                    let edgeStyles = [];
                    let edgeIndex = 0;
                    
                    // Get the graph definition from the generateDiagram function
                    const graphDefinition = `
                        '.$graph.'
                    `;
                
                    // Dynamically create edge map
                    const edgeMap = extractEdgesFromGraph(graphDefinition);
                    
                    visitedEdges.forEach((edge, index) => {
                        const edgeNum = edgeMap.edges[edge];
                        if (edgeNum !== undefined) {
                            const color = "#ff0000";
                            edgeStyles.push(`linkStyle ${edgeNum} stroke:${color},stroke-width:3px`);
                        }
                    });
                
                    return edgeStyles.join("\n");
                }

                function updateDiagram() {
                    const container = document.getElementById("diagram");
                    const currentSteps = treeSteps.slice(0, currentStep + 1);
                    container.innerHTML = `<div class="mermaid">${generateDiagram(currentSteps)}</div>`;
                
                    document.getElementById("step-info").textContent = currentStep >= 0 ? treeSteps[currentStep].info : "'.$defaultMessage.'";
                    document.getElementById("prevBtn").disabled = currentStep <= 0;
                    document.getElementById("nextBtn").disabled = currentStep >= treeSteps.length - 1;
                
                    mermaid.init(undefined, document.querySelector(".mermaid"));
                }

                function nextStep() {
                    if (currentStep < treeSteps.length - 1) {
                        currentStep++;
                        updateDiagram();
                    }
                }

                function prevStep() {
                    if (currentStep > 0) {
                        currentStep--;
                        updateDiagram();
                    }
                }

                function resetSearch() {
                    currentStep = -1;
                    updateDiagram();
                }

                // Initialize
                mermaid.initialize({
                    startOnLoad: false,
                    theme: "default",
                    securityLevel: "loose",
                    flowchart: {
                        curve: "basis",
                        padding: 25
                    }
                });

                updateDiagram();
            </script>
        ';
    }

    public static function drawVectors(
        array $vector = [],
        array $matrix = [],
        array $bias = [],
        string $type = 'scale' /* scale|linear */
    ): string {
        $vectorX = $vector[0] ?? 0;
        $vectorY = $vector[1] ?? 0;

        $biasX = $bias[0] ?? 0;
        $biasY = $bias[1] ?? 0;

        $m11 = $matrix[0][0] ?? 0;
        $m12 = $matrix[0][1] ?? 0;
        $m21= $matrix[1][0] ?? 0;
        $m22 = $matrix[1][1] ?? 0;

        return '
            <div class="chart-container" id="vectorPlot"></div>
            
            <script>
                class VectorGridChart {
                    constructor(containerId, mode = "'.$type.'") {
                        this.containerId = containerId;
                        this.mode = mode;
                        this.initPlot();
                        this.setupEventListeners();
                    }
            
                    initPlot() {
                        this.updatePlot();
                    }
            
                    calculateTransformation() {
                        const matrix = {
                            m11: parseFloat(document.getElementById("m11")?.value ? document.getElementById("m11").value : '.$m11.') || 0,
                            m12: parseFloat(document.getElementById("m12")?.value ? document.getElementById("m12").value : '.$m12.') || 0,
                            m21: parseFloat(document.getElementById("m21")?.value ? document.getElementById("m21").value : '.$m21.') || 0,
                            m22: parseFloat(document.getElementById("m22")?.value ? document.getElementById("m22").value : '.$m22.') || 0,
                        };
            
                        const inputVector = {
                            x: parseFloat(document.getElementById("vectorX")?.value ? document.getElementById("vectorX").value : '.$vectorX.') || 0,
                            y: parseFloat(document.getElementById("vectorY")?.value ? document.getElementById("vectorY").value : '.$vectorY.') || 0
                        };
                        
                        const outputVector = {
                            x: matrix.m11 * inputVector.x + matrix.m12 * inputVector.y,
                            y: matrix.m21 * inputVector.x + matrix.m22 * inputVector.y
                        };

                        if (document.getElementById("outputX") && document.getElementById("outputY")) {
                            document.getElementById("outputX").textContent = outputVector.x.toFixed(1);
                            document.getElementById("outputY").textContent = outputVector.y.toFixed(1);
                        }

                        return { inputVector, outputVector };
                    }
                    
                    calculateLinearLayer() {
                        // Get matrix (weights) values
                        const matrix = {
                            m11: parseFloat(document.getElementById("m11")?.value ? document.getElementById("m11").value : '.$m11.') || 0,
                            m12: parseFloat(document.getElementById("m12")?.value ? document.getElementById("m12").value : '.$m12.') || 0,
                            m21: parseFloat(document.getElementById("m21")?.value ? document.getElementById("m21").value : '.$m21.') || 0,
                            m22: parseFloat(document.getElementById("m22")?.value ? document.getElementById("m22").value : '.$m22.') || 0,
                        };
                
                        // Get input vector values
                        const inputVector = {
                            x: parseFloat(document.getElementById("vectorX")?.value ? document.getElementById("vectorX").value : '.$vectorX.') || 0,
                            y: parseFloat(document.getElementById("vectorY")?.value ? document.getElementById("vectorY").value : '.$vectorY.') || 0
                        };
                
                        // Get bias values
                        const bias = {
                            x: parseFloat(document.getElementById("biasX")?.value ? document.getElementById("biasX").value : '.$biasX.') || 0,
                            y: parseFloat(document.getElementById("biasY")?.value ? document.getElementById("biasY").value : '.$biasY.') || 0
                        };
                                                
                        // Calculate Wx + b
                        const outputVector = {
                            x: matrix.m11 * inputVector.x + matrix.m12 * inputVector.y + bias.x,
                            y: matrix.m21 * inputVector.x + matrix.m22 * inputVector.y + bias.y
                        };
                
                        // Update output display if elements exist
                        if (document.getElementById("outputX") && document.getElementById("outputY")) {
                            document.getElementById("outputX").textContent = outputVector.x.toFixed(1);
                            document.getElementById("outputY").textContent = outputVector.y.toFixed(1);
                        }
                
                        return { inputVector, outputVector, matrix, bias };
                    }

                    updatePlot() {
                        let result;

                        if (this.mode === "linear") {
                            result = this.calculateLinearLayer();
                        } else {
                            result = this.calculateTransformation();
                        }
                        
                        const { inputVector, outputVector } = result;      
                        
                        // Calculate intermediate vector (Wx) for layer mode
                        let weightVector = null;
                        let biasVector = null;
                        if (this.mode === "linear") {
                            // Calculate the weight transformation vector (Wx)
                            weightVector = {
                                x: result.matrix.m11 * inputVector.x + result.matrix.m12 * inputVector.y,
                                y: result.matrix.m21 * inputVector.x + result.matrix.m22 * inputVector.y
                            };
                            
                            // Calculate bias vector
                            biasVector = {
                                x: result.bias ? result.bias.x : 0,
                                y: result.bias ? result.bias.y : 0
                            };
                        }
                        
                        const maxVal = Math.max(
                            Math.abs(inputVector.x),
                            Math.abs(inputVector.y),
                            Math.abs(outputVector.x),
                            Math.abs(outputVector.y),
                            this.mode === "linear" ? Math.abs(weightVector.x) : 0,
                            this.mode === "linear" ? Math.abs(weightVector.y) : 0,
                            this.mode === "linear" ? Math.abs(biasVector.x) : 0,
                            this.mode === "linear" ? Math.abs(biasVector.y) : 0,
                            1
                        );
                        if (document.getElementById("output-vector")) {
                            document.getElementById("output-vector").textContent = outputVector.x + ", " + outputVector.y;
                        }

                        // Add 1 unit padding to the maxVal for y-axis
                        const yAxisPadding = 1;

                        // Calculate tick interval to show 5 ticks
                        let dticks = 1;
                        if (maxVal > 10){
                            // Round maxVal up to the nearest multiple of 5
                            const roundedMax = Math.ceil(maxVal / 5) * 5;
                            // Calculate the step size and adjust to the nearest multiple of 5
                            dticks = Math.ceil(roundedMax / 10);
                            dticks = Math.ceil(dticks / 5) * 5;
                        }

                        const data = [
                            // Input Vector
                            {
                                x: [0, inputVector.x],
                                y: [0, inputVector.y],
                                mode: "lines+markers",
                                name: "Input Vector",
                                line: { color: "rgb(75, 192, 192)", width: 2 },
                                marker: { size: 8 }
                            }
                        ];
                        
                        // Add bias vector if in linear layer mode (green)
                        if (this.mode === "linear") {
                            data.push({
                                x: [weightVector.x, outputVector.x],
                                y: [weightVector.y, outputVector.y],
                                mode: "lines+markers",
                                name: "Bias Vector (b)",
                                line: { color: "rgb(75, 192, 75)", width: 2, dash: "dot" },
                                marker: { size: 8 }
                            });
                            
                            // Weight Transform Vector (purple)
                            data.push({
                                x: [0, weightVector.x],
                                y: [0, weightVector.y],
                                mode: "lines+markers",
                                name: "Weight Transform (Wx)",
                                line: { color: "rgb(153, 102, 255)", width: 2 },
                                marker: { size: 8 }
                            });
                        }
                        
                        // Final Output Vector (red)
                        data.push({
                            x: [0, outputVector.x],
                            y: [0, outputVector.y],
                            mode: "lines+markers",
                            name: this.mode === "linear" ? "Final Output (Wx + b)" : "Output (Wx)",
                            line: { color: "rgb(255, 99, 132)", width: 2 },
                            marker: { size: 8 }
                        });

                        const layout = {
                            title: "",
                            showlegend: true,
                            legend: {
                                orientation: "h",
                                y: -0.2,
                                x: 0.5,
                                xanchor: "center",
                                yanchor: "top"
                            },
                            xaxis: {
                                range: [-(maxVal + yAxisPadding), maxVal + yAxisPadding],
                                zeroline: true,
                                dtick: dticks,
                                gridcolor: "rgb(238, 238, 238)",
                            },
                            yaxis: {
                                range: [-(maxVal + yAxisPadding), maxVal + yAxisPadding], // Extended y-axis range
                                zeroline: true,
                                gridcolor: "rgb(238, 238, 238)",
                            },
                            paper_bgcolor: "white",
                            plot_bgcolor: "white",
                            margin: {
                                t: 10,  // top margin
                                b: 50,  // bottom margin
                                l: 20,  // left margin
                                r: 20   // right margin
                            }
                        };

                        Plotly.newPlot(this.containerId, data, layout, {
                            responsive: true,
                            displayModeBar: false
                        });
                    }

                    setupEventListeners() {
                        const inputs = document.querySelectorAll("input");
                        inputs.forEach(input => {
                            input.addEventListener("input", () => this.updatePlot());
                        });
                    }
                }

                // Initialize the chart when the page loads
                document.addEventListener("DOMContentLoaded", () => {
                    const chart = new VectorGridChart("vectorPlot");
                });
            </script>
        ';
    }

    public static function drawVectorControls(
        array $vector = [],
        array $matrix = [],
        array $bias = [],
        array $result = [],
        string $matrixTitle = '',
        string $iVectorTitle = '',
        string $oVectorTitle = '',
        string $bVectorTitle = '',
    ): string {

        $vectorX = $vector[0] ?? 0;
        $vectorY = $vector[1] ?? 0;

        $m11 = $matrix[0][0] ?? 0;
        $m12 = $matrix[0][1] ?? 0;
        $m21= $matrix[1][0] ?? 0;
        $m22 = $matrix[1][1] ?? 0;

        $biasX = $bias[0] ?? 0;
        $biasY = $bias[1] ?? 0;

        $resultX = $result[0] ?? 0;
        $resultY = $result[1] ?? 0;

        $output = '           
            <div id="vectorControls" class="form-section me-1">
                <form id="transformForm" onsubmit="return false;">
                    <div class="row">
                        <div class="col-6">
                            <b>'.$matrixTitle.'</b>
                            <div class="row">
                                <div class="col-6">
                                    <label class="vector-component" for="m11">X Component:</label>
                                </div>
                                <div class="col-6">
                                    <label class="vector-component" for="m12">Y Component:</label>
                                </div>
                            </div>
                            <div class="matrix-grid">
                                <input type="number" id="m11" min="-1000" max="1000" oninput="javascript:if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="5" value="'.$m11.'" step="0.5" width="50px">
                                <input type="number" id="m12" min="-1000" max="1000" oninput="javascript:if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="5" value="'.$m12.'" step="0.5" width="50px">
                                <input type="number" id="m21" min="-1000" max="1000" oninput="javascript:if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="5" value="'.$m21.'" step="0.5" width="50px">
                                <input type="number" id="m22" min="-1000" max="1000" oninput="javascript:if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="5" value="'.$m22.'" step="0.5" width="50px">
                            </div>
                        </div>
                        <div class="col-6">
                            <b>'.$iVectorTitle.'</b>
                            <div class="vector-inputs">
                                <div>
                                    <label class="vector-component" for="vectorX">X Component:</label>
                                    <input type="number" id="vectorX" min="-1000" max="1000" oninput="javascript:if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="5" value="'.$vectorX.'" step="0.5">
                                </div>
                                <div>
                                    <label class="vector-component" for="vectorY">Y Component:</label>
                                    <input type="number" id="vectorY" min="-1000" max="1000" oninput="javascript:if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="5" value="'.$vectorY.'" step="0.5">
                                </div>
                            </div>';

                            if($bVectorTitle) {
                                $output .= '
                                    <b>' . $bVectorTitle . '</b>
                                    <div class="vector-inputs">
                                        <div>
                                            <label class="vector-component" for="vectorX">X Component:</label>
                                            <input type="number" id="biasX" min="-1000" max="1000" oninput="javascript:if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="5" value="'.$biasX.'" step="0.5">
                                        </div>
                                        <div>
                                            <label class="vector-component" for="vectorY">Y Component:</label>
                                            <input type="number" id="biasY" min="-1000" max="1000" oninput="javascript:if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="5" value="'.$biasY.'" step="0.5">
                                        </div>
                                    </div>';
                            }

                            $output .= '
                        </div>
                    </div>

                    <b>'.$oVectorTitle.'</b>
                    <div class="output-vector">
                        <div class="vector-inputs">
                            <div>
                                <label class="vector-component">X Component:</label>
                                <div id="outputX">'.$resultX.'</div>
                            </div>
                            <div>
                                <label class="vector-component">Y Component:</label>
                                <div id="outputY">'.$resultY.'</div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            
            <style>
                #vectorControls {
                    padding: 0px;
                    border-radius: 8px;
                }
                #vectorControls b {
                    margin-bottom: 5px;
                    display: inline-block;
                }
                #vectorControls .vector-component {
                    font-size: 12px;
                }
                #vectorControls .matrix-grid {
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    gap: 10px;
                    margin-bottom: 20px;
                }
                #vectorControls .vector-inputs {
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    gap: 20px;
                    margin-bottom: 20px;
                }
                #vectorControls input[type="number"] {
                    width: 100%;
                    padding: 4px 6px;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                }
                #vectorControls .output-vector {
                    background: #f5f5f5;
                    padding: 8px 10px;
                    border-radius: .2rem;
                }
                #vectorControls .output-vector .vector-inputs {
                    margin: 0px;
                }
                #vectorControls .chart-container {
                    min-height: 450px;
                    padding: 0px;
                }
            </style>
        ';

        return $output;
    }
}
