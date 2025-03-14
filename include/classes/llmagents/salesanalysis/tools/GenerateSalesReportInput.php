<?php

declare(strict_types=1);

namespace app\include\classes\llmagents\salesanalysis\tools;

final readonly class GenerateSalesReportInput {
    public function __construct(
        public string $reportPath,
    ) {
    }
}
