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


    <ui class="list">
        <li><a href="<?= create_href('search-algorithms', 'uninformed-search', 'breadth-first-search') ?>">Breadth-First Search (BFS)</a></li>
    </ui>
</div>

<div>
</div>
