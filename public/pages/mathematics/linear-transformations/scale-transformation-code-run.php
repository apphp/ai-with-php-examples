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
            <a href="<?=create_href('mathematics', 'linear-transformations', 'scale-transformation-code')?>"  class="btn btn-sm btn-outline-primary">Show Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        ...
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/scale-transformation-code-usage.php'); ?>
</div>


<!-- OR for Plotly.js -->
<div id="transformationChart"></div>

<script>
    // Using Plotly.js
    const data = [
        // Input Vector
        {
            x: [0, 1],
            y: [0, 2],
            mode: 'lines+markers',
            name: 'Input Vector',
            line: {
                color: 'rgb(75, 192, 192)',
                width: 2
            },
            marker: {
                size: 8
            }
        },
        // Transformed Vector
        {
            x: [0, 2],
            y: [0, 6],
            mode: 'lines+markers',
            name: 'Transformed Vector',
            line: {
                color: 'rgb(255, 99, 132)',
                width: 2
            },
            marker: {
                size: 8
            }
        }
    ];

    const layout = {
        title: 'Vector Transformation',
        showlegend: true,
        xaxis: {
            range: [-2, 4],
            zeroline: true,
            gridcolor: 'rgb(238, 238, 238)',
        },
        yaxis: {
            range: [-2, 8],
            zeroline: true,
            gridcolor: 'rgb(238, 238, 238)',
        },
        paper_bgcolor: 'white',
        plot_bgcolor: 'white',
        margin: { t: 40, b: 40, l: 40, r: 40 }
    };

    const config = {
        responsive: true,
        displayModeBar: false
    };

    Plotly.newPlot('transformationChart', data, layout, config);
</script>

<div class="mb-1">
    <b>Result:</b>
    <span class="float-end">Memory: <?= memory_usage($memoryEnd, $memoryStart); ?> Mb</span>
    <span class="float-end me-2">Time running: <?= running_time($microtimeEnd, $microtimeStart); ?> sec.</span>
</div>
<code class="code-result">
    <pre><?= $result; ?></pre>
</code>
