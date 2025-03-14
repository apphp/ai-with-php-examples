<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">LLM AI Agents</h1>
</div>

<?= create_run_code_button('Site Status Checker Agent', 'ai-agents', 'llm-agents', 'site-status-checker-agent-run'); ?>

<div>
    <p>
        This agent gives you a status of following:
    </p>
    <ul>
        <li>Check if a site is up and running</li>
        <li>Dig up DNS info</li>
        <li>Run ping tests</li>
        <li>Give you the lowdown on why a site might be offline</li>
    </ul>
</div>

<div>
    <?= create_example_of_use_links(APP_PATH . 'include/classes/llmagents/sitestatuschecker/SiteStatusCheckerAgent.php', title: 'Example of class <code>SiteStatusCheckerAgent</code>', opened: true); ?>
</div>


