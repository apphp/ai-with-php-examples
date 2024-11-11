<?php

class Chart {

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
    ): string {

        $predictionX = '';

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
                                borderWidth: function(context) {
                                    return context.raw.highlight ? 1 : 1;  // Thicker border for bold point
                                },
                                pointRadius: function(context) {
                                    return context.raw.highlight ? 4 : 3;  // Larger radius for bold point
                                },
                                pointHoverRadius: function(context) {
                                    return context.raw.highlight ? 4 : 3;
                                },
                                pointStyle: function(context) {
                                    return context.raw.highlight ? 'circle' : 'circle';  // Using circles for all points
                                }
                            },
                            {
                                label: '".htmlspecialchars($regressionLabel)."',
                                data: regressionLine,
                                type: 'line',
                                // borderColor: 'rgba(255, 0, 0, 0.2)',
                                // backgroundColor: 'rgba(255, 0, 0, 0.1)',
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
                                " . ($minY != 0 ? 'beginAtZero: false, min: '.$minY.',' : 'beginAtZero: true') . "
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
        string $xLabel = '',
        string $yLabel = '',
        string $zLabel = '',
        string $mainTraceLabel = '',
        string $customTraceLabel = '',
        array $predictionPoints = []
    ): string {

        $return = "
            <div id='my3DScatterChart''></div>

            <script>
                // Define data for the 3D scatter plot
                const scatterData = [{";

                    // Render x axis
                    $return .= 'x: [';
                    foreach ($samples as $sample) $return .= $sample[0] . ',';
                    $return .= '],' . "\n";

                    // Render y axis
                    $return .= 'y: [';
                    foreach ($samples as $sample) $return .= $sample[1] . ',';
                    $return .= '],' . "\n";

                    // Render z axis
                    $return .= 'z: [';
                    foreach ($labels as $label) $return .= $label . ',';
                    $return .= '],' . "\n";

                    $return .= "
                    mode: 'markers', // Show as points
                    marker: {
                        size: 8,
                        color: 'rgba(99,190,255)' // Red color with opacity
                    },
                    type: 'scatter3d', // 3D scatter plot type
                    name: '".htmlspecialchars($mainTraceLabel)."'
                }";


                // Add additional points in red
                if (!empty($predictionPoints)) {
                    $return .= ",{";
                    $return .= 'x: [';
                    foreach ($predictionPoints['x'] as $point) $return .= $point . ',';
                    $return .= '],' . "\n";
                    $return .= 'y: [';
                    foreach ($predictionPoints['y'] as $point) $return .= $point . ',';
                    $return .= '],' . "\n";
                    $return .= 'z: [';
                    foreach ($predictionPoints['z'] as $point) $return .= $point . ',';
                    $return .= '],' . "\n";
                    $return .= "mode: 'markers',\n";
                    // Red color with high opacity
                    $return .= "marker: {size: 9,color: 'rgba(255,0,0,0.8)'},\n";
                    $return .= "type: 'scatter3d',";
                    $return .= "name: '".htmlspecialchars($customTraceLabel)."'";
                    $return .= "}";
                }

                $return .= "];

                // Define layout for the 3D scatter plot
                const layout = {
                    __title: '3D Scatter Plot',
                    scene: {
                        xaxis: { title: '".htmlspecialchars($xLabel)."' },
                        yaxis: { title: '".htmlspecialchars($yLabel)."' },
                        zaxis: { title: '".htmlspecialchars($zLabel)."' },
                        camera: {
                            eye: {
                                x: 0.9,
                                y: 2.1,
                                z: 0.7
                            }
                        }
                    },
                    margin: {
                        l: 150, r: 0, b: 0, t: 0
                    },  // to set the xaxis range to 0 to 1
                };

                // Render the plot in the specified div
                Plotly.newPlot('my3DScatterChart', scatterData, layout);
            </script>";

        return $return;
    }

}
