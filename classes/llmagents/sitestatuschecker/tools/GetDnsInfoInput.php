<?php

declare(strict_types=1);

namespace app\classes\llmagents\sitestatuschecker\tools;

final readonly class GetDnsInfoInput {
    public function __construct(
        public string $domain,
    ) {
    }
}
