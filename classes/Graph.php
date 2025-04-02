<?php

namespace app\classes;

class Graph {

    /**
     * Draw quadratic function graph
     * @param array $points
     * @return string
     */
    public static function drawQuadraticFunction(array $points){
        $output = '<canvas id="myChart"></canvas>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    const ctx = document.getElementById("myChart").getContext("2d");

                    // Generate x values from -10 to 10
                    const xValues = [];
                    const yValues = [];
                    for (let x = -10; x <= 10; x += 0.1) {
                        xValues.push(x);
                        yValues.push(x * x);
                    }

                     // Define datasets array starting with the function curve
                    const datasets = [];
                    ';

                    // Generate JavaScript code for each point in the array
                    $pointsOutput = '';
                    foreach ($points as $index => $point) {
                        // Default values if not provided
                        $x = $point['x'] ?? 0;
                        $y = isset($point['y']) ? $point['y'] : ($x * $x); // Calculate y = x² if not provided
                        $label = $point['label'] ?? "Point " . ($index + 1);
                        $color = $point['color'] ?? self::getDefaultColor($index);

                        $output .= '
                                datasets.push({
                                    label: "' . $label . '",
                                    data: [{ x: ' . $x . ', y: ' . $y. ' }],
                                    backgroundColor: "' . $color . '",
                                    borderColor: "' . $color . '",
                                    pointRadius: 6,
                                    pointStyle: "circle"
                                });
                        ';
                    }

                    $output .= '

                    datasets.push({
                        label: "y = x²",
                        data: xValues.map((x, i) => ({ x, y: yValues[i] })),
                        borderColor: "#cccccc",
                        showLine: true,
                        fill: false,
                        borderWidth: 2,
                        pointRadius: 0,
                        tension: 0
                    });

                    let gridColor = document.body.getAttribute("data-theme") === "dark" ? "#444" : "#ccc";

                    const chart =  new Chart(ctx, {
                        type: "scatter",
                        data: {
                            datasets: datasets
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: true,
                            scales: {
                                x: { type: "linear", position: "bottom" },
                                y: { type: "linear" }
                            },
                            scales: {
                                x: {
                                    type: "linear",
                                    position: "bottom",
                                    grid: {
                                        color: gridColor
                                    },
                                },
                                y: {
                                    type: "linear",
                                    grid: {
                                        color: gridColor
                                    },
                                }
                            }
                        }
                    });

                    // Change grid color according to theme color
                    document.getElementById("darkSwitch").addEventListener("change", function () {
                        const isDarkMode = document.body.getAttribute("data-theme") === "dark";
                        gridColor = isDarkMode ? "#ccc" : "#444";
                        chart.options.scales.x.grid.color = gridColor;
                        chart.options.scales.y.grid.color = gridColor;
                        chart.update();
                    });
                });
            </script>';

        return $output;
    }

    /**
     * Get a default color based on index
     * @param int $index
     * @return string
     */
    private static function getDefaultColor(int $index): string {
        $colors = ['green', 'red', 'blue', 'orange', 'purple', 'brown', 'pink', 'black', 'yellow', 'cyan'];
        return $colors[$index % count($colors)];
    }
}
