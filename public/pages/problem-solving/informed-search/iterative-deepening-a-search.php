<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Informed (Heuristic) Search</h1>
</div>

<?= create_run_code_button('Iterative Deepening A*', 'problem-solving', 'informed-search', 'iterative-deepening-a-search-code-run'); ?>

<div>
    <p>
        The Iterative Deepening A* Algorithm (IDA*) is a heuristic search method that combines the memory efficiency of Depth-First Search (DFS) with
        the optimal path-finding capabilities of the A* algorithm. It is specifically designed to handle large search spaces while maintaining
        optimality and completeness. By limiting memory usage, IDA* enables effective exploration of complex networks or trees to find the shortest
        path from the start state to the goal state.
    </p>
</div>

<div>
    <?= create_example_of_use_links(APP_PATH . 'classes/search/InformedSearchGraph.php', title: 'Example of class <code>InformedSearchGraph</code> (with Iterative Deepening A* search)', opened: true); ?>
</div>


