<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Uninformed (Blind) Search</h1>
</div>

<?= create_run_code_button('Uniform Cost Search (UCS)', 'problem-solving', 'uninformed-search', 'uniform-cost-search-code-run'); ?>

<div>
    <p>
        Uniform Cost Search (UCS) is a fundamental algorithm widely used in artificial intelligence for traversing weighted trees or graphs. It is
        designed to handle situations where each edge has a different cost, aiming to find the path to the goal node with the lowest cumulative cost.
        UCS achieves this by expanding nodes based on their path costs, starting from the root node.
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/uninformed-graph-code.php', title: 'Example of class <code>UninformedSearchGraph</code> (with UCS search)', opened: true); ?>
</div>


