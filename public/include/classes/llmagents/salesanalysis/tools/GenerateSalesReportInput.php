<?php

declare(strict_types=1);

namespace app\public\include\classes\llmagents\salesanalysis\tools;

final readonly class GenerateSalesReportInput {
    public function __construct(
        public string $reportContent,
    ) {
    }
}
