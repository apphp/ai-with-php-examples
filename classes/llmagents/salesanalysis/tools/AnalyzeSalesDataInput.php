<?php

declare(strict_types=1);

namespace app\classes\llmagents\salesanalysis\tools;

/**
 * Input schema for the AnalyzeSalesDataTool
 */
final class AnalyzeSalesDataInput
{
    public function __construct(
        /**
         * Path to the sales data file (CSV or JSON)
         * @var string
         */
        public readonly string $reportPath,

        /**
         * Type of analysis to perform
         * Valid values: 'basic', 'trend', 'seasonal', 'product', 'customer', 'comparative', 'comprehensive'
         * @var string
         */
        public readonly string $analysisType = 'basic',

        /**
         * Start date for filtering data (format: YYYY-MM-DD)
         * @var string|null
         */
        public readonly ?string $startDate = null,

        /**
         * End date for filtering data (format: YYYY-MM-DD)
         * @var string|null
         */
        public readonly ?string $endDate = null,
    ) {
        // Validate analysis type
        $validTypes = [
            'basic',
            'trend',
            'seasonal',
            'product',
            'customer',
            'comparative',
            'comprehensive'
        ];

        if (!in_array($this->analysisType, $validTypes)) {
            throw new \InvalidArgumentException(
                "Invalid analysis type. Valid types are: " . implode(', ', $validTypes)
            );
        }

        // Validate date formats if provided
        if ($this->startDate !== null && \DateTime::createFromFormat('Y-m-d', $this->startDate) === false) {
            throw new \InvalidArgumentException(
                "Start date must be in YYYY-MM-DD format."
            );
        }

        if ($this->endDate !== null && \DateTime::createFromFormat('Y-m-d', $this->endDate) === false) {
            throw new \InvalidArgumentException(
                "End date must be in YYYY-MM-DD format."
            );
        }

        // Validate date range if both dates are provided
        if ($this->startDate !== null && $this->endDate !== null) {
            $start = new \DateTime($this->startDate);
            $end = new \DateTime($this->endDate);

            if ($start > $end) {
                throw new \InvalidArgumentException(
                    "Start date cannot be after end date."
                );
            }
        }

        // Validate that the data path is not empty
        if (empty($this->reportPath)) {
            throw new \InvalidArgumentException(
                "Data path cannot be empty."
            );
        }
    }
}
