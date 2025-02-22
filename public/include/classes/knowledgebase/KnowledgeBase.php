<?php

namespace app\public\include\classes\knowledgebase;

class KnowledgeBase {
    private array $facts = [];

    public function tell(string $sentence): void {
        $this->facts[] = $sentence;
    }

    public function ask(string $query): ?string {
        foreach ($this->facts as $fact) {
            if ($this->matches($query, $fact)) {
                return $fact;
            }
        }
        return null;
    }

    private function matches(string $query, string $fact): bool {
        return str_contains($fact, $query);
    }

    public function getFacts(): array {
        return $this->facts;
    }
}
