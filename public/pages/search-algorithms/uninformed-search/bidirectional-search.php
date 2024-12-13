<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Uninformed (Blind) Search</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Bidirectional Search (BDS)</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?= create_href('search-algorithms', 'uninformed-search', 'bidirectional-search-code-run') ?>"
               class="btn btn-sm btn-outline-primary">&#9654;&nbsp; Run Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        Bidirectional Search (BDS) is an efficient graph traversal algorithm that conducts two simultaneous searches: one starting from the initial
        state (forward search) and the other from the goal state (backward search). These searches progress until their respective search trees
        intersect, signaling that a solution path has been found. By effectively replacing a single large search space with two smaller subgraphs, BDS
        minimizes the computational overhead, making it an attractive option for navigating vast graphs.
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/uninformed-graph-code.php', title: 'Example of class <code>UninformedSearchGraph</code> (with BDS search)', opened: true); ?>
</div>
