<?php

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
//ob_start();
//////////////////////////////
include('sales-analysis-agent-usage.cache.php');

//////////////////////////////
//$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">LLM AI Agents</h1>
</div>

<?= create_show_code_button('Sales Analyst Agent', 'ai-agents', 'llm-agents', 'sales-analysis-agent'); ?>

<div>
    <p>
        This agent gives you a status of following:
    </p>
    <ul>
        <li>Generate sales report</li>
        <li>Get sales analysis</li>
        <li>Get recommendations</li>
    </ul>
    <br>
</div>

<div>
    <?= create_dataset_and_test_data_links(__DIR__ . '/data/IC-Weekly-Sales-Activity-Report-11538.csv', fullWidth: true); ?>
</div>

<div class="container-fluid px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-7 px-1 pe-5">
            <div class="mb-1">
                <b>Result:</b>
                <span class="float-end">Memory: <?= memory_usage($memoryEnd, $memoryStart); ?> Mb</span>
                <span class="float-end me-2">Time running: <?= running_time($microtimeEnd, $microtimeStart); ?> sec.</span>
            </div>
            <code class="code-result">
                <pre class="pre-wrap"><?= $result; ?></pre>
            </code>
        </div>
        <div class="col-md-12 col-lg-5 p-0 m-0">
            <div class="mb-1">
                <b>Debug:</b>
                <code class="code-result">
                    <pre class="pre-wrap"><?= $debugResult; ?></pre>
                </code>
            </div>
        </div>
    </div>
</div>


