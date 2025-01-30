<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Search Algorithms with AI</h1>
</div>

<div>
    <h2 class="h4">Uninformed (Blind) Search</h2>
    <p>
        Uninformed search algorithms operate without any domain-specific knowledge about the problem. These algorithms do not use information such as
        the location of the goal or the proximity of states to the goal. Instead, they traverse the search tree systematically, evaluating nodes based
        solely on their position within the tree. This lack of guidance often results in brute-force exploration of the search space, examining every
        possible state until the goal is found.
    </p>

    <h3 class="h5">Global Search</h3>
    <ui class="list">
        <li><a href="<?= create_href('search-algorithms', 'uninformed-search', 'breadth-first-search') ?>">Breadth-First Search (BFS)</a></li>
        <li><a href="<?= create_href('search-algorithms', 'uninformed-search', 'depth-first-search') ?>">Depth-First Search (DFS)</a></li>
        <li><a href="<?= create_href('search-algorithms', 'uninformed-search', 'uniform-cost-search') ?>">Uniform Cost Search (UCS)</a></li>
        <li><a href="<?= create_href('search-algorithms', 'uninformed-search', 'iterative-deepening-depth-first-search') ?>">Iterative Deepening Depth-First Search (IDDFS)</a></li>
        <li><a href="<?= create_href('search-algorithms', 'uninformed-search', 'bidirectional-search') ?>">Bidirectional Search (BDS)</a></li>
    </ui>
    <br>
    <br>

    <h3 class="h5">Local Search</h3>
    <ui class="list">
        <li><a href="<?= create_href('search-algorithms', 'uninformed-search', 'depth-limited-search') ?>">Depth-Limited Search (DLS)</a></li>
        <li><a href="<?= create_href('search-algorithms', 'uninformed-search', 'random-walk-search') ?>">Random Walk Search (RWS)</a></li>
    </ui>
</div>

<div>
</div>
