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


    <ui class="list">
        <li><a href="<?= create_href('search-algorithms', 'informed-search', 'greedy-search') ?>">Greedy Search</a></li>
        <li><a href="<?= create_href('search-algorithms', 'informed-search', 'a-tree-search') ?>">A* Tree Search</a></li>
        <li><a href="<?= create_href('search-algorithms', 'informed-search', 'a-graph-search') ?>">A* Graph Search</a></li>
        <li><a href="<?= create_href('search-algorithms', 'informed-search', 'iterative-deepening-a-search') ?>">Iterative Deepening A*</a></li>
    </ui>
</div>

<div>
</div>
