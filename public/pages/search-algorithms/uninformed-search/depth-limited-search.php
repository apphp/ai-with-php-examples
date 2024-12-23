<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Uninformed (Blind) Search</h1>
</div>

<?= create_run_code_button('Depth-Limited Search (DFS)', 'search-algorithms', 'uninformed-search', 'depth-limited-search-code-run'); ?>

<div>
    <p>
        The Depth-Limited Search (DLS) algorithm is an extension of the Depth-First Search (DFS) algorithm, designed to address the challenge of
        infinite paths in certain problem spaces. DLS introduces a predetermined depth limit to the search process, treating nodes at this limit as
        though they have no successors. By constraining the depth, DLS avoids the pitfalls of exploring infinite paths while maintaining the
        advantages of depth-first traversal.
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/uninformed-graph-code.php', title: 'Example of class <code>UninformedSearchGraph</code> (with DLS search)', opened: true); ?>
</div>


