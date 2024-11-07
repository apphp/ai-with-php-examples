<?php

$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('rubix-simple-linear-regression-code.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Linear Regression with PHP</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Simple Linear Regression with Rubix</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="<?=create_href('ml-algorithms', 'linear-regression', 'rubix-simple-linear-regression')?>" class="btn btn-sm btn-outline-primary">Show Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        Used when there is only one independent variable.
        For this example, let’s use a small dataset with square footage and price.
    </p>
</div>

<div>
    <p class="btn btn-link px-0 py-0 pe-2" data-bs-toggle="collapse" href="#collapseDataset" role="button" aria-expanded="false" aria-controls="collapseDataset">
        Dataset
    </p>
    <p class="btn btn-link px-0 py-0" data-bs-toggle="collapse" href="#collapseExampleOfUse" role="button" aria-expanded="false" aria-controls="collapseExampleOfUse">
        Example of use
    </p>
    <div class="collapse pb-4" id="collapseDataset">
        <div class="card card-body pb-0">
            <code id="code">
                adsadsa
                dasd
                asdadx
            </code>
        </div>
    </div>
    <div class="collapse pb-4" id="collapseExampleOfUse">
        <div class="card card-body pb-0">
            <div class="bd-clipboard">
                <button id="copyButton" type="button" class="btn-clipboard" onclick="copyToClipboard()">
                    Copy
                </button>
                &nbsp;
            </div>
            <code id="code">
                <?= highlight_file(dirname(__FILE__) . '/rubix-simple-linear-regression-code.php', true); ?>
            </code>
        </div>
    </div>
</div>

<div class="container px-2">
    <div class="row justify-content-start p-0">
        <div class="col-7 px-1 pe-4">
            <p>Chart:</p>
            <canvas id="myChart"></canvas>

            <script>
                const ctx = document.getElementById('myChart');

                // Data points
                const data = [
                    { x: 800, y: 160000 },
                    { x: 900, y: 180000 },
                    { x: 1000, y: 200000 },
                    { x: 1100, y: 220000 },
                    { x: 1200, y: 240000 },
                    { x: 1300, y: 260000 },
                    { x: 1400, y: 280000 },
                    { x: 1450, y: 310500, highlight: true },  // This is our bold point
                    { x: 1500, y: 290000 },
                    { x: 1600, y: 320000 },
                    { x: 1700, y: 340000 }
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
                                label: 'House Prices',
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
                                label: 'Regression Line',
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
                                text: 'House Prices by Square Footage with Trend Line',
                                font: {
                                    size: 16,
                                    weight: 'bold'
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        if (context.datasetIndex === 0) {
                                            return `Square Feet: ${context.parsed.x}, Price: $${context.parsed.y.toLocaleString()}`;
                                        }
                                        return `Predicted Price: $${Math.round(context.parsed.y).toLocaleString()}`;
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
                                    __text: 'Square Footage',
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
                                        return value.toLocaleString() + ' sq.ft';
                                    }
                                }
                            },
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    __text: 'Price ($)',
                                    font: {
                                        size: 14
                                    }
                                },
                                ticks: {
                                    callback: function(value) {
                                        return '$' + value.toLocaleString();
                                    }
                                },
                                grid: {
                                    display: true,
                                    color: 'rgba(0, 0, 0, 0.1)'
                                }
                            }
                        }
                    }
                });
            </script>
        </div>
        <div class="col-5 p-0 m-0">
            <p>Result:
            <span class="float-end">Time running: <?= running_time($microtimeEnd, $microtimeStart); ?> sec.</span>
            </p>
            <code id="code" class="code-result">
                <pre><?= $result; ?></pre>
            </code>
        </div>

    </div>
</div>




