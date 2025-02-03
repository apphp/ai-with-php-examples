<?php
include_once('informed-graph-code.php');

$beam = isset($_GET['beam']) && is_string($_GET['beam']) ? $_GET['beam'] : '';
verify_fields($beam, ['1', '2', '3'], '1');

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////
include('hill-climbing-search-code-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();


?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Informed (Heuristic) Search</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Hill Climbing Search</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?= create_href('search-algorithms', 'informed-search', 'hill-climbing-search') ?>" class="btn btn-sm btn-outline-primary">Show
                Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        Hill climbing is an iterative optimization technique that attempts to find the best solution by making incremental changes to a given
        solution, similar to climbing up a hill to reach its peak. The algorithm starts with an initial solution and continuously moves toward better
        solutions until no further improvements can be made.
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/hill-climbing-search-code-usage.php'); ?>
</div>

<div class="container-fluid px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-7 px-1 pe-4">
            <p><b>Graph:</b></p>

            <?php
            $graph = '
               graph TD                    
                    S(("S<small class="sub-title">level=0<br>h=10</small>"))
                    A(("A<small class="sub-title">level=1<br>h=8</small>"))
                    B(("B<small class="sub-title">level=1<br>h=8.5</small>"))
                    C(("C<small class="sub-title">level=1<br>h=9</small>"))
                    D(("D<small class="sub-title">level=2 <br>h=7</small>"))
                    E(("E<small class="sub-title">level=2 <br>h=6.5</small>"))
                    F(("F<small class="sub-title">level=2 <br>h=7.5</small>"))
                    H(("H<small class="sub-title">level=3 <br>h=5</small>"))
                    I(("I<small class="sub-title">level=3 <br>h=4.5</small>"))
                    J(("J<small class="sub-title">level=3 <br>h=6</small>"))
                    K(("K<small class="sub-title">level=4 <br>h=3</small>"))
                    L(("L<small class="sub-title">level=4 <br>h=2.5</small>"))
                    M(("M<small class="sub-title">level=4 <br>h=4</small>"))
                    N(("N<small class="sub-title">level=3 <br>h=5.5</small>"))
                    O(("O<small class="sub-title">level=4 <br>h=3.5</small>"))
                    P(("P<small class="sub-title">level=5 <br>h=1.5</small>"))
                    Q(("Q<small class="sub-title">level=5 <br>h=2</small>"))
                    G(("G<small class="sub-title">level=6 <br>h=0</small>"))
                
                    S -->|2.1| A
                    S -->|1.5| B
                    S -->|1.1| C
                    A -->|2.5| D
                    B -->|2| E
                    C -->|1.5| F
                    D -->|2| H
                    E -->|2| I
                    F -->|2| J
                    H -->|2| K
                    I -->|2.5| L
                    J -->|2| M
                    K -->|3| P
                    L -->|2| P
                    M -->|2.5| Q
                    P -->|2| G
                    Q -->|3| G
                    D -->|1.5| E
                    E -->|1| F
                    H -->|1| I
                    I -->|1.5| J
                    K -->|1| L
                    L -->|1.5| M
                    F -->|2| N
                    N -->|2.5| O
                    O -->|2| Q
                ';

                $steps = '[
                    { visit: "S", info: "Starting at root node S", edge: null },
                    { visit: "B", info: "Visiting first level node B", edge: "A-B" },
                    { visit: "E", info: "Visiting second level node E", edge: "B-E" },
                    { visit: "I", info: "Visiting third level node I", edge: "E-I" },
                    { visit: "L", info: "Visiting forth level node L", edge: "I-L" },
                    { visit: "P", info: "Visiting fifth level node P", edge: "L-P" },
                    { visit: "G", info: "Visiting sixth level node G - Search complete!", edge: "P-G" }
                ]';

            echo Chart::drawTreeDiagram(
                graph: $graph,
                steps: $steps,
                defaultMessage: 'Starting Beam traversal...',
                startNode: 'S',
                endNode: 'G',
                intersectionNode: '',
            );
            ?>

        </div>
        <div class="col-md-12 col-lg-5 p-0 m-0">
            <div class="mb-1">
                <b>Result:</b>
                <span class="float-end">Memory: <?= memory_usage($memoryEnd, $memoryStart); ?> Mb</span>
                <span class="float-end me-2">Time running: <?= running_time($microtimeEnd, $microtimeStart); ?> sec.</span>
            </div>
            <code class="code-result">
                <pre><?= $result; ?></pre>
            </code>
        </div>
    </div>
</div>
