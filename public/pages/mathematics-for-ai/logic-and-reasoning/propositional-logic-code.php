<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Logical Representation in AI</h1>
</div>

<?= create_run_code_button('Propositional Logic Representation with PHP', 'mathematics-for-ai', 'logic-and-reasoning', 'propositional-logic-code-run'); ?>

<div>
    <p>
        Propositional logic, also known as Boolean logic (basic logical operations like: AND, OR, NOT, etc.), is a fundamental concept in AI that deals with statements that are either true or false. It
        provides a systematic way to represent knowledge and reason about facts using logical operators. AI systems utilize propositional logic in
        various applications, such as expert systems, automated reasoning, and problem-solving.
    </p>
</div>

<div>
    <ul class="nav nav-tabs mt-4" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="Proposition-tab" data-bs-toggle="tab" data-bs-target="#Proposition" type="button" role="tab"
                    aria-controls="Proposition" aria-selected="true">Proposition
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="PropositionalLogic-tab" data-bs-toggle="tab" data-bs-target="#PropositionalLogic" type="button" role="tab"
                    aria-controls="PropositionalLogic" aria-selected="false">PropositionalLogic
            </button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active pt-3" id="Proposition" role="tabpanel" aria-labelledby="Proposition-tab">
            <?= create_example_of_use_links(APP_PATH . 'src/Knowledge/Logic/Propositional/Proposition.php', title: 'Example of class <code>Proposition</code>', opened: true); ?>
        </div>
        <div class="tab-pane fade pt-3" id="PropositionalLogic" role="tabpanel" aria-labelledby="PropositionalLogic-tab">
            <?= create_example_of_use_links(APP_PATH . 'src/Knowledge/Logic/Propositional/PropositionalLogic.php', title: 'Example of class <code>PropositionalLogic</code>', opened: true); ?>
        </div>
    </div>
</div>
