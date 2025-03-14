<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Logical Representation in AI</h1>
</div>

<?= create_run_code_button('Propositional Logic Representation with PHP', 'knowledge-and-uncertainty', 'logical-representation', 'propositional-logic-code-run'); ?>

<div>
    <p>
        Logical representation is a powerful technique in AI that uses formal logic to represent knowledge and reason about it systematically. By
        employing well-defined rules and symbols, logical representation enables machines to infer new information, verify facts, and solve complex
        problems.
    </p>
</div>

<div>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="Proposition-tab" data-bs-toggle="tab" data-bs-target="#Proposition" type="button" role="tab" aria-controls="Proposition" aria-selected="true">Proposition</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="PropositionalLogic-tab" data-bs-toggle="tab" data-bs-target="#PropositionalLogic" type="button" role="tab" aria-controls="PropositionalLogic" aria-selected="false">PropositionalLogic</button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active pt-3" id="Proposition" role="tabpanel" aria-labelledby="Proposition-tab">
            <?= create_example_of_use_links(APP_PATH . 'classes/logic/Proposition.php', title: 'Example of class <code>Proposition</code>', opened: true); ?>
        </div>
        <div class="tab-pane fade pt-3" id="PropositionalLogic" role="tabpanel" aria-labelledby="PropositionalLogic-tab">
            <?= create_example_of_use_links(APP_PATH . 'classes/logic/PropositionalLogic.php', title: 'Example of class <code>PropositionalLogic</code>', opened: true); ?>
        </div>
    </div>
</div>
