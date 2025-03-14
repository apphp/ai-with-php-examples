<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Uninformed (Blind) Search</h1>
</div>

<?= create_run_code_button('Depth-First Search (DFS)', 'problem-solving', 'uninformed-search', 'depth-first-search-code-run'); ?>

<div>
    <p>
        Depth-First Search (DFS) is a classic algorithm for traversing or searching through tree and graph data structures. As the name suggests, DFS
        explores as far down a branch as possible before backtracking to examine other paths. This behavior makes DFS particularly useful in scenarios
        where exploring deep hierarchies or paths is necessary. It relies on a stack data structure — either explicitly (using a manual stack) or
        implicitly (via recursion) — to manage the nodes being visited.
    </p>
</div>

<div>
    <?= create_example_of_use_links(APP_PATH . 'include/classes/search/UninformedSearchGraph.php', title: 'Example of class <code>UninformedSearchGraph</code> (with DFS search)', opened: true); ?>
</div>


