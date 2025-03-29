<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Informed (Heuristic) Search</h1>
</div>

<?= create_run_code_button('Simulated Annealing Search <small>(process visualization)</small>', 'problem-solving', 'informed-search', 'simulated-annealing-search-sample3-code-run'); ?>

<div>
    <p>
        Simulated Annealing (SA) is an optimization algorithm inspired by the annealing process in metallurgy, where materials are heated and slowly
        cooled to reach a stable state with minimal energy. It is used to find approximate solutions to optimization problems by iteratively exploring
        potential solutions and occasionally accepting worse solutions to escape local optima.
        <br>
        The goal in this example here is to find the minimum point of a complex function with several local minima.
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/simulated-annealing-search-sample3-code-js.php',
        title: 'Example of class <code>JS Sample 3</code>',
        opened: true,
        language: 'js');
    ?>
</div>

<!-- Initialize it -->
<script>hljs.highlightAll();</script>
