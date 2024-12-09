<?php
include_once('uninformed-graph-code.php');

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////
include('depth-limited-search-code-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Uninformed (Blind) Search</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Depth-Limited Search (DFS)</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?=create_href('search-algorithms', 'uninformed-search', 'depth-limited-search')?>" class="btn btn-sm btn-outline-primary">Show Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        The Depth-Limited Search (DLS) algorithm is an extension of the Depth-First Search (DFS) algorithm, designed to address the challenge of
        infinite paths in certain problem spaces. DLS introduces a predetermined depth limit to the search process, treating nodes at this limit as
        though they have no successors. By constraining the depth, DLS avoids the pitfalls of exploring infinite paths while maintaining the
        advantages of depth-first traversal.
    </p>
</div>

<div>
    <p class="btn btn-link px-0 py-0" id="toggleExampleOfUse" data-bs-toggle="collapse" href="#collapseExampleOfUse" role="button" aria-expanded="false" aria-controls="collapseExampleOfUse" title="Click to expand">
        Example of use <i id="toggleIcon" class="fa-regular fa-square-plus"></i>
    </p>
    <div class="collapse pb-4" id="collapseExampleOfUse">
        <div class="bd-clipboard">
            <button id="copyButton" type="button" class="btn-clipboard" onclick="copyToClipboard()">
                Copy
            </button>
            &nbsp;
        </div>
        <code id="code">
            <?= highlight_file(dirname(__FILE__) . '/depth-limited-search-code-usage.php', true); ?>
        </code>
    </div>
</div>

<div class="container-fluid px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-7 px-1 pe-4">
            <p><b>Graph:</b></p>

            <?php
                $graph = '
                    graph TB
                        S((S))-->A((A))
                        S-->B((B))
                        A-->C((C))
                        A-->D((D))
                        C-->E((E))
                        C-->F((F))
                        D-->G((G))
                        B-->I((I))
                        B-->J((J))
                        I-->H((H))                       
                    ';

                $steps = '[
                    { visit: "S", info: "Starting at root node S", edge: null },
                    { visit: "A", info: "Visiting first level node A", edge: "S-A" },
                    { visit: "C", info: "Visiting second level node C", edge: "A-C" },
                    { visit: "D", info: "Visiting second level node D", edge: "A-D" },
                    { visit: "B", info: "Visiting first level node B", edge: "S-B" },
                    { visit: "I", info: "Visiting second level node I", edge: "B-I" },
                    { visit: "J", info: "Visiting second level node J - Search complete!", edge: "B-J" }
                ]';

                echo Chart::drawTreeDiagram(
                    graph: $graph,
                    steps: $steps,
                    defaultMessage: 'Starting DLS traversal with max depth = 2...',
                    startNode: 'S',
                    endNode: 'J',
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
