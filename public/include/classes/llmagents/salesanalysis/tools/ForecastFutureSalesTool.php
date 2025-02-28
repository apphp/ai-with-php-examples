<?php

declare(strict_types=1);

namespace app\public\include\classes\llmagents\salesanalysis\tools;

use LLM\Agents\Tool\PhpTool;

/**
 * @extends PhpTool<ForecastFutureSalesInput>
 */
final class ForecastFutureSalesTool extends PhpTool
{
    public const NAME = 'forecast_future_sales';

    public function __construct()
    {
        parent::__construct(
            name: self::NAME,
            inputSchema: ForecastFutureSalesInput::class,
            description: 'This tool forecasts future sales based on historical data using various forecasting models.',
        );
    }

    public function execute(object $input): string
    {
        // Validate input data path
        if (!\file_exists(APP_PATH . $input->reportPath)) {
            return \json_encode([
                'success' => false,
                'error' => 'Sales data file not found',
                'message' => "The file at path '" . APP_PATH . $input->reportPath . "' does not exist.",
            ]);
        }

        // Start measuring execution time
        $startTime = \microtime(true);

        // Load and parse sales data
        $salesData = $this->loadSalesData(APP_PATH . $input->reportPath);
        if (empty($salesData)) {
            return \json_encode([
                'success' => false,
                'error' => 'Invalid sales data',
                'message' => 'The sales data file could not be parsed or contains no data.',
            ]);
        }

        // Organize data by time periods
        $timeSeriesData = $this->organizeTimeSeriesData($salesData, $input->timeUnit);

        if (empty($timeSeriesData)) {
            return \json_encode([
                'success' => false,
                'error' => 'Insufficient data',
                'message' => 'Not enough time series data points for forecasting.',
            ]);
        }

        // Perform forecast based on the forecast method
        $forecastResults = $this->performForecast(
            $timeSeriesData,
            $input->forecastMethod,
            $input->forecastPeriods,
            $input->confidence,
            $input->seasonality
        );

        $endTime = \microtime(true);
        $processingTime = \round(($endTime - $startTime) * 1000, 2);

        return \json_encode([
            'success' => true,
            'processing_time_ms' => $processingTime,
            'forecast_method' => $input->forecastMethod,
            'forecast_periods' => $input->forecastPeriods,
            'time_unit' => $input->timeUnit,
            'historical_data_points' => \count($timeSeriesData),
            'results' => $forecastResults,
        ]);
    }

    /**
     * Load and parse sales data from the specified file
     */
    private function loadSalesData(string $reportPath): array
    {
        $extension = \pathinfo($reportPath, PATHINFO_EXTENSION);

        if ($extension === 'csv') {
            return $this->parseCSV($reportPath);
        }

        if ($extension === 'json') {
            $content = \file_get_contents($reportPath);
            return \json_decode($content, true) ?? [];
        }

        return [];
    }

    /**
     * Parse CSV file into an associative array
     */
    private function parseCSV(string $filePath): array
    {
        $data = [];
        if (($handle = \fopen($filePath, "r")) !== false) {
            $headers = \fgetcsv($handle, 1000, ",");
            while (($row = \fgetcsv($handle, 1000, ",")) !== false) {
                if (\count($headers) === \count($row)) {
                    $data[] = \array_combine($headers, $row);
                }
            }
            \fclose($handle);
        }
        return $data;
    }

    /**
     * Organize sales data into time series by specified time unit
     */
    private function organizeTimeSeriesData(array $data, string $timeUnit): array
    {
        $timeSeriesData = [];

        foreach ($data as $item) {
            $date = $item['date'] ?? '';
            if (!$date) continue;

            $amount = (float)($item['amount'] ?? 0);
            $timestamp = \strtotime($date);

            // Format the date based on the time unit
            switch ($timeUnit) {
                case 'day':
                    $period = \date('Y-m-d', $timestamp);
                    break;
                case 'week':
                    $period = \date('Y-W', $timestamp);
                    break;
                case 'month':
                    $period = \date('Y-m', $timestamp);
                    break;
                case 'quarter':
                    $quarter = \ceil(\date('n', $timestamp) / 3);
                    $period = \date('Y', $timestamp) . '-Q' . $quarter;
                    break;
                case 'year':
                    $period = \date('Y', $timestamp);
                    break;
                default:
                    $period = \date('Y-m', $timestamp);
            }

            if (!isset($timeSeriesData[$period])) {
                $timeSeriesData[$period] = 0;
            }

            $timeSeriesData[$period] += $amount;
        }

        // Sort time series data by date
        \ksort($timeSeriesData);

        return $timeSeriesData;
    }

    /**
     * Perform forecast using the specified method
     */
    private function performForecast(
        array $timeSeriesData,
        string $forecastMethod,
        int $forecastPeriods,
        float $confidence,
        ?int $seasonality
    ): array {
        switch ($forecastMethod) {
            case 'moving_average':
                return $this->forecastMovingAverage($timeSeriesData, $forecastPeriods);
            case 'exponential_smoothing':
                return $this->forecastExponentialSmoothing($timeSeriesData, $forecastPeriods, $confidence);
            case 'seasonal':
                return $this->forecastSeasonal($timeSeriesData, $forecastPeriods, $seasonality);
            case 'linear_regression':
                return $this->forecastLinearRegression($timeSeriesData, $forecastPeriods, $confidence);
            case 'arima':
                return $this->forecastARIMA($timeSeriesData, $forecastPeriods, $confidence, $seasonality);
            default:
                return $this->forecastSimpleAverage($timeSeriesData, $forecastPeriods);
        }
    }

    /**
     * Forecast using simple average method
     */
    private function forecastSimpleAverage(array $timeSeriesData, int $forecastPeriods): array
    {
        $values = \array_values($timeSeriesData);
        $periods = \array_keys($timeSeriesData);
        $count = \count($values);

        // Calculate the average
        $average = \array_sum($values) / $count;

        // Generate forecasts
        $forecasts = [];
        $lastPeriod = \end($periods);

        for ($i = 1; $i <= $forecastPeriods; $i++) {
            $nextPeriod = $this->getNextPeriod($lastPeriod, $i);
            $forecasts[] = [
                'period' => $nextPeriod,
                'forecast' => $average,
                'method' => 'simple_average',
            ];
        }

        return [
            'forecast_values' => $forecasts,
            'model_accuracy' => [
                'mape' => $this->calculateMAPE($values, \array_fill(0, $count, $average)),
                'rmse' => $this->calculateRMSE($values, \array_fill(0, $count, $average)),
            ],
            'historical_data' => $this->formatHistoricalData($timeSeriesData),
        ];
    }

    /**
     * Forecast using moving average method
     */
    private function forecastMovingAverage(array $timeSeriesData, int $forecastPeriods): array
    {
        $values = \array_values($timeSeriesData);
        $periods = \array_keys($timeSeriesData);
        $count = \count($values);

        // Determine the window size (number of periods to include in moving average)
        $windowSize = \min(6, \max(2, (int)($count / 4)));

        // Generate forecasts
        $forecasts = [];
        $lastPeriod = \end($periods);
        $windowValues = \array_slice($values, -$windowSize);
        $movingAverage = \array_sum($windowValues) / \count($windowValues);

        for ($i = 1; $i <= $forecastPeriods; $i++) {
            $nextPeriod = $this->getNextPeriod($lastPeriod, $i);
            $forecasts[] = [
                'period' => $nextPeriod,
                'forecast' => $movingAverage,
                'method' => 'moving_average',
                'window_size' => $windowSize,
            ];
        }

        // Calculate historical moving averages for accuracy
        $historicalForecasts = [];
        for ($i = $windowSize; $i < $count; $i++) {
            $windowAvg = \array_sum(\array_slice($values, $i - $windowSize, $windowSize)) / $windowSize;
            $historicalForecasts[] = $windowAvg;
        }

        // Calculate accuracy metrics
        $actualValues = \array_slice($values, $windowSize);

        return [
            'forecast_values' => $forecasts,
            'model_accuracy' => [
                'mape' => $this->calculateMAPE($actualValues, $historicalForecasts),
                'rmse' => $this->calculateRMSE($actualValues, $historicalForecasts),
                'window_size' => $windowSize,
            ],
            'historical_data' => $this->formatHistoricalData($timeSeriesData),
        ];
    }

    /**
     * Forecast using exponential smoothing method
     */
    private function forecastExponentialSmoothing(
        array $timeSeriesData,
        int $forecastPeriods,
        float $confidence
    ): array {
        $values = \array_values($timeSeriesData);
        $periods = \array_keys($timeSeriesData);
        $count = \count($values);

        // Determine alpha parameter (smoothing factor)
        $alpha = 0.3; // Default value (can be optimized based on data)

        // Calculate exponentially smoothed values
        $smoothed = [$values[0]];
        for ($i = 1; $i < $count; $i++) {
            $smoothed[] = $alpha * $values[$i] + (1 - $alpha) * $smoothed[$i - 1];
        }

        // Use the last smoothed value for forecasting
        $forecast = \end($smoothed);

        // Calculate trend
        $trend = ($smoothed[$count - 1] - $smoothed[$count - 2]) / 2;

        // Calculate standard deviation for confidence intervals
        $errors = [];
        for ($i = 0; $i < $count - 1; $i++) {
            $errors[] = $values[$i + 1] - $smoothed[$i];
        }

        $stdDev = $this->calculateStandardDeviation($errors);
        $zScore = $this->getZScoreForConfidence($confidence);

        // Generate forecasts
        $forecasts = [];
        $lastPeriod = \end($periods);

        for ($i = 1; $i <= $forecastPeriods; $i++) {
            $nextPeriod = $this->getNextPeriod($lastPeriod, $i);
            $forecastValue = $forecast + $trend * $i;
            $confInterval = $stdDev * $zScore * \sqrt($i);

            $forecasts[] = [
                'period' => $nextPeriod,
                'forecast' => \max(0, $forecastValue),
                'lower_bound' => \max(0, $forecastValue - $confInterval),
                'upper_bound' => $forecastValue + $confInterval,
                'method' => 'exponential_smoothing',
                'alpha' => $alpha,
            ];
        }

        return [
            'forecast_values' => $forecasts,
            'model_accuracy' => [
                'mape' => $this->calculateMAPE(\array_slice($values, 1), \array_slice($smoothed, 0, -1)),
                'rmse' => $this->calculateRMSE(\array_slice($values, 1), \array_slice($smoothed, 0, -1)),
                'alpha' => $alpha,
            ],
            'historical_data' => $this->formatHistoricalData($timeSeriesData),
            'smoothed_values' => \array_map(function ($period, $actual, $smooth) {
                return [
                    'period' => $period,
                    'actual' => $actual,
                    'smoothed' => $smooth,
                ];
            }, $periods, $values, $smoothed),
        ];
    }

    /**
     * Forecast using seasonal decomposition
     */
    private function forecastSeasonal(
        array $timeSeriesData,
        int $forecastPeriods,
        ?int $seasonality
    ): array {
        $values = \array_values($timeSeriesData);
        $periods = \array_keys($timeSeriesData);
        $count = \count($values);

        // Determine seasonality if not provided
        if ($seasonality === null) {
            // Default to 12 for monthly data, 4 for quarterly, etc.
            $firstPeriod = \reset($periods);
            if (\strpos($firstPeriod, '-m-') !== false || \preg_match('/\d{4}-\d{2}/', $firstPeriod)) {
                $seasonality = 12; // Monthly data
            } elseif (\strpos($firstPeriod, '-Q') !== false) {
                $seasonality = 4; // Quarterly data
            } elseif (\preg_match('/\d{4}-W\d{2}/', $firstPeriod)) {
                $seasonality = 52; // Weekly data
            } else {
                $seasonality = 4; // Default seasonality
            }
        }

        // Need at least 2 seasons of data
        if ($count < $seasonality * 2) {
            // Fall back to exponential smoothing if not enough seasonal data
            return $this->forecastExponentialSmoothing($timeSeriesData, $forecastPeriods, 0.95);
        }

        // Calculate seasonal indices
        $seasonalIndices = $this->calculateSeasonalIndices($values, $seasonality);

        // Deseasonalize the data
        $deseasonalized = [];
        for ($i = 0; $i < $count; $i++) {
            $seasonIndex = $i % $seasonality;
            $deseasonalized[] = $values[$i] / $seasonalIndices[$seasonIndex];
        }

        // Fit a trend line to the deseasonalized data
        $trend = $this->fitLinearTrend($deseasonalized);

        // Generate forecasts
        $forecasts = [];
        $lastPeriod = \end($periods);

        for ($i = 1; $i <= $forecastPeriods; $i++) {
            $nextPeriod = $this->getNextPeriod($lastPeriod, $i);
            $seasonIndex = ($count + $i - 1) % $seasonality;

            // Forecast = Trend * Seasonal Factor
            $trendValue = $trend['intercept'] + $trend['slope'] * ($count + $i - 1);
            $forecastValue = $trendValue * $seasonalIndices[$seasonIndex];

            $forecasts[] = [
                'period' => $nextPeriod,
                'forecast' => \max(0, $forecastValue),
                'trend_component' => $trendValue,
                'seasonal_factor' => $seasonalIndices[$seasonIndex],
                'method' => 'seasonal_decomposition',
                'seasonality' => $seasonality,
            ];
        }

        // Calculate model fit
        $fittedValues = [];
        for ($i = 0; $i < $count; $i++) {
            $seasonIndex = $i % $seasonality;
            $trendValue = $trend['intercept'] + $trend['slope'] * $i;
            $fittedValues[] = $trendValue * $seasonalIndices[$seasonIndex];
        }

        return [
            'forecast_values' => $forecasts,
            'model_accuracy' => [
                'mape' => $this->calculateMAPE($values, $fittedValues),
                'rmse' => $this->calculateRMSE($values, $fittedValues),
                'seasonality' => $seasonality,
            ],
            'historical_data' => $this->formatHistoricalData($timeSeriesData),
            'seasonal_indices' => \array_map(function ($index, $value) {
                return [
                    'season' => $index + 1,
                    'index' => $value,
                ];
            }, \array_keys($seasonalIndices), $seasonalIndices),
        ];
    }

    /**
     * Forecast using linear regression
     */
    private function forecastLinearRegression(
        array $timeSeriesData,
        int $forecastPeriods,
        float $confidence
    ): array {
        $values = \array_values($timeSeriesData);
        $periods = \array_keys($timeSeriesData);
        $count = \count($values);

        // Fit a linear trend
        $trend = $this->fitLinearTrend($values);

        // Calculate residuals and standard error
        $residuals = [];
        $fittedValues = [];

        for ($i = 0; $i < $count; $i++) {
            $fitted = $trend['intercept'] + $trend['slope'] * $i;
            $fittedValues[] = $fitted;
            $residuals[] = $values[$i] - $fitted;
        }

        $stdError = $this->calculateStandardDeviation($residuals);
        $zScore = $this->getZScoreForConfidence($confidence);

        // Calculate prediction intervals
        $sumX = 0;
        $sumX2 = 0;

        for ($i = 0; $i < $count; $i++) {
            $sumX += $i;
            $sumX2 += $i * $i;
        }

        $meanX = $sumX / $count;
        $denominator = $sumX2 - $count * $meanX * $meanX;

        // Generate forecasts
        $forecasts = [];
        $lastPeriod = \end($periods);

        for ($i = 1; $i <= $forecastPeriods; $i++) {
            $nextPeriod = $this->getNextPeriod($lastPeriod, $i);
            $xValue = $count + $i - 1;
            $forecastValue = $trend['intercept'] + $trend['slope'] * $xValue;

            // Calculate prediction interval factor
            $predictionFactor = \sqrt(1 + 1/$count + \pow($xValue - $meanX, 2) / $denominator);
            $interval = $zScore * $stdError * $predictionFactor;

            $forecasts[] = [
                'period' => $nextPeriod,
                'forecast' => \max(0, $forecastValue),
                'lower_bound' => \max(0, $forecastValue - $interval),
                'upper_bound' => $forecastValue + $interval,
                'method' => 'linear_regression',
            ];
        }

        return [
            'forecast_values' => $forecasts,
            'model_accuracy' => [
                'mape' => $this->calculateMAPE($values, $fittedValues),
                'rmse' => $this->calculateRMSE($values, $fittedValues),
                'r_squared' => $trend['r_squared'],
            ],
            'trend' => [
                'intercept' => $trend['intercept'],
                'slope' => $trend['slope'],
                'equation' => "y = {$trend['intercept']} + {$trend['slope']}*x",
            ],
            'historical_data' => $this->formatHistoricalData($timeSeriesData),
        ];
    }

    /**
     * Forecast using ARIMA (Autoregressive Integrated Moving Average)
     * This is a simplified implementation as full ARIMA requires complex calculations
     */
    private function forecastARIMA(
        array $timeSeriesData,
        int $forecastPeriods,
        float $confidence,
        ?int $seasonality
    ): array {
        $values = \array_values($timeSeriesData);
        $periods = \array_keys($timeSeriesData);
        $count = \count($values);

        // Parameters for ARIMA
        $p = 1; // Autoregressive order
        $d = 1; // Differencing order
        $q = 1; // Moving average order

        // For simplicity, we'll implement a partial ARIMA model
        // Focus on first differencing and autoregression

        // Perform differencing
        $differenced = [];
        for ($i = 1; $i < $count; $i++) {
            $differenced[] = $values[$i] - $values[$i - 1];
        }

        // Fit autoregressive model to differenced data
        $arCoefficients = $this->fitAutoregressive($differenced, $p);

        // Calculate residuals and standard error
        $fitted = [$values[0]];
        $residuals = [];

        for ($i = 1; $i < $count; $i++) {
            $prediction = $values[$i - 1];

            // Add AR component
            for ($j = 0; $j < \min($p, $i); $j++) {
                if ($i - $j - 1 >= 0 && $i - $j - 2 >= 0) {
                    $diff = $values[$i - $j - 1] - $values[$i - $j - 2];
                    $prediction += $arCoefficients[$j] * $diff;
                }
            }

            $fitted[] = $prediction;
            $residuals[] = $values[$i] - $prediction;
        }

        $stdError = $this->calculateStandardDeviation($residuals);
        $zScore = $this->getZScoreForConfidence($confidence);

        // Generate forecasts
        $forecasts = [];
        $lastPeriod = \end($periods);
        $forecastValues = $values;

        for ($i = 1; $i <= $forecastPeriods; $i++) {
            $nextPeriod = $this->getNextPeriod($lastPeriod, $i);
            $lastIdx = \count($forecastValues) - 1;

            $prediction = $forecastValues[$lastIdx];

            // Add AR component
            for ($j = 0; $j < $p; $j++) {
                if ($lastIdx - $j >= 0 && $lastIdx - $j - 1 >= 0) {
                    $diff = $forecastValues[$lastIdx - $j] - $forecastValues[$lastIdx - $j - 1];
                    $prediction += $arCoefficients[$j] * $diff;
                }
            }

            // Apply seasonality adjustment if applicable
            if ($seasonality !== null && $lastIdx >= $seasonality) {
                $seasonalFactor = $forecastValues[$lastIdx] / $forecastValues[$lastIdx - $seasonality];
                $prediction *= $seasonalFactor;
            }

            $interval = $zScore * $stdError * \sqrt($i);
            $forecastValues[] = $prediction;

            $forecasts[] = [
                'period' => $nextPeriod,
                'forecast' => \max(0, $prediction),
                'lower_bound' => \max(0, $prediction - $interval),
                'upper_bound' => $prediction + $interval,
                'method' => 'arima',
                'parameters' => "p=$p,d=$d,q=$q" . ($seasonality !== null ? ",s=$seasonality" : ""),
            ];
        }

        return [
            'forecast_values' => $forecasts,
            'model_accuracy' => [
                'mape' => $this->calculateMAPE(\array_slice($values, 1), \array_slice($fitted, 0, $count - 1)),
                'rmse' => $this->calculateRMSE(\array_slice($values, 1), \array_slice($fitted, 0, $count - 1)),
                'parameters' => "p=$p,d=$d,q=$q" . ($seasonality !== null ? ",s=$seasonality" : ""),
            ],
            'historical_data' => $this->formatHistoricalData($timeSeriesData),
        ];
    }

    /**
     * Fit autoregressive model of specified order
     */
    private function fitAutoregressive(array $data, int $order): array
    {
        $count = \count($data);
        if ($count <= $order) {
            return \array_fill(0, $order, 0);
        }

        // Simple implementation of Yule-Walker equations
        $coefficients = [];

        // Calculate autocorrelations
        $mean = \array_sum($data) / $count;
        $variance = 0;
        foreach ($data as $value) {
            $variance += \pow($value - $mean, 2);
        }
        $variance /= $count;

        if ($variance == 0) {
            return \array_fill(0, $order, 0);
        }

        $autocorr = [];
        for ($lag = 0; $lag <= $order; $lag++) {
            $sum = 0;
            for ($i = $lag; $i < $count; $i++) {
                $sum += ($data[$i] - $mean) * ($data[$i - $lag] - $mean);
            }
            $autocorr[$lag] = $sum / ($count * $variance);
        }

        // For simplicity, use direct calculation for small order
        if ($order == 1) {
            $coefficients[] = $autocorr[1] / $autocorr[0];
        } elseif ($order == 2) {
            $den = 1 - \pow($autocorr[1], 2);
            if ($den != 0) {
                $coefficients[] = $autocorr[1] * (1 - $autocorr[2]) / $den;
                $coefficients[] = ($autocorr[2] - \pow($autocorr[1], 2)) / $den;
            } else {
                $coefficients = [0, 0];
            }
        } else {
            // For higher orders, use a simple approximation
            for ($i = 0; $i < $order; $i++) {
                $coefficients[] = $autocorr[$i + 1] / $autocorr[0];
            }
        }

        return $coefficients;
    }

    /**
     * Calculate seasonal indices
     */
    private function calculateSeasonalIndices(array $values, int $seasonality): array
    {
        $count = \count($values);
        $seasons = \ceil($count / $seasonality);

        // Calculate seasonal averages
        $seasonalAvgs = \array_fill(0, $seasonality, 0);
        $seasonalCounts = \array_fill(0, $seasonality, 0);

        for ($i = 0; $i < $count; $i++) {
            $season = $i % $seasonality;
            $seasonalAvgs[$season] += $values[$i];
            $seasonalCounts[$season]++;
        }

        for ($i = 0; $i < $seasonality; $i++) {
            if ($seasonalCounts[$i] > 0) {
                $seasonalAvgs[$i] /= $seasonalCounts[$i];
            }
        }

        // Calculate the overall average
        $overallAvg = \array_sum($values) / $count;

        // Calculate seasonal indices
        $indices = [];
        for ($i = 0; $i < $seasonality; $i++) {
            $indices[$i] = $overallAvg > 0 ? $seasonalAvgs[$i] / $overallAvg : 1;
        }

        // Normalize indices to ensure they sum to seasonality
        $sumIndices = \array_sum($indices);
        if ($sumIndices > 0) {
            for ($i = 0; $i < $seasonality; $i++) {
                $indices[$i] = $indices[$i] * $seasonality / $sumIndices;
            }
        }

        return $indices;
    }

    /**
     * Fit linear trend to data
     */
    private function fitLinearTrend(array $data): array
    {
        $count = \count($data);
        if ($count <= 1) {
            return [
                'intercept' => $count === 1 ? $data[0] : 0,
                'slope' => 0,
                'r_squared' => 0,
            ];
        }

        $sumX = 0;
        $sumY = 0;
        $sumXY = 0;
        $sumX2 = 0;
        $sumY2 = 0;

        for ($i = 0; $i < $count; $i++) {
            $sumX += $i;
            $sumY += $data[$i];
            $sumXY += $i * $data[$i];
            $sumX2 += $i * $i;
            $sumY2 += $data[$i] * $data[$i];
        }

        $denominator = $count * $sumX2 - $sumX * $sumX;

        if ($denominator == 0) {
            return [
                'intercept' => $sumY / $count,
                'slope' => 0,
                'r_squared' => 0,
            ];
        }

        $slope = ($count * $sumXY - $sumX * $sumY) / $denominator;
        $intercept = ($sumY - $slope * $sumX) / $count;

        // Calculate R-squared
        $meanY = $sumY / $count;
        $totalSS = 0;
        $residualSS = 0;

        for ($i = 0; $i < $count; $i++) {
            $totalSS += \pow($data[$i] - $meanY, 2);
            $predicted = $intercept + $slope * $i;
            $residualSS += \pow($data[$i] - $predicted, 2);
        }

        $rSquared = $totalSS > 0 ? 1 - ($residualSS / $totalSS) : 0;

        return [
            'intercept' => $intercept,
            'slope' => $slope,
            'r_squared' => $rSquared,
        ];
    }

    /**
     * Calculate Mean Absolute Percentage Error
     */
    private function calculateMAPE(array $actual, array $forecast): float
    {
        $count = \count($actual);
        if ($count === 0) {
            return 0;
        }

        $sum = 0;
        $validPoints = 0;

        for ($i = 0; $i < $count; $i++) {
            if ($actual[$i] != 0) {
                $sum += \abs(($actual[$i] - $forecast[$i]) / $actual[$i]);
                $validPoints++;
            }
        }

        return $validPoints > 0 ? ($sum / $validPoints) * 100 : 0;
    }

    /**
     * Calculate Root Mean Square Error
     */
    private function calculateRMSE(array $actual, array $forecast): float
    {
        $count = \count($actual);
        if ($count === 0) {
            return 0;
        }

        $sumSquaredError = 0;

        for ($i = 0; $i < $count; $i++) {
            $sumSquaredError += \pow($actual[$i] - $forecast[$i], 2);
        }

        return \sqrt($sumSquaredError / $count);
    }

    /**
     * Calculate Standard Deviation
     */
    private function calculateStandardDeviation(array $values): float
    {
        $count = \count($values);
        if ($count <= 1) {
            return 0;
        }

        $mean = \array_sum($values) / $count;
        $variance = 0;

        foreach ($values as $value) {
            $variance += \pow($value - $mean, 2);
        }

        return \sqrt($variance / ($count - 1));
    }

    /**
     * Get Z-score for the given confidence level
     */
    private function getZScoreForConfidence(float $confidence): float
    {
        // Common Z-scores for typical confidence levels
        if ($confidence >= 0.99) {
            return 2.576; // 99% confidence
        } elseif ($confidence >= 0.95) {
            return 1.96; // 95% confidence
        } elseif ($confidence >= 0.90) {
            return 1.645; // 90% confidence
        } elseif ($confidence >= 0.80) {
            return 1.28; // 80% confidence
        } else {
            return 1.0; // Default for lower confidence
        }
    }

    /**
     * Get the next period based on the pattern of the last period
     */
    private function getNextPeriod(string $lastPeriod, int $increment): string
    {
        // Detect period format
        if (\preg_match('/^(\d{4})-(\d{2})$/', $lastPeriod, $matches)) {
            // Monthly format: YYYY-MM
            $year = (int)$matches[1];
            $month = (int)$matches[2];

            $month += $increment;
            while ($month > 12) {
                $month -= 12;
                $year++;
            }

            return \sprintf('%04d-%02d', $year, $month);
        } elseif (\preg_match('/^(\d{4})-Q(\d)$/', $lastPeriod, $matches)) {
            // Quarterly format: YYYY-Q#
            $year = (int)$matches[1];
            $quarter = (int)$matches[2];

            $quarter += $increment;
            while ($quarter > 4) {
                $quarter -= 4;
                $year++;
            }

            return \sprintf('%04d-Q%d', $year, $quarter);
        } elseif (\preg_match('/^(\d{4})-W(\d{2})$/', $lastPeriod, $matches)) {
            // Weekly format: YYYY-W##
            $year = (int)$matches[1];
            $week = (int)$matches[2];

            $week += $increment;
            // Approximation: 52 weeks per year
            while ($week > 52) {
                $week -= 52;
                $year++;
            }

            return \sprintf('%04d-W%02d', $year, $week);
        } elseif (\preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $lastPeriod, $matches)) {
            // Daily format: YYYY-MM-DD
            $timestamp = \strtotime($lastPeriod);
            if ($timestamp === false) {
                return $lastPeriod . '+' . $increment;
            }

            $nextTimestamp = \strtotime("+$increment days", $timestamp);
            return \date('Y-m-d', $nextTimestamp);
        } elseif (\preg_match('/^(\d{4})$/', $lastPeriod)) {
            // Yearly format: YYYY
            $year = (int)$lastPeriod;
            return (string)($year + $increment);
        } else {
            // Unknown format, just append the increment
            return $lastPeriod . '+' . $increment;
        }
    }

    /**
     * Format historical data for output
     */
    private function formatHistoricalData(array $timeSeriesData): array
    {
        $result = [];
        foreach ($timeSeriesData as $period => $value) {
            $result[] = [
                'period' => $period,
                'value' => $value,
            ];
        }
        return $result;
    }
}

