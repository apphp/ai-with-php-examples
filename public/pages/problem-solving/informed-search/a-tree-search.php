<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Informed (Heuristic) Search</h1>
</div>

<?= create_run_code_button('A* Tree Search', 'problem-solving', 'informed-search', 'a-tree-search-code-run'); ?>

<div>
    <p>
        A* Tree Search, commonly referred to as A* Search, is a widely used pathfinding and graph traversal algorithm. It builds on the strengths of
        uniform-cost search and greedy search, offering a robust mechanism for finding the most cost-effective path from a starting node to a goal
        node.
        <br><br>
        A* uses a heuristic function, $f(x) = g(x) + h(x)$, where is the cumulative cost to reach the current node, and is an estimated cost to reach the goal from the
        current node. This balance between actual cost and estimated cost makes A* one of the most efficient search algorithms in many applications,
        including game development, robotics, and network optimization.
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/informed-graph-code.php', title: 'Example of class <code>InformedSearchGraph</code> (with A* Tree search)', opened: true); ?>
</div>


