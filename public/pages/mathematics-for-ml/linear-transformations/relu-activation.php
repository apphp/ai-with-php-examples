<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Linear Transformations</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">ReLU Activation</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?= create_href('mathematics-for-ml', 'linear-transformations', 'relu-activation-code-run') ?>" class="btn btn-sm btn-outline-primary">&#9654;
                Run
                Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        Linear transformations alone cannot solve complex, nonlinear problems.
        Activation functions like ReLU or Sigmoid introduce nonlinearity to the network. <br>
        The ReLU function is defined as: $ReLU(x) = max(0, x)$.
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/linear-transformation-code.php', title: 'Example of class <code>LinearTransformation</code>', opened: true); ?>
</div>

<!--<div id="myDiv" style="width: 800px"></div>-->
<!--<script>-->
<!--    const trace1 = {-->
<!--        x: [-10, 0, 0, 10],-->
<!--        y: [0, 0, 10, 10],-->
<!--        mode: 'lines',-->
<!--        name: 'ReLU(x)',-->
<!--        line: {-->
<!--            color: 'rgb(55, 128, 191)',-->
<!--            width: 3-->
<!--        }-->
<!--    };-->
<!---->
<!--    const examplePoints = {-->
<!--        x: [1, -3, 7, -2],-->
<!--        y: [1, 0, 7, 0],-->
<!--        mode: 'markers',-->
<!--        name: 'Example Points',-->
<!--        marker: {-->
<!--            color: 'rgb(219, 64, 82)',-->
<!--            size: 12-->
<!--        }-->
<!--    };-->
<!---->
<!--    const layout = {-->
<!--        title: 'ReLU Activation Function',-->
<!--        xaxis: {-->
<!--            title: 'Input (x)'-->
<!--        },-->
<!--        yaxis: {-->
<!--            title: 'Output ReLU(x)'-->
<!--        }-->
<!--    };-->
<!---->
<!--    Plotly.newPlot('myDiv', [trace1, examplePoints], layout);-->
<!--</script>-->
