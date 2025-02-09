<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Search Algorithms with AI</h1>
</div>

<div>
    <h2 class="h4">Informed (Heuristic) Search</h2>
    <p>
        Informed search algorithms utilize problem-specific knowledge to guide the search, making them more efficient than uninformed methods. This
        knowledge, known as a heuristic, estimates the cost to reach the goal from a given state. While heuristics do not guarantee the best solution,
        they often provide good solutions within a reasonable timeframe.
    </p>

    <h3 class="h5">Global Search</h3>
    <ui class="list">
        <li><a href="<?= create_href('problem-solving', 'informed-search', 'greedy-search') ?>">Greedy Search</a></li>
        <li><a href="<?= create_href('problem-solving', 'informed-search', 'a-tree-search') ?>">A* Tree Search</a></li>
        <li><a href="<?= create_href('problem-solving', 'informed-search', 'a-graph-search') ?>">A* Graph Search</a></li>
        <li><a href="<?= create_href('problem-solving', 'informed-search', 'iterative-deepening-a-search') ?>">Iterative Deepening A* Search</a></li>
        <li><a href="<?= create_href('problem-solving', 'informed-search', 'beam-search') ?>">Beam Search</a></li>
    </ui>

    <br>
    <br>

    <h3 class="h5">Local Search</h3>
    <ui class="list">
        <li><a href="<?= create_href('problem-solving', 'informed-search', 'hill-climbing-search') ?>">Hill Climbing Search</a></li>
        <li><a _href="<?= create_href('problem-solving', 'informed-search', 'simulated-annealing-search') ?>">Simulated Annealing Search</a></li>
        <li><a _href="<?= create_href('problem-solving', 'informed-search', 'local-beam-search') ?>">Local Beam Search</a></li>
        <li><a _href="<?= create_href('problem-solving', 'informed-search', 'genetic-algorithms-search') ?>">Genetic Algorithms Search</a></li>
        <li><a _href="<?= create_href('problem-solving', 'informed-search', 'tabu-search') ?>">Tabu Search</a></li>
    </ui>
</div>

<div>
</div>
