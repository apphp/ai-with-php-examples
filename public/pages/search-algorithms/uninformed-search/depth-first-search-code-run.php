<?php
include_once('graph-code.php');

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////
include('depth-first-search-code-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Uninformed (Blind) Search</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Depth-First Search (DFS)</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?=create_href('search-algorithms', 'uninformed-search', 'depth-first-search')?>" class="btn btn-sm btn-outline-primary">Show Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        Depth-First Search (DFS) is a classic algorithm for traversing or searching through tree and graph data structures. As the name suggests, DFS
        explores as far down a branch as possible before backtracking to examine other paths. This behavior makes DFS particularly useful in scenarios
        where exploring deep hierarchies or paths is necessary. It relies on a stack data structure — either explicitly (using a manual stack) or
        implicitly (via recursion) — to manage the nodes being visited.
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
            <?= highlight_file(dirname(__FILE__) . '/depth-first-search-code-usage.php', true); ?>
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
                        S-->H((H))
                        A-->B((B))
                        A-->C((C))
                        B-->D((D))
                        B-->E((E))
                        C-->K((K))
                        H-->I((I))
                        H-->J((J))
                        I-->K1((K))
                        
                    %% Apply styles
                        class S sNode
                        class K gNode
                        
                    %% Styling
                        classDef default fill:#d0e6b8,stroke:#2ea723,stroke-width:2px;
                        linkStyle default stroke:#2ea723,stroke-width:2px;
                        classDef sNode fill:#a0eFeF,stroke:#333,stroke-width:1px
                        classDef gNode fill:#FFA07A,stroke:#333,stroke-width:1px
                        
                        classDef default fill:#d0e6b8,stroke:#2ea723,stroke-width:2px
                        classDef visited fill:#ff9999,stroke:#ff0000,stroke-width:2px
                        classDef current fill:#ffff99,stroke:#ffa500,stroke-width:3px                        
                    ';

                $steps = '[
                    { visit: "S", info: "Starting at root node S" },
                    { visit: "A", info: "Visiting first level node A" },
                    { visit: "B", info: "Visiting second level node B" },
                    { visit: "D", info: "Visiting third level node D" },
                    { visit: "E", info: "Visiting third level node E" },
                    { visit: "C", info: "Visiting second level node C" },
                    { visit: "K", info: "Visiting third level node K - Search complete!" }
                ]';

                echo Chart::drawTreeDiagram(
                    graph: $graph,
                    steps: $steps,
                    defaultMessage: 'Starting DFS traversal...'
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
