<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Knowledge & Uncertainty in AI</h1>
</div>

<?= create_run_code_button('Knowledge-Based Agents', 'knowledge-and-uncertainty', 'knowledge-based-agents', 'knowledge-based-agents-code-run'); ?>

<div>
    <p>
        A knowledge-based system (KBS) uses artificial intelligence techniques to store, manipulate, and reason with knowledge. The knowledge is
        typically represented in the form of rules or facts, enabling the system to draw conclusions or make decisions.
    </p>
</div>

<div>
    <?= create_example_of_use_links(APP_PUBLIC_PATH . 'include/classes/knowledgebase/KnowledgeBase.php', title: 'Example of class <code>KnowledgeBase</code>', opened: true); ?>
    <br>
    <?= create_example_of_use_links(APP_PUBLIC_PATH . 'include/classes/knowledgebase/KBAgent.php', title: 'Example of class <code>KBAgent</code>', opened: true); ?>
</div>
