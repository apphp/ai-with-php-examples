<?php

use League\CommonMark\CommonMarkConverter;

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);

$resultFormatOptions = ['Markdown' => 'md', 'HTML' => 'html'];
$resultFormat = isset($_GET['resultFormat']) && is_string($_GET['resultFormat']) ? $_GET['resultFormat'] : '';
verify_fields($resultFormat, array_values($resultFormatOptions), reset($resultFormatOptions));

$agentDebugOptions = ['Show Debug' => '1'];
$agentDebug = isset($_GET['agentDebug']) && is_string($_GET['agentDebug']) ? $_GET['agentDebug'] : '';
verify_fields($agentDebug, array_values($agentDebugOptions), '');

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
        This agent can provide you following:
    </p>
    <ul>
        <li>Generate sales report</li>
        <li>Get sales analysis</li>
        <li>Get recommendations</li>
    </ul>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/sales-analysis-agent-usage.php'); ?>
</div>

<div class="container-fluid px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-7 px-1 pe-5">
            <?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, showResult: false); ?>
            <code class="<?= $resultFormat === 'md' ? 'code-result' : 'html-result'?>">
                <?php if($resultFormat === 'md'): ?>
                    <pre class="pre-wrap"><?= $result; ?></pre>
                <?php else: ?>
                    <div class="<?= $resultFormat === 'md' ? '' : 'bg-lightgray p-2'?>">
                    <?php
                        $converter = new CommonMarkConverter([
                            'html_input' => 'strip',
                            'allow_unsafe_links' => false,
                        ]);
                        echo $converter->convert($result);
                    ?>
                    </div>
                <?php endif; ?>
            </code>
        </div>
        <div class="col-md-12 col-lg-5 p-0 m-0">
            <div>
                <div>
                    <b>Result Format:</b>
                </div>
                <form class="mt-2" action="<?= APP_SEO_LINKS ? create_href('ai-agents', 'llm-agents', 'sales-analysis-agent-run') : 'index.php'; ?>" type="GET">
                    <?= !APP_SEO_LINKS ? create_form_fields('ai-agents', 'llm-agents', 'sales-analysis-agent-run') : ''; ?>
                    <?= create_form_features($resultFormatOptions, [$resultFormat], fieldName: 'resultFormat', type: 'select', class: 'w-30 me-4'); ?>
                    <?= create_form_features($agentDebugOptions, [$agentDebug], fieldName: 'agentDebug', type: 'single-checkbox', class: ''); ?>
                    <div class="form-check form-check-inline float-end p-0 m-0 me-1">
                        <button type="submit" class="btn btn-sm btn-outline-primary">Re-generate</button>
                    </div>
                    <div class=" clearfix "></div>
                </form>
            </div>

            <hr>

            <div class="mb-1">
                <b>Debug:</b>
            </div>
            <code class="code-result" id="expandable-div">
                <!-- Expand button -->
                <?php if($debugResult !== '--'): ?>
                    <div class="bd-fullscreen cursor-pointer">
                        <i id="expandable-div-icon" class="fas fa-expand fa-inverse" title="Open in Full Screen"></i>
                    </div>
                <?php endif; ?>
                <pre class="pre-wrap"><?= $debugResult; ?></pre>
            </code>
        </div>
    </div>
</div>


