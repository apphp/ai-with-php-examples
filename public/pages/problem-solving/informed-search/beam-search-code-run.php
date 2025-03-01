<?php

use app\public\include\classes\Chart;

$availablerBeams = ['β=1' => 1, 'β=2' => 2, 'β=3' => 3];
$beam = isset($_GET['beam']) && is_string($_GET['beam']) ? $_GET['beam'] : '';
verify_fields($beam, array_values($availablerBeams), reset($availablerBeams));

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('beam-search-code-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();


?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Informed (Heuristic) Search</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Beam Search</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?= create_href('problem-solving', 'informed-search', 'beam-search') ?>" class="btn btn-sm btn-outline-primary">Show
                Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        Beam Search is a heuristic search algorithm designed to balance memory consumption and search efficiency in graph-based problems. It is an
        optimization of the best-first search algorithm, but with a key difference: it retains only a limited number of “best” nodes, referred to as
        the beam width (β), at each level of the search tree. While it sacrifices completeness and optimality, Beam Search is particularly effective
        in domains where memory limitations or large search spaces make exhaustive search impractical.
        <br><br>
        The algorithm works by employing a breadth-first search approach, expanding nodes level by level. At each level, it evaluates all successors
        of the current states, sorts them by a heuristic cost function, and retains only the top β nodes. This makes it a greedy algorithm, focusing
        only on the most promising paths at any given time.
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/beam-search-code-usage.php'); ?>
</div>

<div class="container-fluid px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-7 px-1 pe-4">
            <p><b>Graph:</b></p>

            <?php
            $graph = '
                    graph TB
                        A((A<small class="sub-title">h=0</small>))--> |2| B((B<small class="sub-title">h=1</small>))
                        A--> |1| C((C<small class="sub-title">h=2</small>))                
                        A--> |2| D((D<small class="sub-title">h=3</small>))                
                        B--> |3| E((E<small class="sub-title">h=3</small>))                
                        E--> |4| G((G<small class="sub-title">h=0</small>))                
                        C--> |2| F((F<small class="sub-title">h=1</small>))                
                        F--> |3| G((G<small class="sub-title">h=0</small>))                
                        D--> |3| G((G<small class="sub-title">h=0</small>))                
                    ';

            if ($beam === '3') {
                $steps = '[
                    { visit: "A", info: "Starting at root node A", edge: null },
                    { visit: "B", info: "Visiting first level node B", edge: "A-B" },
                    { visit: "C", info: "Visiting first level node C", edge: "A-C" },
                    { visit: "D", info: "Visiting first level node C", edge: "A-D" },
                    { visit: "E", info: "Visiting second level node E", edge: "B-E" },
                    { visit: "F", info: "Visiting second level node F", edge: "C-F" },
                    { visit: "D", info: "Visiting third level node G - Search complete!", edge: "D-G" },
                    { visit: "G", info: "Visiting third level node G - Search complete!", edge: "E-G" },
                    { visit: "G", info: "Visiting third level node G - Search complete!", edge: "F-G" }
                ]';
           } elseif ($beam === '2') {
                $steps = '[
                    { visit: "A", info: "Starting at root node A", edge: null },
                    { visit: "B", info: "Visiting first level node B", edge: "A-B" },
                    { visit: "C", info: "Visiting first level node C", edge: "A-C" },
                    { visit: "E", info: "Visiting second level node E", edge: "B-E" },
                    { visit: "F", info: "Visiting second level node F", edge: "C-F" },
                    { visit: "G", info: "Visiting third level node G - Search complete!", edge: "E-G" },
                    { visit: "G", info: "Visiting third level node G - Search complete!", edge: "F-G" }
                ]';
            } else {
                $steps = '[
                    { visit: "A", info: "Starting at root node A", edge: null },
                    { visit: "B", info: "Visiting first level node B", edge: "A-B" },
                    { visit: "E", info: "Visiting second level node E", edge: "B-E" },
                    { visit: "G", info: "Visiting third level node G - Search complete!", edge: "E-G" },
                ]';
            }

            echo Chart::drawTreeDiagram(
                graph: $graph,
                steps: $steps,
                defaultMessage: 'Starting Beam traversal...',
                startNode: 'A',
                endNode: 'G',
                intersectionNode: '',
            );
           ?>

        </div>
        <div class="col-md-12 col-lg-5 p-0 m-0">
            <div>
                <div class="mt-1">
                    <b>Beam Width:</b>
                </div>
                <form action="<?= APP_SEO_LINKS ? create_href('problem-solving', 'informed-search', 'beam-search-code-run') : 'index.php'; ?>" type="GET">
                    <?= !APP_SEO_LINKS ? create_form_fields('problem-solving', 'informed-search', 'beam-search-code-run') : '';?>
                    <?=create_form_features($availablerBeams, [$beam], fieldName: 'beam', type: 'radio');?>
                    <div class="form-check form-check-inline float-end p-0 m-0 me-1">
                        <button type="submit" class="btn btn-sm btn-outline-primary">Re-generate</button>
                    </div>
                </form>
            </div>

            <hr>

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
