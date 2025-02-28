<?php

declare(strict_types=1);

namespace app\public\include\classes\llmagents\salesanalysis\tools;

/**
 * Input schema for the forecast tool
 */
final class ForecastFutureSalesInput
{
    public function __construct(
        public readonly string $reportPath,
        public readonly string $forecastMethod = 'exponential_smoothing',
        public readonly int $forecastPeriods = 6,
        public readonly string $timeUnit = 'month',
        public readonly float $confidence = 0.95,
        public readonly ?int $seasonality = null
    ) {}
}
