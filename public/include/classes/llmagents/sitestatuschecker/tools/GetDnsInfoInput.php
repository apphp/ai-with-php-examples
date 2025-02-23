<?php

declare(strict_types=1);

namespace app\public\include\classes\llmagents\sitestatuschecker\tools;

final readonly class GetDnsInfoInput
{
    public function __construct(
        public string $domain,
    ) {}
}
