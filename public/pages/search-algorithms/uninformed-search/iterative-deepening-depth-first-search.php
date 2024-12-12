<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Uninformed (Blind) Search</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Iterative Deepening Depth-First Search (IDDFS)</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?= create_href('search-algorithms', 'uninformed-search', 'iterative-deepening-depth-first-search-code-run') ?>"
               class="btn btn-sm btn-outline-primary">&#9654;&nbsp; Run Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        The Iterative Deepening Depth-First Search (IDDFS) algorithm combines the strengths of two fundamental search algorithms: Depth-First Search
        (DFS) and Breadth-First Search (BFS). This hybrid approach balances memory efficiency with optimality by progressively exploring deeper levels
        of the search space. Unlike traditional DFS, which dives to the maximum depth at once, or BFS, which requires significant memory to maintain a
        queue of explored nodes, IDDFS systematically increases the search depth, ensuring thorough exploration while minimizing resource usage.
    </p>
    <p>Example of class <code>UninformedSearchGraph</code> (with IDDFS search):</p>
</div>

<div>
    <div class="bd-clipboard">
        <button id="copyButton" type="button" class="btn-clipboard" onclick="copyToClipboard()">
            Copy
        </button>
        &nbsp;
    </div>
    <code id="code">
        <?php highlight_file('uninformed-graph-code.php'); ?>
    </code>
</div>


