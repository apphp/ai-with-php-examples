<?php

use app\public\include\classes\Chart;

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////
include('bidirectional-search-code-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Uninformed (Blind) Search</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Bidirectional Search (BDS)</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?= create_href('problem-solving', 'uninformed-search', 'bidirectional-search') ?>" class="btn btn-sm btn-outline-primary">Show
                Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        Bidirectional Search (BDS) is an efficient graph traversal algorithm that conducts two simultaneous searches: one starting from the initial
        state (forward search) and the other from the goal state (backward search). These searches progress until their respective search trees
        intersect, signaling that a solution path has been found. By effectively replacing a single large search space with two smaller subgraphs, BDS
        minimizes the computational overhead, making it an attractive option for navigating vast graphs.
    </p>
</div>

<div>
    <p class="btn btn-link px-0 py-0" id="toggleExampleOfUse" data-bs-toggle="collapse" href="#collapseExampleOfUse" role="button"
       aria-expanded="false" aria-controls="collapseExampleOfUse" title="Click to expand">
        Example of use <i id="toggleIcon" class="fa-regular fa-square-plus"></i>
    </p>
    <div class="collapse pb-4" id="collapseExampleOfUse">
        <div class="bd-clipboard">
            <button id="copyButton" type="button" class="btn-clipboard" onclick="copyToClipboard()">
                Copy
            </button>
            &nbsp;
        </div>
        <div class="code-wrapper">
            <code id="code">
                <?= highlight_file(dirname(__FILE__) . '/bidirectional-search-code-usage.php', true); ?>
            </code>
        </div>
    </div>
</div>

<div class="container-fluid px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-7 px-1 pe-4">
            <p><b>Graph:</b></p>

            <?php
            $graph = '
                    graph TB
                        A((A)) --- E((E))
                        B((B)) --- E
                        E --- G((G))
                        C((C)) --- F((F))
                        D((D)) --- F
                        F --- G                        
                        G --- H((H))                
                        H --- I((I))
                        I --- J((J))
                        J --- L((L))
                        J --- M((M))
                        I --- K((K))
                        K --- N((N))
                        K --- O((O))                 
                    ';

            $steps = '[
                    { visit: "A", info: "Starting at root node A", edge: null },
                    { visit: "E", info: "Proceeds forward and visiting node E", edge: "A-E" },
                    { visit: "O", info: "Proceeds backward and visiting node O", edge: null },
                    { visit: "B", info: "Proceeds forward and visiting node B", edge: "B-E" },
                    { visit: "K", info: "Proceeds backward and visiting node K", edge: "K-O" },
                    { visit: "G", info: "Proceeds forward and visiting node G", edge: "E-G" },
                    { visit: "I", info: "Proceeds backward and visiting node I", edge: "I-K" },
                    { visit: "H", info: "Proceeds forward and visiting node H", edge: "G-H" },
                    { visit: "H", info: "Proceeds backward and visiting node H - Search complete!", edge: "H-I" }
                ]';

            echo Chart::drawTreeDiagram(
                graph: $graph,
                steps: $steps,
                defaultMessage: 'Starting BDS traversal...',
                startNode: 'A',
                endNode: 'O',
                intersectionNode: 'H',
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
