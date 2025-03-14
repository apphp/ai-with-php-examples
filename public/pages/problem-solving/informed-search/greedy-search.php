<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Informed (Heuristic) Search</h1>
</div>

<?= create_run_code_button('Greedy Search', 'problem-solving', 'informed-search', 'greedy-search-code-run'); ?>

<div>
    <p>
        Greedy search is an informed search algorithm that aims to expand the node closest to the goal, as estimated by a heuristic function . It
        takes a direct and straightforward approach, always choosing the path that seems most promising based on the heuristic value. The method is
        inspired by human intuition — choosing the option that appears best at each step without considering the overall problem structure. While
        simple and often efficient, greedy search is not guaranteed to find the optimal solution.
    </p>
</div>

<div>
    <?= create_example_of_use_links(APP_PATH . 'include/classes/search/InformedSearchGraph.php', title: 'Example of class <code>InformedSearchGraph</code> (with Greedy search)', opened: true); ?>
</div>


