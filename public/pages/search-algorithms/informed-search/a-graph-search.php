<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Informed (Heuristic) Search</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">A* Graph Search</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?= create_href('search-algorithms', 'informed-search', 'a-graph-search-code-run') ?>"
               class="btn btn-sm btn-outline-primary">&#9654;&nbsp; Run Code</a>
        </div>
    </div>
</div>

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
    <?= create_example_of_use_links(__DIR__ . '/informed-graph-code.php', title: 'Example of class <code>InformedSearchGraph</code> (with A* Graph search)', opened: true); ?>
</div>


