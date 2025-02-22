<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Informed (Heuristic) Search</h1>
</div>

<?= create_run_code_button('A* Graph Search', 'problem-solving', 'informed-search', 'a-graph-search-code-run'); ?>

<div>
    <p>
        A* Graph Search is an enhancement of the A* Tree Search algorithm, designed to optimize its efficiency by addressing a key limitation: the
        re-exploration of nodes. In tree search, the same node can be expanded multiple times across different branches, wasting time and
        computational resources.
        <br><br>
        A* Graph Search mitigates this issue by introducing a critical rule: a node is not expanded more than once. This improvement allows the
        algorithm to explore paths more efficiently while retaining the benefits of A*’s heuristic-based approach.
    </p>
</div>

<div>
    <?= create_example_of_use_links(APP_PATH . '/public/include/classes/search/InformedSearchGraph.php', title: 'Example of class <code>InformedSearchGraph</code> (with A* Graph search)', opened: true); ?>
</div>


