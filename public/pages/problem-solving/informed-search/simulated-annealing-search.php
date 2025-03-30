<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Informed (Heuristic) Search</h1>
</div>

<h2 class="h4">Simulated Annealing Search</h2>
<br>

<div>
    <div>
        <p>
            Simulated Annealing (SA) is an optimization algorithm inspired by the annealing process in metallurgy, where materials are heated and slowly
            cooled to reach a stable state with minimal energy. It is used to find approximate solutions to optimization problems by iteratively exploring
            potential solutions and occasionally accepting worse solutions to escape local optima.
        </p>
    </div>

    <div class="bg-light bg-opacity-50 p-3 rounded border mt-2 mb-4">
        <h3 class="h6 fw-semibold mb-3">How Simulated Annealing Works</h3>
        <div class="small">
            <p>
                <strong>1. High Temperature Phase:</strong> The algorithm explores widely,
                accepting many worse solutions to escape local minima.
                <br>
                <strong>2. Cooling Process:</strong> As temperature decreases, the algorithm becomes
                more selective about which solutions to accept.
                <br>
                <strong>3. Convergence:</strong> At low temperatures, the algorithm converges to
                a near-optimal solution, making only small adjustments.
            </p>
            <p class="mb-0">
                <strong>Key Insight:</strong> The acceptance probability ($P = e$<sup>-ΔE/T</sup>) allows the
                algorithm to escape local minima while eventually settling in a good solution.
            </p>
        </div>
    </div>

    <ui class="list">
        <li><a href="<?= create_href('problem-solving', 'informed-search', 'simulated-annealing-search-sample1') ?>">Sample 1</a>: &rarr; Find the minimum point of $f(x) = x²$ (with PHP)</li>
        <li><a href="<?= create_href('problem-solving', 'informed-search', 'simulated-annealing-search-sample2') ?>">Sample 2</a>: &rarr; Find the minimum point of $f(x) = x²$ (with JS)</li>
        <li><a href="<?= create_href('problem-solving', 'informed-search', 'simulated-annealing-search-sample3') ?>">Sample 3</a>: &rarr; Find the minimum point of a complex function with several local minima (with JS)</li>
    </ui>
</div>


