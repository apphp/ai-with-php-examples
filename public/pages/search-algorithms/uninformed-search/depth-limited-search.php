<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Uninformed (Blind) Search</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Depth-Limited Search (DFS)</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?= create_href('search-algorithms', 'uninformed-search', 'depth-limited-search-code-run') ?>"
               class="btn btn-sm btn-outline-primary">&#9654;&nbsp; Run Code</a>
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
    <p>Example of class <code>UninformedSearchGraph</code> (with DLS search):</p>
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


