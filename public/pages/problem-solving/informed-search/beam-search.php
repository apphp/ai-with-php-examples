<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Informed (Heuristic) Search</h1>
</div>

<?= create_run_code_button('Beam Search', 'problem-solving', 'informed-search', 'beam-search-code-run'); ?>

<div>
    <p>
        Beam Search is a heuristic search algorithm designed to balance memory consumption and search efficiency in graph-based problems. It is an
        optimization of the best-first search algorithm, but with a key difference: it retains only a limited number of “best” nodes, referred to as
        the beam width ($β$), at each level of the search tree. While it sacrifices completeness and optimality, Beam Search is particularly effective
        in domains where memory limitations or large search spaces make exhaustive search impractical.
        <br><br>
        The algorithm works by employing a breadth-first search approach, expanding nodes level by level. At each level, it evaluates all successors
        of the current states, sorts them by a heuristic cost function, and retains only the top $β$ nodes. This makes it a greedy algorithm, focusing
        only on the most promising paths at any given time.
    </p>
</div>

<div>
    <?= create_example_of_use_links(APP_PATH . '/public/include/classes/search/InformedSearchGraph.php', title: 'Example of class <code>InformedSearchGraph</code> (with Beam search)', opened: true); ?>
</div>


