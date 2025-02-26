<?php

declare(strict_types=1);

namespace app\public\include\classes\llmagents\sitestatuschecker\tools;

final readonly class CheckSiteAvailabilityInput {
    public function __construct(
        public string $url,
    ) {
    }
}
