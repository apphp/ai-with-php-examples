<?php

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('traveling-salesman-problem-annealing-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Practical Applications</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Traveling Salesman Problem</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?= create_href('problem-solving', 'practical-applications', 'traveling-salesman-problem-annealing') ?>"
               class="btn btn-sm btn-outline-primary">Show
                Code</a>
        </div>
    </div>
</div>

<div>

    <p>
        Simulated annealing is a probabilistic optimization technique inspired by the annealing process in metallurgy,
        where metals are heated and then slowly cooled to reduce defects.
    </p>

    <strong>How It Works:</strong>

    <ul>
        <li><strong>Temperature:</strong> Controls the probability of accepting worse solutions.
            High temperature = more exploration, low temperature = more exploitation.</li>

        <li><strong>Cooling:</strong> Temperature gradually decreases, reducing the chance of accepting worse solutions over time.</li>

        <li><strong>Neighbor Generation:</strong> In this TSP (Traveling Salesperson Problem) example, we swap two random cities to explore new routes.</li>

        <li><strong>Acceptance Rule:</strong> Better solutions are always accepted. Worse solutions may be accepted based on
            the current temperature and how much worse they are.</li>
    </ul>

    <p>
        This approach helps avoid getting stuck in local optima by occasionally accepting worse solutions,
        allowing the algorithm to explore the solution space more thoroughly before converging.
    </p>

    <p class="note">
        <strong>In the visualization:</strong><br>
        - The red dashed line represents the current solution being explored<br>
        - The green solid line represents the best solution found so far<br>
        - The event log shows the decision-making process, including acceptance probabilities<br>
        - As temperature decreases, the algorithm becomes less likely to accept worse solutions
    </p>

    <p>
        The simulation demonstrates how simulated annealing balances exploration (trying many different possibilities)
        with exploitation (refining good solutions) to find near-optimal solutions to complex problems.
    </p>
</div>

<p>
    <a class="btn btn-outline-primary" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
        Step-by-Step Explanation
    </a>
</p>
<div class="collapse" id="collapseExample">
    <div class="card card-body">
        <h2 class="h5">Step-by-Step: Simulated Annealing for TSP</h2>

        <p>
            This explanation walks through exactly how the simulated annealing algorithm works in the
            visualization to solve the Traveling Salesman Problem with 6 cities.
        </p>

        <h2 class="h5">Algorithm Initialization</h2>

        <div class="step">
            <p>The algorithm starts with:</p>
            <ul>
                <li><strong>Initial temperature:</strong> 1000 (high to allow extensive exploration)</li>
                <li><strong>Initial route:</strong> Cities visited in order [0, 1, 2, 3, 4, 5] (New York, Los Angeles, Chicago, Houston, Phoenix, Boston)</li>
                <li><strong>Initial distance:</strong> The total distance of traveling this route and returning to the start</li>
            </ul>
            <p>This initial route is stored as both the "current route" and the "best route so far".</p>
        </div>

        <h2>Main Algorithm Loop</h2>

        <div class="step">
            <h3>Generate a neighboring solution</h3>
            <p>The algorithm creates a new potential route by randomly selecting two cities and swapping their positions in the route.</p>
            <p>For example: If current route is [0,1,2,3,4,5] and cities at positions 2 and 4 are selected, the new route becomes [0,1,4,3,2,5].</p>
        </div>

        <div class="step">
            <h3>Calculate distances</h3>
            <p>The algorithm calculates:</p>
            <ul>
                <li>The distance of the current route</li>
                <li>The distance of the new potential route (neighbor)</li>
                <li>The difference between these distances (Δ = new distance - current distance)</li>
            </ul>
        </div>

        <div class="step">
            <h3>Apply the acceptance rule</h3>
            <p>The algorithm decides whether to accept the new route based on:</p>
            <ul>
                <li>If the new route is shorter (Δ < 0): <strong>Always accept it</strong></li>
                <li>If the new route is longer (Δ > 0): Accept with probability <span class="formula">P = e<sup>(-Δ/T)</sup></span>, where T is the current temperature</li>
            </ul>
            <div class="note">
                <p><strong>Why accept worse solutions?</strong> This is the key feature of simulated annealing. By occasionally accepting worse solutions, especially early in the process when temperature is high, the algorithm can escape local optima and potentially find better solutions later.</p>
            </div>
        </div>

        <div class="step">
            <h3>Update the current solution</h3>
            <p>If the new route is accepted:</p>
            <ul>
                <li>The current route is updated to the new route</li>
                <li>If this new route is better than the best route found so far, the best route is also updated</li>
            </ul>
            <p>The visualization shows this by updating the red dashed line (current route) and potentially the green solid line (best route).</p>
        </div>

        <div class="step">
            <h3>Decrease the temperature</h3>
            <p>After each iteration, the temperature is reduced by multiplying it by a cooling factor (0.99 in this demo):</p>
            <p class="formula">T<sub>new</sub> = T<sub>current</sub> × 0.99</p>
            <p>As the temperature decreases:</p>
            <ul>
                <li>The probability of accepting worse solutions decreases</li>
                <li>The algorithm gradually shifts from exploration to exploitation</li>
            </ul>
        </div>

        <div class="step">
            <h3>Repeat until stopping condition</h3>
            <p>The algorithm continues this process until:</p>
            <ul>
                <li>The temperature falls below a threshold (0.1 in this demo)</li>
                <li>The user manually stops the simulation</li>
            </ul>
            <p>The final result is the best route found throughout the entire process.</p>
        </div>

        <h2 class="h5">What You're Seeing in the Visualization</h2>

        <div class="note">
            <p>
                <strong>Red dashed line:</strong> The current route being explored. This changes frequently as the algorithm tries different paths.<br>
                <strong>Green solid line:</strong> The best route found so far. This only changes when a better solution is discovered.<br>
                <strong>Event log:</strong> Shows details for each iteration including temperature, distances, and whether a new route was accepted or rejected.
            </p>
        </div>

        <p class="my-0">
            By observing the visualization over time, you can see how the algorithm initially explores widely (accepting many worse solutions)
            and then gradually focuses on refining the best solutions as the temperature decreases.
        </p>
    </div>
</div>

<div class="container-fluid px-2 mt-3">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-12 px-1 pe-4">
            <p><b>Graph:</b></p>

            <div id="root" class="py-0"></div>

            <?php include('traveling-salesman-problem-annealing-code-usage.js'); ?>
        </div>
    </div>
</div>

