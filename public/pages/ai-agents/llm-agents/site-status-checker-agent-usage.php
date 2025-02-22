<?php

use app\public\include\classes\llmagents\CheckSiteAvailabilityInput;
use app\public\include\classes\llmagents\CheckSiteAvailabilityTool;
use app\public\include\classes\llmagents\SiteStatusCheckerAgent;
use LLM\Agents\Agent\Agent;

$a = new Agent('a', 'b', 'c', 'd');
$agent = new SiteStatusCheckerAgent($a);
$agent = $agent->create();
//ddd($agent->getDescription());

// TODO: convert name into class name of tool and call it !!!!!!!!
// TODO: add 2 other tools
//ddd($agent->getTools()[1]->getName());


$tool = new CheckSiteAvailabilityTool();
$input = new CheckSiteAvailabilityInput("http://aiwithphp.org");
$result = $tool->execute($input);


echo 'Agent Name: ' . $agent->getName() . "\n";
echo 'Agent Description: <div>' . $agent->getDescription() . "</div>\n";
echo "Result: ";
echo "\n---------------------------\n";

// Print each key-value pair on a new line
foreach (json_decode($result, true) as $key => $value) {
    echo "$key: $value\n";
}
