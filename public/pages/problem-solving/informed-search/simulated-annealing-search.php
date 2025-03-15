<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Informed (Heuristic) Search</h1>
</div>

<?= create_run_code_button('Simulated Annealing Search', 'problem-solving', 'informed-search', 'simulated-annealing-search-code-run'); ?>

<div>
    <p>
    <div class="info-box">
        <h3>How Simulated Annealing Works</h3>
        <p>Simulated Annealing is inspired by the metallurgical process of annealing, where metals are heated and then cooled slowly to reduce defects.</p>

        <div class="parameters">
            <div class="parameter-item">
                <h4>Key Parameters:</h4>
                <ul>
                    <li><strong>Initial Temperature:</strong> Controls the initial willingness to accept worse solutions</li>
                    <li><strong>Cooling Rate:</strong> How quickly temperature decreases</li>
                    <li><strong>Stopping Temperature:</strong> When to stop the cooling process</li>
                </ul>
            </div>
            <div class="parameter-item">
                <h4>Algorithm Steps:</h4>
                <ol>
                    <li>Start with a random solution and high temperature</li>
                    <li>Generate a neighbor solution and evaluate it</li>
                    <li>Decide whether to accept the new solution:
                        <ul>
                            <li>If better: Always accept</li>
                            <li>If worse: Accept with probability P = e<sup>(-ΔE/T)</sup></li>
                        </ul>
                    </li>
                    <li>Decrease temperature</li>
                    <li>Repeat until stopping criterion is met</li>
                </ol>
            </div>
        </div>

        <p><strong>Key Insight:</strong> The algorithm can escape local minima by occasionally accepting worse solutions, especially at high temperatures. As temperature decreases, it becomes more selective, eventually converging to a good solution.</p>
    </div>
    </p>
</div>

<div>
<!--    --><?php //= create_example_of_use_links(APP_PATH . 'classes/search/InformedSearchGraph.php', title: 'Example of class <code>InformedSearchGraph</code> (with Hill Climbing search)', opened: true); ?>
</div>


