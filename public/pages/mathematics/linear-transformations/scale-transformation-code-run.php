<?php
include_once('linear-transformation-code.php');

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('scale-transformation-code-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Linear Transformations</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Scale Transformation</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?=create_href('mathematics', 'linear-transformations', 'scale-transformation')?>"  class="btn btn-sm btn-outline-primary">Show Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        In PHP it can be written as a class LinearTransformation with implementation of linear transformation operations.
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/scale-transformation-code-usage.php'); ?>
</div>


<div class="container-fluid px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-7 px-1 pe-5">
            <p><b>Chart:</b></p>
            <div class="chart-container" id="vectorPlot"></div>
        </div>
        <div class="col-md-12 col-lg-5 p-0 m-0">
            <form action="<?= APP_SEO_LINKS ? create_href('mathematics', 'linear-transformations', 'scale-transformation-code-run') : 'index.php'; ?>" type="GET">
                <div class="float-end p-0 m-0">
                    <button type="submit" class="btn btn-sm btn-outline-primary">Reset</button>
                </div>
                <div class="clearfix"></div>
            </form>
            <hr>
            <div class="form-section">
                <form id="transformForm" onsubmit="return false;">

                    <div class="row">
                        <div class="col-6">
                            <b>Transformation Matrix</b>
                            <div class="row">
                                <div class="col-6">
                                    <label class="vector-component" for="m11">X Component:</label>
                                </div>
                                <div class="col-6">
                                    <label class="vector-component" for="m12">Y Component:</label>
                                </div>
                            </div>
                            <div class="matrix-grid">
                                <input type="number" id="m11" min="-1000" max="1000" oninput="javascript:if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="4" value="2" step="0.5" width="50px">
                                <input type="number" id="m12" min="-1000" max="1000" oninput="javascript:if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="4" value="0" step="0.5" width="50px">
                                <input type="number" id="m21" min="-1000" max="1000" oninput="javascript:if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="4" value="0" step="0.5" width="50px">
                                <input type="number" id="m22" min="-1000" max="1000" oninput="javascript:if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="4" value="3" step="0.5" width="50px">
                            </div>
                        </div>
                        <div class="col-6">
                            <b>Input Vector</b>
                            <div class="vector-inputs">
                                <div>
                                    <label class="vector-component" for="vectorX">X Component:</label>
                                    <input type="number" id="vectorX" min="-1000" max="1000" oninput="javascript:if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="4" value="1" step="0.5">
                                </div>
                                <div>
                                    <label class="vector-component" for="vectorY">Y Component:</label>
                                    <input type="number" id="vectorY" min="-1000" max="1000" oninput="javascript:if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="4" value="2" step="0.5">
                                </div>
                            </div>
                        </div>
                    </div>

                    <b>Output Vector</b>
                    <div class="output-vector">
                        <div class="vector-inputs">
                            <div>
                                <label class="vector-component">X Component:</label>
                                <div id="outputX">2</div>
                            </div>
                            <div>
                                <label class="vector-component">Y Component:</label>
                                <div id="outputY">6</div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <hr>

            <div class="pb-1">
                <b>Result:</b>
                <span class="float-end">Memory: <?= memory_usage($memoryEnd, $memoryStart); ?> Mb</span>
                <span class="float-end me-2">Time running: <?= running_time($microtimeEnd, $microtimeStart); ?> sec.</span>
            </div>
            <code class="code-result">
                <pre><?= $result; ?></pre>
            </code>
        </div>
    </div>
</div>

<style>
    .form-section {
        padding: 0px;
        border-radius: 8px;
    }
    .form-section b {
        margin-bottom: 5px;
        display: inline-block;
    }
    .form-section .vector-component {
        font-size: 12px;
    }
    .matrix-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-bottom: 20px;
    }
    .vector-inputs {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }
    input[type="number"] {
        width: 100%;
        padding: 4px 6px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    .output-vector {
        background: #f5f5f5;
        padding: 10px;
        border-radius: .2rem;
    }
    .output-vector .vector-inputs {
        margin: 0px;
    }
    .chart-container {
        min-height: 450px;
        padding: 0px;
    }
</style>

<script>
    class VectorGridChart {
        constructor(containerId) {
            this.containerId = containerId;
            this.initPlot();
            this.setupEventListeners();
        }

        initPlot() {
            this.updatePlot();
        }

        calculateTransformation() {
            const matrix = {
                m11: parseFloat(document.getElementById('m11').value) || 0,
                m12: parseFloat(document.getElementById('m12').value) || 0,
                m21: parseFloat(document.getElementById('m21').value) || 0,
                m22: parseFloat(document.getElementById('m22').value) || 0
            };

            const inputVector = {
                x: parseFloat(document.getElementById('vectorX').value) || 0,
                y: parseFloat(document.getElementById('vectorY').value) || 0
            };

            const outputVector = {
                x: matrix.m11 * inputVector.x + matrix.m12 * inputVector.y,
                y: matrix.m21 * inputVector.x + matrix.m22 * inputVector.y
            };

            document.getElementById('outputX').textContent = outputVector.x.toFixed(2);
            document.getElementById('outputY').textContent = outputVector.y.toFixed(2);

            return { inputVector, outputVector };
        }

        updatePlot() {
            const { inputVector, outputVector } = this.calculateTransformation();

            const maxVal = Math.max(
                Math.abs(inputVector.x),
                Math.abs(inputVector.y),
                Math.abs(outputVector.x),
                Math.abs(outputVector.y),
                1
            );

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
                    mode: 'lines+markers',
                    name: 'Input Vector',
                    line: { color: 'rgb(75, 192, 192)', width: 2 },
                    marker: { size: 8 }
                },
                // Output Vector
                {
                    x: [0, outputVector.x],
                    y: [0, outputVector.y],
                    mode: 'lines+markers',
                    name: 'Output Vector',
                    line: { color: 'rgb(255, 99, 132)', width: 2 },
                    marker: { size: 8 }
                }
            ];

            const layout = {
                title: '',
                showlegend: true,
                legend: {
                    orientation: 'h',
                    y: -0.2,
                    x: 0.5,
                    xanchor: 'center',
                    yanchor: 'top'
                },
                xaxis: {
                    range: [-(maxVal + yAxisPadding), maxVal + yAxisPadding],
                    zeroline: true,
                    dtick: dticks,
                    gridcolor: 'rgb(238, 238, 238)',
                },
                yaxis: {
                    range: [-(maxVal + yAxisPadding), maxVal + yAxisPadding], // Extended y-axis range
                    zeroline: true,
                    gridcolor: 'rgb(238, 238, 238)',
                },
                paper_bgcolor: 'white',
                plot_bgcolor: 'white',
                margin: {
                    t: 30,  // top margin
                    b: 50,  // bottom margin
                    l: 50,  // left margin
                    r: 50   // right margin
                }
            };

            Plotly.newPlot(this.containerId, data, layout, {
                responsive: true,
                displayModeBar: false
            });
        }

        setupEventListeners() {
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('input', () => this.updatePlot());
            });
        }
    }

    // Initialize the chart when the page loads
    document.addEventListener('DOMContentLoaded', () => {
        const chart = new VectorGridChart('vectorPlot');
    });
</script>

