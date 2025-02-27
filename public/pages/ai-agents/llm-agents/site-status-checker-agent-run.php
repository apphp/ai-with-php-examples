<?php

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////
include('site-status-checker-agent-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">LLM AI Agents</h1>
</div>

<?= create_show_code_button('Site Status Checker Agent', 'ai-agents', 'llm-agents', 'site-status-checker-agent'); ?>

<div>
    <p>
        This agent gives you a status of following:
    </p>
    <ul>
        <li>Check if a site is up and running</li>
        <li>Dig up DNS info</li>
        <li>Run ping tests</li>
        <li>Give you the explanation on why a site might be offline</li>
    </ul>
    <br>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/site-status-checker-agent-usage.php'); ?>
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


