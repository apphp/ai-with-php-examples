<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Uninformed (Blind) Search</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Uniform Cost Search (UCS)</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?= create_href('search-algorithms', 'uninformed-search', 'uniform-cost-search-code-run') ?>"
               class="btn btn-sm btn-outline-primary">&#9654;&nbsp; Run Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        Uniform Cost Search (UCS) is a fundamental algorithm widely used in artificial intelligence for traversing weighted trees or graphs. It is
        designed to handle situations where each edge has a different cost, aiming to find the path to the goal node with the lowest cumulative cost.
        UCS achieves this by expanding nodes based on their path costs, starting from the root node.
    </p>
    <p>Example of class <code>UninformedSearchGraph</code> (with UCS search):</p>
</div>

<div>
    <div class="bd-clipboard">
        <button id="copyButton" type="button" class="btn-clipboard" onclick="copyToClipboard()">
            Copy
        </button>
        &nbsp;
    </div>
    <code id="code">
        <?php highlight_file('uninformed-graph-code.php'); ?>
    </code>
</div>


