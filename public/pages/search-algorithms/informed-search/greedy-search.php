<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Informed (Heuristic) Search</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Greedy Search</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?= create_href('search-algorithms', 'informed-search', 'greedy-search-code-run') ?>"
               class="btn btn-sm btn-outline-primary">&#9654;&nbsp; Run Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        Greedy search is an informed search algorithm that aims to expand the node closest to the goal, as estimated by a heuristic function . It
        takes a direct and straightforward approach, always choosing the path that seems most promising based on the heuristic value. The method is
        inspired by human intuition — choosing the option that appears best at each step without considering the overall problem structure. While
        simple and often efficient, greedy search is not guaranteed to find the optimal solution.
    </p>
    <p>Example of Class Graph (with greedy search):</p>
</div>

<div>
    <div class="bd-clipboard">
        <button id="copyButton" type="button" class="btn-clipboard" onclick="copyToClipboard()">
            Copy
        </button>
        &nbsp;
    </div>
    <code id="code">
        <?php highlight_file('graph-code.php'); ?>
    </code>
</div>


