<?php

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('predicate-logic-code-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Logical Representation in AI</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Predicate Logic Representation with PHP</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?= create_href('mathematics-for-ai', 'logic-and-reasoning', 'predicate-logic-code') ?>" class="btn btn-sm btn-outline-primary">Show Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        Predicate logic, also known as first-order logic (FOL), is a fundamental tool in AI used to represent complex relationships between objects
        and their properties. Unlike propositional logic, which deals with simple true/false statements, predicate logic allows reasoning about
        objects, their attributes, and their interconnections. This capability makes it an essential component in knowledge representation, expert
        systems, and automated reasoning.
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/predicate-logic-code-usage.php'); ?>
</div>

<?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>
