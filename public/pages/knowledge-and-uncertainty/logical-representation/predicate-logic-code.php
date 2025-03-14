<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Logical Representation in AI</h1>
</div>

<?= create_run_code_button('Predicate Logic Representation with PHP', 'knowledge-and-uncertainty', 'logical-representation', 'predicate-logic-code-run'); ?>

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
            <button class="nav-link active" id="Term-tab" data-bs-toggle="tab" data-bs-target="#Term" type="button" role="tab" aria-controls="Term" aria-selected="true">Term</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="Domain-tab" data-bs-toggle="tab" data-bs-target="#Domain" type="button" role="tab" aria-controls="Domain" aria-selected="false">Domain</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="Predicate-tab" data-bs-toggle="tab" data-bs-target="#Predicate" type="button" role="tab" aria-controls="Predicate" aria-selected="false">Predicate</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="AtomicFormula-tab" data-bs-toggle="tab" data-bs-target="#AtomicFormula" type="button" role="tab" aria-controls="AtomicFormula" aria-selected="false">AtomicFormula</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="PredicateLogic-tab" data-bs-toggle="tab" data-bs-target="#PredicateLogic" type="button" role="tab" aria-controls="PredicateLogic" aria-selected="false">PredicateLogic</button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active pt-3" id="Term" role="tabpanel" aria-labelledby="Term-tab">
            <?= create_example_of_use_links(APP_PATH . 'classes/logic/Term.php', title: 'Example of class <code>Term</code>', opened: true); ?>
        </div>
        <div class="tab-pane fade pt-3" id="Domain" role="tabpanel" aria-labelledby="Domain-tab">
            <?= create_example_of_use_links(APP_PATH . 'classes/logic/Domain.php', title: 'Example of class <code>Domain</code>', opened: true); ?>
        </div>
        <div class="tab-pane fade pt-3" id="Predicate" role="tabpanel" aria-labelledby="Predicate-tab">
            <?= create_example_of_use_links(APP_PATH . 'classes/logic/Predicate.php', title: 'Example of class <code>Domain</code>', opened: true); ?>
        </div>
        <div class="tab-pane fade pt-3" id="AtomicFormula" role="tabpanel" aria-labelledby="AtomicFormula-tab">
            <?= create_example_of_use_links(APP_PATH . 'classes/logic/AtomicFormula.php', title: 'Example of class <code>AtomicFormula</code>', opened: true); ?>
        </div>
        <div class="tab-pane fade pt-3" id="PredicateLogic" role="tabpanel" aria-labelledby="PredicateLogic-tab">
            <?= create_example_of_use_links(APP_PATH . 'classes/logic/PredicateLogic.php', title: 'Example of class <code>PredicateLogic</code>', opened: true); ?>
        </div>
    </div>
</div>
