<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h3 class=h5">Practical Applications</h1>
</div>

<?= create_run_code_button('Traveling Salesman Problem', 'problem-solving', 'practical-applications', 'traveling-salesman-problem-annealing-code-run'); ?>

<div>
    The TSP has applications in logistics, planning, microchip manufacturing, DNA sequencing, and many other fields - making this visualization not just a demonstration of an algorithm, but a simulation of solving real-world optimization problems.

    <p>
        The visualization demonstrates <strong>simulated annealing</strong> applied to the classic
        <strong>Traveling Salesman Problem (TSP)</strong>, one of the most famous problems in
        computational complexity theory.
    </p>

    <h3 class="h5">What is the Traveling Salesman Problem?</h3 class=h5>

    <p>
        The TSP asks: "Given a list of cities and the distances between each pair of cities,
        what is the shortest possible route that visits each city exactly once and returns to
        the origin city?"
    </p>

    <div class="highlight">
        <p>In this demo:</p>
        <ul>
            <li>Each blue circle represents a city (New York, Los Angeles, Chicago, etc.)</li>
            <li>The lines between cities represent travel paths</li>
            <li>The goal is to find the shortest path that visits all cities exactly once and returns to the starting point</li>
        </ul>
    </div>

    <h3 class="h5">Why TSP is Important</h3 class=h5>

    <p>TSP is significant because:</p>
    <ul>
        <li>It's an <span class="important">NP-hard problem</span>, meaning there is no known algorithm that can efficiently find the optimal solution for large instances</li>
        <li>For even a modest number of cities, the number of possible routes becomes astronomically large</li>
        <li>With just 6 cities (as shown in the demo), there are already <span class="math">720</span> possible routes!</li>
        <li>With 20 cities, there would be over 2 quintillion possible routes</li>
    </ul>

    <h3 class="h5">Simulated Annealing for TSP</h3 class=h5>

    <p>
        Simulated annealing is particularly well-suited for the TSP because:
    </p>

    <ol>
        <li><strong>It doesn't require examining all possible solutions</strong> - critical when the solution space is enormous</li>
        <li><strong>It can escape local optima</strong> - if the algorithm finds what seems like a good route, it can still explore other possibilities that might lead to better solutions</li>
        <li><strong>It gradually refines the solution</strong> - starting with exploration and transitioning to optimization</li>
    </ol>

    <div class="highlight">
        <p>In the visualization, you can observe how the algorithm:</p>
        <ul>
            <li>Initially tries many different city arrangements (when temperature is high)</li>
            <li>Gradually settles on promising routes as the temperature decreases</li>
            <li>Eventually converges to a near-optimal solution</li>
        </ul>
    </div>
</div>


<div>
    <?= create_example_of_use_links(__DIR__ . '/traveling-salesman-problem-annealing-code-usage.js', title: 'Example of Code'); ?>
</div>

<p><br></p>
<p><br></p>



