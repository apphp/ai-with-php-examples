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
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="KnowledgeBase-tab" data-bs-toggle="tab" data-bs-target="#KnowledgeBase" type="button" role="tab" aria-controls="KnowledgeBase" aria-selected="true">KnowledgeBase</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="KBAgent-tab" data-bs-toggle="tab" data-bs-target="#KBAgent" type="button" role="tab" aria-controls="KBAgent" aria-selected="false">KBAgent</button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active pt-3" id="KnowledgeBase" role="tabpanel" aria-labelledby="KnowledgeBase-tab">
            <?= create_example_of_use_links(APP_PATH . 'classes/knowledgebase/KnowledgeBase.php', title: 'Example of class <code>KnowledgeBase</code>', opened: true); ?>
        </div>
        <div class="tab-pane fade pt-3" id="KBAgent" role="tabpanel" aria-labelledby="KBAgent-tab">
            <?= create_example_of_use_links(APP_PATH . 'classes/knowledgebase/KBAgent.php', title: 'Example of class <code>KBAgent</code>', opened: true); ?>
        </div>
    </div>
</div>
