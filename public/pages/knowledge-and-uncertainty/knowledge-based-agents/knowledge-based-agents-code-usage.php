<?php

// Example usage:
use app\classes\knowledgebase\KBAgent;

$agent = new KBAgent();
$percept = ['temperature' => 25, 'humidity' => 60];
$action = $agent->process($percept);
