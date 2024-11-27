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
            <script src="https://cdnjs.cloudflare.com/ajax/libs/mermaid/10.6.1/mermaid.min.js"></script>


            <div class="container">
                <div class="controls">
                    <button id="prevBtn" class="btn-graph" onclick="prevStep()" disabled>Previous Step</button>
                    <button id="nextBtn" class="btn-graph" onclick="nextStep()">Next Step</button>
                    <button id="resetBtn" class="btn-graph" onclick="resetSearch()">Reset</button>
                </div>
                <div id="step-info" class="step-info">
                    Starting BFS traversal...
                </div>
                <div id="diagram"></div>
            </div>

            <script>
                const bfsSteps = [
                    { visit: 'S', info: 'Starting at root node S' },
                    { visit: 'A', info: 'Visiting first level node A' },
                    { visit: 'B', info: 'Visiting first level node B' },
                    { visit: 'C', info: 'Visiting second level node C' },
                    { visit: 'D', info: 'Visiting second level node D' },
                    { visit: 'G', info: 'Visiting second level node G' },
                    { visit: 'H', info: 'Visiting second level node H' },
                    { visit: 'E', info: 'Visiting third level node E' },
                    { visit: 'F', info: 'Visiting third level node F' },
                    { visit: 'I', info: 'Visiting third level node I' },
                    { visit: 'K', info: 'Visiting fourth level node K - Search complete!' }
                ];

                let currentStep = -1;

                function generateDiagram(visitedNodes) {
                    return `
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

                    ${visitedNodes.slice(0, -1).map(node => `class ${node} visited`).join('\n')}
                    ${visitedNodes.length > 0 ? `class ${visitedNodes[visitedNodes.length-1]} current` : ''}
            `;
                }

                function updateDiagram() {
                    const container = document.getElementById('diagram');
                    const visitedNodes = bfsSteps.slice(0, currentStep + 1).map(step => step.visit);
                    container.innerHTML = `<div class="mermaid">${generateDiagram(visitedNodes)}</div>`;

                    document.getElementById('step-info').textContent =
                        currentStep >= 0 ? bfsSteps[currentStep].info : 'Starting BFS traversal...';

                    document.getElementById('prevBtn').disabled = currentStep <= 0;
                    document.getElementById('nextBtn').disabled = currentStep >= bfsSteps.length - 1;

                    mermaid.init(undefined, document.querySelector('.mermaid'));
                }

                function nextStep() {
                    if (currentStep < bfsSteps.length - 1) {
                        currentStep++;
                        updateDiagram();
                    }
                }

                function prevStep() {
                    if (currentStep > 0) {
                        currentStep--;
                        updateDiagram();
                    }
                }

                function resetSearch() {
                    currentStep = -1;
                    updateDiagram();
                }

                // Initialize
                mermaid.initialize({
                    startOnLoad: false,
                    theme: 'default',
                    securityLevel: 'loose',
                    flowchart: {
                        curve: 'basis',
                        padding: 25
                    }
                });

                updateDiagram();
            </script>
            <style>

                .controls {
                    margin: 20px 0;
                    text-align: center;
                }
                .btn-graph {
                    padding: 5px 10px;
                    margin: 0 5px;
                    background: #2ea723;
                    color: white;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                }
                .btn-graph:hover {
                    background: #248f1c;
                }
                .btn-graph:disabled {
                    background: #ccc;
                    cursor: not-allowed;
                }
                .step-info {
                    margin: 10px 0;
                    padding: 10px;
                    background: #f5f5f5;
                    border-radius: 4px;
                }
            </style>


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
