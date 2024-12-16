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
    ){
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
                    classDef gNode fill:#FFA07A,stroke:#333,stroke-width:1px
                    '.($intersectionNode ? 'classDef iNode fill:#A07AFF,stroke:#333' : '').'
                    
                    classDef default fill:#d0e6b8,stroke:#2ea723,stroke-width:2px
                    classDef visited fill:#ff9999,stroke:#ff0000,stroke-width:2px
                    classDef current fill:#ffff99,stroke:#ffa500,stroke-width:2px 
                    classDef finish fill:#ff8800,stroke:#333,stroke-width:1.5px 
                    
                %% Color visited edges
                    ${generateEdgeStyles()}
            ';
        }

        $output = '
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
                        ${visitedNodes.length > 0 ? (visitedNodes[visitedNodes.length-1] == "'.$endNode.'") ? `class '.$endNode.' finish` : `class ${visitedNodes[visitedNodes.length-1]} current` : ""}
                    `;
                }
                
                function extractEdgesFromGraph(graphDefinition) {
                    // Split the graph definition into lines
                    const lines = graphDefinition.split("\n");
                    const edgeMap = {};
                    const weightMap = {};
                    let edgeIndex = 0;
                
                    // Process each line to find edge definitions
                    lines.forEach(line => {
                        // Remove leading/trailing whitespace
                        line = line.trim();
                        
                        // Skip the graph TB line and empty lines
                        if (line.startsWith("graph TB") || !line) return;
                        
                        // Look for lines that define edges (containing -->)
                        if (line.includes("-->")) {
                            // Remove any comments and trim
                            line = line.split(""%"")[0].trim();
                            
                            // Split the line into parts considering the edge weight
                            const parts = line.split("-->").map(part => part.trim());
                            
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
                                if (targetPart.includes(""|"")) {
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


        return $output;
    }

}
