<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Uninformed (Blind) Search</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Depth-First Search (DFS)</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?= create_href('search-algorithms', 'uninformed-search', 'depth-first-search-code-run') ?>"
               class="btn btn-sm btn-outline-primary">&#9654;&nbsp; Run Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        Depth-First Search (DFS) is a classic algorithm for traversing or searching through tree and graph data structures. As the name suggests, DFS
        explores as far down a branch as possible before backtracking to examine other paths. This behavior makes DFS particularly useful in scenarios
        where exploring deep hierarchies or paths is necessary. It relies on a stack data structure — either explicitly (using a manual stack) or
        implicitly (via recursion) — to manage the nodes being visited.
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/uninformed-graph-code.php', title: 'Example of class <code>UninformedSearchGraph</code> (with DFS search)', opened: true); ?>
</div>


