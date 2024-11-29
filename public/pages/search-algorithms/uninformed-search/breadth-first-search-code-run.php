<?php
include_once('breadth-first-search-code.php');

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////
include('breadth-first-search-code-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Uninformed (Blind) Search</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Breadth-First Search (BFS)</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?=create_href('search-algorithms', 'uninformed-search', 'breadth-first-search')?>" class="btn btn-sm btn-outline-primary">Show Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        Breadth-First Search is a widely used search strategy for traversing trees or graphs. It explores nodes level by level, expanding all
        successor nodes at the current depth before moving on to the next layer. This systematic breadthwise exploration is what gives BFS its name.
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
            <?= highlight_file(dirname(__FILE__) . '/breadth-first-search-code-usage.php', true); ?>
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
                        E-->K((K))
                        B-->G((G))
                        B-->H((H))
                        G-->I((I))
                        
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
                    { visit: "B", info: "Visiting first level node B" },
                    { visit: "C", info: "Visiting second level node C" },
                    { visit: "D", info: "Visiting second level node D" },
                    { visit: "G", info: "Visiting second level node G" },
                    { visit: "H", info: "Visiting second level node H" },
                    { visit: "E", info: "Visiting third level node E" },
                    { visit: "F", info: "Visiting third level node F" },
                    { visit: "I", info: "Visiting third level node I" },
                    { visit: "K", info: "Visiting fourth level node K - Search complete!" }
                ]';

                echo Chart::drawTreeDiagram(
                    graph: $graph,
                    steps: $steps,
                    defaultMessage: 'Starting BFS traversal...'
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
