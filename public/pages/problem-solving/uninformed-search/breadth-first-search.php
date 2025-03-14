<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Uninformed (Blind) Search</h1>
</div>

<?= create_run_code_button('Breadth-First Search (BFS)', 'problem-solving', 'uninformed-search', 'breadth-first-search-code-run'); ?>

<div>
    <p>
        Breadth-First Search is a widely used search strategy for traversing trees or graphs. It explores nodes level by level, expanding all
        successor nodes at the current depth before moving on to the next layer. This systematic breadthwise exploration is what gives BFS its name.
    </p>
</div>

<div>
    <?= create_example_of_use_links(APP_PATH . 'classes/search/UninformedSearchGraph.php', title: 'Example of class <code>UninformedSearchGraph</code> (with BFS search)', opened: true); ?>
</div>
