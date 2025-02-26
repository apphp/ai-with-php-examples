<?php

declare(strict_types=1);

namespace app\public\include\classes\llmagents\sitestatuschecker\tools;

final readonly class PerformPingTestInput {
    public function __construct(
        public string $host,
        public int    $steps = 3
    ) {
    }
}
