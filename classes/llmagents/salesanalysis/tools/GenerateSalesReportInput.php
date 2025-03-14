<?php

declare(strict_types=1);

namespace app\classes\llmagents\salesanalysis\tools;

final readonly class GenerateSalesReportInput {
    public function __construct(
        public string $reportPath,
    ) {
    }
}
