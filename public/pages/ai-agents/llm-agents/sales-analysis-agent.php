<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">LLM Agents</h1>
</div>

<?= create_run_code_button('Sales Analyst Agent', 'ai-agents', 'llm-agents', 'sales-analysis-agent-run'); ?>

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
    <?= create_example_of_use_links(APP_PATH . 'public/include/classes/llmagents/salesanalysis/SiteStatusCheckerAgent.php', title: 'Example of class <code>SalesAnalysisAgent</code>', opened: true); ?>
</div>


