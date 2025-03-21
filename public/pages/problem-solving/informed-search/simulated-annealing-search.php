<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Informed (Heuristic) Search</h1>
</div>

<?= create_run_code_button('Simulated Annealing Search',
    'problem-solving', 'informed-search', 'simulated-annealing-search-code-run',
    section2: 'problem-solving', subsection2: 'informed-search', page2: 'simulated-annealing-search-code-example-1-run', buttonText2: 'Visual Example #1',
    section3: 'problem-solving', subsection3: 'informed-search', page3: 'simulated-annealing-search-code-example-2-run', buttonText3: 'Visual Example #2'
); ?>

<div>
    <p>
        Simulated Annealing (SA) is an optimization algorithm inspired by the annealing process in metallurgy, where materials are heated and slowly
        cooled to reach a stable state with minimal energy. It is used to find approximate solutions to optimization problems by iteratively exploring
        potential solutions and occasionally accepting worse solutions to escape local optima.
    </p>
</div>

<div>
    <?= create_example_of_use_links(APP_PATH . 'classes/search/SimulatedAnnealing.php', title: 'Example of class <code>SimulatedAnnealing</code>', opened: true); ?>
</div>


