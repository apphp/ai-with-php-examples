<?php

use app\public\include\classes\KBAgent;

// Example usage:
$agent = new KBAgent();
$percept = ["temperature" => 25, "humidity" => 60];
$action = $agent->process($percept);
