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
        In PHP it can be written as a class <code>LinearTransformation</code> with implementation of linear transformation operations.
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/scale-transformation-code-usage.php'); ?>
</div>


<div class="container-fluid px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-7 px-1 pe-5">
            <p><b>Chart:</b></p>

            <?php
                echo Chart::drawVectorField(
                    vector: $vector2D,
                    matrix: $transformMatrix
                );
            ?>

        </div>
        <div class="col-md-12 col-lg-5 p-0 m-0">
            <form action="<?= APP_SEO_LINKS ? create_href('mathematics', 'linear-transformations', 'scale-transformation-code-run') : 'index.php'; ?>" type="GET">
                <div class="float-end p-0 m-0">
                    <button type="submit" class="btn btn-sm btn-outline-primary">Reset</button>
                </div>
                <div class="clearfix"></div>
            </form>
            <hr>
            <?php
                echo Chart::drawVectorFieldControls(
                    vector: $vector2D,
                    matrix: $transformMatrix
                );
            ?>
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
                                <input type="number" id="m11" min="-1000" max="1000" oninput="javascript:if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="5" value="2" step="0.5" width="50px">
                                <input type="number" id="m12" min="-1000" max="1000" oninput="javascript:if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="5" value="0" step="0.5" width="50px">
                                <input type="number" id="m21" min="-1000" max="1000" oninput="javascript:if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="5" value="0" step="0.5" width="50px">
                                <input type="number" id="m22" min="-1000" max="1000" oninput="javascript:if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="5" value="3" step="0.5" width="50px">
                            </div>
                        </div>
                        <div class="col-6">
                            <b>Input Vector</b>
                            <div class="vector-inputs">
                                <div>
                                    <label class="vector-component" for="vectorX">X Component:</label>
                                    <input type="number" id="vectorX" min="-1000" max="1000" oninput="javascript:if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="5" value="1" step="0.5">
                                </div>
                                <div>
                                    <label class="vector-component" for="vectorY">Y Component:</label>
                                    <input type="number" id="vectorY" min="-1000" max="1000" oninput="javascript:if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="5" value="2" step="0.5">
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



