<?php

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('propositional-logic-code-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Logical Representation in AI</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">Propositional Logic Representation with PHP</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="<?= create_href('mathematics-for-ai', 'logic-and-reasoning', 'propositional-logic-code') ?>" class="btn btn-sm btn-outline-primary">Show Code</a>
        </div>
    </div>
</div>

<div>
    <p>
        Propositional logic, also known as Boolean logic (basic logical operations like: AND, OR, NOT, etc.), is a fundamental concept in AI that deals with statements that are either true or false. It
        provides a systematic way to represent knowledge and reason about facts using logical operators. AI systems utilize propositional logic in
        various applications, such as expert systems, automated reasoning, and problem-solving.
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/propositional-logic-code-usage.php'); ?>
</div>

<?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>
