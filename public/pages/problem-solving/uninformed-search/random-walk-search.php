<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Uninformed (Blind) Search</h1>
</div>

<?= create_run_code_button('Random Walk Search (RWS)', 'problem-solving', 'uninformed-search', 'random-walk-search-code-run'); ?>

<div>
    <p>
        The Random Walk Search algorithm is a fundamental search strategy where a search agent randomly selects and moves to a neighboring node
        without maintaining a history of past states. This approach is often used in scenarios where structured search methods are either infeasible
        or inefficient due to an unknown or highly complex search space.
    </p>
</div>

<div>
    <?= create_example_of_use_links(APP_PATH . 'public/include/classes/search/UninformedSearchGraph.php', title: 'Example of class <code>UninformedSearchGraph</code> (with RWS search)', opened: true); ?>
</div>


