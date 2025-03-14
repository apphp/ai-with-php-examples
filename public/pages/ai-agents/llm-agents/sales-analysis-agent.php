<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">LLM AI Agents</h1>
</div>

<?= create_run_code_button('Sales Analyst Agent', 'ai-agents', 'llm-agents', 'sales-analysis-agent-run'); ?>

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
    <?= create_dataset_and_test_data_links(__DIR__ . '/data/IC-Weekly-Sales-Activity-Report-11538.csv', fullWidth: true); ?>
</div>

<div>
    <?= create_example_of_use_links(APP_PATH . 'classes/llmagents/salesanalysis/SalesAnalysisAgent.php', title: 'Example of class <code>SalesAnalysisAgent</code>', opened: true); ?>
</div>


