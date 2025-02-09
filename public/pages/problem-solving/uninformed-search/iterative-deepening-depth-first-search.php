<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Uninformed (Blind) Search</h1>
</div>

<?= create_run_code_button('Iterative Deepening Depth-First Search (IDDFS)', 'problem-solving', 'uninformed-search', 'iterative-deepening-depth-first-search-code-run'); ?>

<div>
    <p>
        The Iterative Deepening Depth-First Search (IDDFS) algorithm combines the strengths of two fundamental search algorithms: Depth-First Search
        (DFS) and Breadth-First Search (BFS). This hybrid approach balances memory efficiency with optimality by progressively exploring deeper levels
        of the search space. Unlike traditional DFS, which dives to the maximum depth at once, or BFS, which requires significant memory to maintain a
        queue of explored nodes, IDDFS systematically increases the search depth, ensuring thorough exploration while minimizing resource usage.
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/uninformed-graph-code.php', title: 'Example of class <code>UninformedSearchGraph</code> (with IDDFS search)', opened: true); ?>
</div>


