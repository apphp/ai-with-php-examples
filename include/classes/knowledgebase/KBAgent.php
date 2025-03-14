<?php

namespace app\include\classes\knowledgebase;

class KBAgent {
    private int $t = 0;

    public function __construct(
        private KnowledgeBase $kb = new KnowledgeBase()
    ) {}

    public function makePerceptSentence(array $percept, int $t): string {
        return "At time {$t}, perceived: " . json_encode($percept);
    }

    public function makeActionQuery(int $t): string {
        return "action_at_time_{$t}";
    }

    public function makeActionSentence(array $action, int $t): string {
        return "At time {$t}, performed action: " . json_encode($action);
    }

    private function printStep(int $stepNumber, string $title, string $content, $eol = "\n"): void {
        echo <<<OUTPUT
        Step {$stepNumber}: {$title}
        --------------------
        {$content}
        {$eol}
        OUTPUT;
    }

    private function printInitialState(int $timeStep, array $percept): void {
        $content = <<<CONTENT
        Time step: {$timeStep}
        Percept received: {$this->jsonEncode($percept)}
        CONTENT;

        $this->printStep(1, 'Initial State', $content);
    }

    private function printPerceptSentence(string $sentence): void {
        $this->printStep(2, 'Percept Sentence Created', $sentence);
    }

    private function printActionGenerated(array $action): void {
        $this->printStep(3, 'Action Generated', 'Action: ' . $this->jsonEncode($action));
    }

    private function printFinalState(int $nextTimeStep, string $actionSentence): void {
        $content = <<<CONTENT
        Time step incremented to: {$nextTimeStep}
        Action recorded in KB: {$actionSentence}
        CONTENT;

        $this->printStep(4, 'Final Knowledge Base State', $content, eol: '');
    }

    private function jsonEncode(array $data): string {
        return json_encode($data, JSON_THROW_ON_ERROR);
    }

    public function process(array $percept): array {
        // Step 1: Show initial state
        $this->printInitialState($this->t, $percept);

        // Tell KB about the percept
        $perceptSentence = $this->makePerceptSentence($percept, $this->t);
        $this->kb->tell($perceptSentence);

        // Step 2: Show percept sentence
        $this->printPerceptSentence($perceptSentence);

        // Ask KB what action to take and use default if none found
        $action = $this->kb->ask($this->makeActionQuery($this->t))
            ?? $this->defaultAction($percept);

        // Step 3: Show action
        $this->printActionGenerated($action);

        // Tell KB about the action taken
        $actionSentence = $this->makeActionSentence($action, $this->t);
        $this->kb->tell($actionSentence);

        // Step 4: Show final state
        $this->printFinalState($this->t + 1, $actionSentence);

        // Increment time step
        $this->t++;

        return $action;
    }

    private function defaultAction(array $percept): array {
        return [
            'type' => 'default_action',
            'percept' => $percept
        ];
    }
}
