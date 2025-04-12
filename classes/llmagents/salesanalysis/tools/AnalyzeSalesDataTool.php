<?php

declare(strict_types=1);

namespace app\classes\llmagents\salesanalysis\tools;

use LLM\Agents\Tool\PhpTool;

/**
 * @extends PhpTool<AnalyzeSalesDataInput>
 */
final class AnalyzeSalesDataTool extends PhpTool {
    public const NAME = 'analyze_sales_data';

    public function __construct() {
        parent::__construct(
            name: self::NAME,
            inputSchema: AnalyzeSalesDataInput::class,
            description: 'This tool analyzes sales data to identify trends, patterns, and key insights that can help improve business performance.',
        );
    }

    public function execute(object $input): string {
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

        // Filter data by the requested time period if provided
        if (!empty($input->startDate) && !empty($input->endDate)) {
            $salesData = $this->filterDataByTimePeriod($salesData, $input->startDate, $input->endDate);
        }

        // Perform analysis based on the analysis type
        $analysisResults = $this->performAnalysis($salesData, $input->analysisType);

        $endTime = \microtime(true);
        $processingTime = \round(($endTime - $startTime) * 1000, 2);

        return \json_encode([
            'success' => true,
            'processing_time_ms' => $processingTime,
            'analysis_type' => $input->analysisType,
            'data_points' => \count($salesData),
            'period' => [
                'start_date' => $input->startDate ?? 'all',
                'end_date' => $input->endDate ?? 'all',
            ],
            'results' => $analysisResults,
        ]);
    }

    /**
     * Load and parse sales data from the specified file
     */
    private function loadSalesData(string $reportPath): array {
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
    private function parseCSV(string $filePath): array {
        $data = [];
        if (($handle = \fopen($filePath, 'r')) !== false) {
            $headers = \fgetcsv($handle, 1000, ',');
            while (($row = \fgetcsv($handle, 1000, ',')) !== false) {
                if (\count($headers) === \count($row)) {
                    $data[] = \array_combine($headers, $row);
                }
            }
            \fclose($handle);
        }
        return $data;
    }

    /**
     * Filter sales data by the specified time period
     */
    private function filterDataByTimePeriod(array $salesData, string $startDate, string $endDate): array {
        $start = \strtotime($startDate);
        $end = \strtotime($endDate);

        return \array_filter($salesData, function ($item) use ($start, $end) {
            $date = \strtotime($item['date'] ?? '');
            return $date >= $start && $date <= $end;
        });
    }

    /**
     * Perform analysis based on the analysis type
     */
    private function performAnalysis(array $data, string $analysisType): array {
        switch ($analysisType) {
            case 'trend':
                return $this->analyzeTrends($data);
            case 'seasonal':
                return $this->analyzeSeasonality($data);
            case 'product':
                return $this->analyzeProductPerformance($data);
            case 'customer':
                return $this->analyzeCustomerBehavior($data);
            case 'comparative':
                return $this->performComparativeAnalysis($data);
            case 'comprehensive':
                return $this->performComprehensiveAnalysis($data);
            default:
                return $this->performBasicAnalysis($data);
        }
    }

    /**
     * Perform basic analysis of sales data
     */
    private function performBasicAnalysis(array $data): array {
        $totalSales = 0;
        $totalUnits = 0;
        $totalOrders = \count($data);
        $customers = [];
        $products = [];
        $monthlySales = [];

        foreach ($data as $item) {
            $amount = (float)($item['amount'] ?? 0);
            $units = (int)($item['quantity'] ?? 1);

            $totalSales += $amount;
            $totalUnits += $units;

            // Track unique customers
            $customerId = $item['customer_id'] ?? '';
            if ($customerId) {
                $customers[$customerId] = true;
            }

            // Track product sales
            $productId = $item['product_id'] ?? '';
            if ($productId) {
                if (!isset($products[$productId])) {
                    $products[$productId] = [
                        'product_id' => $productId,
                        'product_name' => $item['product_name'] ?? "Product $productId",
                        'total_sales' => 0,
                        'units_sold' => 0,
                    ];
                }
                $products[$productId]['total_sales'] += $amount;
                $products[$productId]['units_sold'] += $units;
            }

            // Track monthly sales
            $date = $item['date'] ?? '';
            if ($date) {
                $month = \date('Y-m', \strtotime($date));
                if (!isset($monthlySales[$month])) {
                    $monthlySales[$month] = 0;
                }
                $monthlySales[$month] += $amount;
            }
        }

        // Sort products by total sales
        \usort($products, function ($a, $b) {
            return $b['total_sales'] <=> $a['total_sales'];
        });

        // Get top 5 products
        $topProducts = \array_slice($products, 0, 5);

        // Convert monthly sales to sorted array
        $salesByMonth = [];
        foreach ($monthlySales as $month => $sales) {
            $salesByMonth[] = [
                'month' => $month,
                'sales' => $sales,
            ];
        }
        \usort($salesByMonth, function ($a, $b) {
            return \strtotime($a['month']) <=> \strtotime($b['month']);
        });

        return [
            'summary' => [
                'total_sales' => $totalSales,
                'total_orders' => $totalOrders,
                'total_units_sold' => $totalUnits,
                'unique_customers' => \count($customers),
                'average_order_value' => $totalOrders > 0 ? $totalSales / $totalOrders : 0,
                'average_units_per_order' => $totalOrders > 0 ? $totalUnits / $totalOrders : 0,
            ],
            'top_products' => $topProducts,
            'sales_by_month' => $salesByMonth,
        ];
    }

    /**
     * Analyze sales trends over time
     */
    private function analyzeTrends(array $data): array {
        $timeSeriesData = [];
        $cumulativeData = [];
        $growthData = [];
        $totalSales = 0;

        // Organize data by time periods
        foreach ($data as $item) {
            $date = $item['date'] ?? '';
            if (!$date) {
                continue;
            }

            $amount = (float)($item['amount'] ?? 0);
            $month = \date('Y-m', \strtotime($date));

            if (!isset($timeSeriesData[$month])) {
                $timeSeriesData[$month] = 0;
            }

            $timeSeriesData[$month] += $amount;
        }

        // Sort time series data by date
        \ksort($timeSeriesData);

        // Calculate cumulative sales and growth rates
        $previousSales = null;
        foreach ($timeSeriesData as $month => $sales) {
            $totalSales += $sales;

            $cumulativeData[$month] = $totalSales;

            if ($previousSales !== null && $previousSales > 0) {
                $growthRate = (($sales - $previousSales) / $previousSales) * 100;
                $growthData[$month] = \round($growthRate, 2);
            } else {
                $growthData[$month] = 0;
            }

            $previousSales = $sales;
        }

        // Convert to array format
        $timeSeries = [];
        $cumulative = [];
        $growth = [];

        foreach ($timeSeriesData as $month => $sales) {
            $timeSeries[] = ['period' => $month, 'sales' => $sales];
        }

        foreach ($cumulativeData as $month => $sales) {
            $cumulative[] = ['period' => $month, 'cumulative_sales' => $sales];
        }

        foreach ($growthData as $month => $rate) {
            $growth[] = ['period' => $month, 'growth_rate' => $rate];
        }

        // Calculate trend indicators
        $trendIndicators = $this->calculateTrendIndicators($timeSeriesData);

        return [
            'time_series' => $timeSeries,
            'cumulative_sales' => $cumulative,
            'growth_rates' => $growth,
            'trend_indicators' => $trendIndicators,
        ];
    }

    /**
     * Calculate trend indicators from time series data
     */
    private function calculateTrendIndicators(array $timeSeriesData): array {
        $values = \array_values($timeSeriesData);
        $periods = \array_keys($timeSeriesData);
        $count = \count($values);

        if ($count < 2) {
            return [
                'direction' => 'insufficient_data',
                'average_growth' => 0,
                'consistency' => 0,
            ];
        }

        // Calculate average growth rate
        $totalGrowth = 0;
        $growthRates = [];

        for ($i = 1; $i < $count; $i++) {
            if ($values[$i - 1] > 0) {
                $growthRate = (($values[$i] - $values[$i - 1]) / $values[$i - 1]) * 100;
                $growthRates[] = $growthRate;
                $totalGrowth += $growthRate;
            }
        }

        $averageGrowth = \count($growthRates) > 0 ? $totalGrowth / \count($growthRates) : 0;

        // Determine trend direction
        $direction = 'stable';
        if ($averageGrowth > 5) {
            $direction = 'strong_upward';
        } elseif ($averageGrowth > 1) {
            $direction = 'upward';
        } elseif ($averageGrowth < -5) {
            $direction = 'strong_downward';
        } elseif ($averageGrowth < -1) {
            $direction = 'downward';
        }

        // Calculate trend consistency (standard deviation of growth rates)
        $variance = 0;

        if (\count($growthRates) > 1) {
            foreach ($growthRates as $rate) {
                $variance += \pow($rate - $averageGrowth, 2);
            }
            $variance /= \count($growthRates);
        }

        $stdDev = \sqrt($variance);
        $consistency = 100 - \min(100, $stdDev);

        // Linear regression for forecasting
        $xValues = \range(0, $count - 1);
        $sumX = \array_sum($xValues);
        $sumY = \array_sum($values);
        $sumXY = 0;
        $sumX2 = 0;

        for ($i = 0; $i < $count; $i++) {
            $sumXY += $xValues[$i] * $values[$i];
            $sumX2 += $xValues[$i] * $xValues[$i];
        }

        $slope = 0;
        if (($count * $sumX2 - $sumX * $sumX) != 0) {
            $slope = ($count * $sumXY - $sumX * $sumY) / ($count * $sumX2 - $sumX * $sumX);
        }

        $intercept = ($sumY - $slope * $sumX) / $count;

        // Forecast next 3 periods
        $forecast = [];
        for ($i = 1; $i <= 3; $i++) {
            $nextX = $count - 1 + $i;
            $predictedValue = $intercept + $slope * $nextX;
            $nextPeriodIdx = \strtotime("+{$i} month", \strtotime(\end($periods)));
            $nextPeriod = \date('Y-m', $nextPeriodIdx);

            $forecast[] = [
                'period' => $nextPeriod,
                'forecasted_sales' => \max(0, $predictedValue),
            ];
        }

        return [
            'direction' => $direction,
            'average_growth' => \round($averageGrowth, 2),
            'consistency' => \round($consistency, 2),
            'forecast' => $forecast,
        ];
    }

    /**
     * Analyze seasonality in sales data
     */
    private function analyzeSeasonality(array $data): array {
        $monthlySales = [];
        $quarterlyData = [];
        $weekdayData = [];
        $monthlyAgg = [];

        foreach ($data as $item) {
            $date = $item['date'] ?? '';
            if (!$date) {
                continue;
            }

            $timestamp = \strtotime($date);
            $amount = (float)($item['amount'] ?? 0);

            // Monthly data
            $yearMonth = \date('Y-m', $timestamp);
            $month = \date('m', $timestamp);

            if (!isset($monthlySales[$yearMonth])) {
                $monthlySales[$yearMonth] = 0;
            }
            $monthlySales[$yearMonth] += $amount;

            // Monthly aggregation
            if (!isset($monthlyAgg[$month])) {
                $monthlyAgg[$month] = ['total' => 0, 'count' => 0];
            }
            $monthlyAgg[$month]['total'] += $amount;
            $monthlyAgg[$month]['count']++;

            // Quarterly data
            $quarter = \ceil((int)$month / 3);
            $yearQuarter = \date('Y', $timestamp) . '-Q' . $quarter;

            if (!isset($quarterlyData[$yearQuarter])) {
                $quarterlyData[$yearQuarter] = 0;
            }
            $quarterlyData[$yearQuarter] += $amount;

            // Weekday data
            $weekday = \date('N', $timestamp); // 1 (Monday) to 7 (Sunday)

            if (!isset($weekdayData[$weekday])) {
                $weekdayData[$weekday] = ['total' => 0, 'count' => 0];
            }
            $weekdayData[$weekday]['total'] += $amount;
            $weekdayData[$weekday]['count']++;
        }

        // Calculate monthly averages
        $monthlyAvg = [];
        foreach ($monthlyAgg as $month => $data) {
            $monthlyAvg[$month] = $data['count'] > 0 ? $data['total'] / $data['count'] : 0;
        }

        // Calculate weekday averages
        $weekdayAvg = [];
        $weekdayNames = [
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            7 => 'Sunday',
        ];

        foreach ($weekdayData as $day => $data) {
            $weekdayAvg[$day] = [
                'day' => $weekdayNames[$day],
                'average_sales' => $data['count'] > 0 ? $data['total'] / $data['count'] : 0,
            ];
        }

        // Sort by day of week
        \ksort($weekdayAvg);
        $weekdayAvgArray = \array_values($weekdayAvg);

        // Determine seasonality patterns
        $monthlyPatterns = $this->identifySeasonalPatterns($monthlyAvg);

        return [
            'monthly_patterns' => $monthlyPatterns,
            'monthly_sales' => \array_map(function ($month, $sales) {
                return ['month' => $month, 'sales' => $sales];
            }, \array_keys($monthlySales), \array_values($monthlySales)),
            'quarterly_sales' => \array_map(function ($quarter, $sales) {
                return ['quarter' => $quarter, 'sales' => $sales];
            }, \array_keys($quarterlyData), \array_values($quarterlyData)),
            'weekday_analysis' => $weekdayAvgArray,
        ];
    }

    /**
     * Identify seasonal patterns in monthly data
     */
    private function identifySeasonalPatterns(array $monthlyAvg): array {
        \ksort($monthlyAvg);

        $monthNames = [
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December',
        ];

        $monthlyPatternData = [];
        $totalSales = \array_sum($monthlyAvg);

        foreach ($monthlyAvg as $month => $sales) {
            $percentage = $totalSales > 0 ? ($sales / $totalSales) * 100 : 0;
            $monthlyPatternData[] = [
                'month' => $monthNames[$month] ?? $month,
                'average_sales' => $sales,
                'percentage_of_annual' => \round($percentage, 2),
            ];
        }

        // Identify peak and low seasons
        $avgMonthSales = $totalSales > 0 ? $totalSales / \count($monthlyAvg) : 0;

        $peakMonths = [];
        $lowMonths = [];

        foreach ($monthlyPatternData as $data) {
            if ($data['average_sales'] > $avgMonthSales * 1.15) {
                $peakMonths[] = $data['month'];
            } elseif ($data['average_sales'] < $avgMonthSales * 0.85) {
                $lowMonths[] = $data['month'];
            }
        }

        // Determine seasonality strength
        $variance = 0;
        foreach ($monthlyAvg as $sales) {
            $variance += \pow($sales - $avgMonthSales, 2);
        }
        $variance /= (\count($monthlyAvg) ?: 1);
        $stdDev = \sqrt($variance);

        $seasonalityStrength = $avgMonthSales > 0 ? ($stdDev / $avgMonthSales) * 100 : 0;
        $seasonalityCategory = 'low';

        if ($seasonalityStrength > 30) {
            $seasonalityCategory = 'high';
        } elseif ($seasonalityStrength > 15) {
            $seasonalityCategory = 'medium';
        }

        return [
            'monthly_breakdown' => $monthlyPatternData,
            'peak_months' => $peakMonths,
            'low_months' => $lowMonths,
            'seasonality_strength' => \round($seasonalityStrength, 2),
            'seasonality_category' => $seasonalityCategory,
        ];
    }

    /**
     * Analyze product performance
     */
    private function analyzeProductPerformance(array $data): array {
        $products = [];
        $categories = [];
        $totalSales = 0;

        foreach ($data as $item) {
            $productId = $item['product_id'] ?? '';
            if (empty($productId)) {
                continue;
            }

            $amount = (float)($item['amount'] ?? 0);
            $units = (int)($item['quantity'] ?? 1);
            $category = $item['category'] ?? 'Uncategorized';

            $totalSales += $amount;

            // Track product data
            if (!isset($products[$productId])) {
                $products[$productId] = [
                    'product_id' => $productId,
                    'product_name' => $item['product_name'] ?? "Product $productId",
                    'category' => $category,
                    'total_sales' => 0,
                    'units_sold' => 0,
                    'orders' => 0,
                    'revenue_per_unit' => 0,
                ];
            }

            $products[$productId]['total_sales'] += $amount;
            $products[$productId]['units_sold'] += $units;
            $products[$productId]['orders']++;

            // Track category data
            if (!isset($categories[$category])) {
                $categories[$category] = [
                    'category' => $category,
                    'total_sales' => 0,
                    'units_sold' => 0,
                    'product_count' => 0,
                    'products' => [],
                ];
            }

            $categories[$category]['total_sales'] += $amount;
            $categories[$category]['units_sold'] += $units;

            if (!\in_array($productId, $categories[$category]['products'])) {
                $categories[$category]['products'][] = $productId;
                $categories[$category]['product_count']++;
            }
        }

        // Calculate derived metrics
        foreach ($products as &$product) {
            $product['revenue_per_unit'] = $product['units_sold'] > 0 ?
                $product['total_sales'] / $product['units_sold'] : 0;

            $product['average_order_value'] = $product['orders'] > 0 ?
                $product['total_sales'] / $product['orders'] : 0;

            $product['sales_percentage'] = $totalSales > 0 ?
                ($product['total_sales'] / $totalSales) * 100 : 0;
        }

        // Remove product IDs from categories
        foreach ($categories as &$category) {
            unset($category['products']);
        }

        // Sort products by sales and get top performers
        \usort($products, function ($a, $b) {
            return $b['total_sales'] <=> $a['total_sales'];
        });

        $topProducts = \array_slice($products, 0, 10);
        $productCount = \count($products);

        // Calculate pareto analysis (80/20 rule)
        $paretoAnalysis = $this->performParetoAnalysis($products);

        // Sort categories by sales
        \usort($categories, function ($a, $b) {
            return $b['total_sales'] <=> $a['total_sales'];
        });

        $categoryArray = \array_values($categories);

        return [
            'top_products' => $topProducts,
            'product_count' => $productCount,
            'pareto_analysis' => $paretoAnalysis,
            'category_analysis' => $categoryArray,
        ];
    }

    /**
     * Perform Pareto analysis (80/20 rule) on product sales
     */
    private function performParetoAnalysis(array $products): array {
        $totalSales = 0;
        foreach ($products as $product) {
            $totalSales += $product['total_sales'];
        }

        if ($totalSales == 0 || empty($products)) {
            return [
                'pareto_principle_applies' => false,
                'products_for_80_percent' => 0,
                'products_percentage' => 0,
            ];
        }

        $cumulativeSales = 0;
        $productsFor80Percent = 0;

        foreach ($products as $product) {
            $cumulativeSales += $product['total_sales'];
            $productsFor80Percent++;

            if ($cumulativeSales >= 0.8 * $totalSales) {
                break;
            }
        }

        $productPercentage = ($productsFor80Percent / \count($products)) * 100;
        $paretoApplies = $productPercentage <= 30; // If 30% or fewer products generate 80% of sales

        return [
            'pareto_principle_applies' => $paretoApplies,
            'products_for_80_percent' => $productsFor80Percent,
            'products_percentage' => \round($productPercentage, 2),
            'insight' => $paretoApplies ?
                "The Pareto principle (80/20 rule) applies to your product sales. Just {$productsFor80Percent} products ({$productPercentage}% of your catalog) generate 80% of your revenue." :
                'Your sales are more evenly distributed across your product catalog than the typical 80/20 rule would suggest.',
        ];
    }

    /**
     * Analyze customer behavior
     */
    private function analyzeCustomerBehavior(array $data): array {
        $customers = [];
        $segments = [
            'new' => ['count' => 0, 'revenue' => 0],
            'returning' => ['count' => 0, 'revenue' => 0],
            'inactive' => ['count' => 0, 'last_active' => null],
        ];

        $firstPurchaseDates = [];
        $lastPurchaseDates = [];

        // First pass - get first and last purchase dates
        foreach ($data as $item) {
            $customerId = $item['customer_id'] ?? '';
            if (empty($customerId)) {
                continue;
            }

            $date = $item['date'] ?? '';
            if (empty($date)) {
                continue;
            }

            $timestamp = \strtotime($date);

            if (!isset($firstPurchaseDates[$customerId]) || $timestamp < \strtotime($firstPurchaseDates[$customerId])) {
                $firstPurchaseDates[$customerId] = $date;
            }

            if (!isset($lastPurchaseDates[$customerId]) || $timestamp > \strtotime($lastPurchaseDates[$customerId])) {
                $lastPurchaseDates[$customerId] = $date;
            }
        }

        // Second pass - analyze customer data
        foreach ($data as $item) {
            $customerId = $item['customer_id'] ?? '';
            if (empty($customerId)) {
                continue;
            }

            $amount = (float)($item['amount'] ?? 0);
            $date = $item['date'] ?? '';

            if (!isset($customers[$customerId])) {
                $customers[$customerId] = [
                    'customer_id' => $customerId,
                    'customer_name' => $item['customer_name'] ?? "Customer $customerId",
                    'total_spend' => 0,
                    'order_count' => 0,
                    'first_purchase' => $firstPurchaseDates[$customerId] ?? '',
                    'last_purchase' => $lastPurchaseDates[$customerId] ?? '',
                    'products_purchased' => [],
                    'average_order_value' => 0,
                    'purchase_frequency' => 0,
                    'customer_value' => 0,
                ];
            }

            $customers[$customerId]['total_spend'] += $amount;
            $customers[$customerId]['order_count']++;

            $productId = $item['product_id'] ?? '';
            if ($productId && !\in_array($productId, $customers[$customerId]['products_purchased'])) {
                $customers[$customerId]['products_purchased'][] = $productId;
            }
        }

        // Calculate derived metrics and segment customers
        $now = \time();
        $totalCustomers = \count($customers);

        foreach ($customers as $id => &$customer) {
            // Calculate metrics
            $customer['average_order_value'] = $customer['order_count'] > 0 ?
                $customer['total_spend'] / $customer['order_count'] : 0;

            $customer['unique_products'] = \count($customer['products_purchased']);
            unset($customer['products_purchased']); // Remove product list to reduce response size

            // Calculate purchase frequency (orders per month)
            if (!empty($customer['first_purchase']) && !empty($customer['last_purchase'])) {
                $firstDate = \strtotime($customer['first_purchase']);
                $lastDate = \strtotime($customer['last_purchase']);

                $monthDiff = \max(1, \round(($lastDate - $firstDate) / (30 * 24 * 60 * 60)));
                $customer['purchase_frequency'] = $customer['order_count'] / $monthDiff;

                // Customer lifetime value
                $customer['customer_value'] = $customer['average_order_value'] * $customer['purchase_frequency'] * 12; // Annualized value

                // Segment classification
                $daysSinceLastPurchase = \round(($now - $lastDate) / (24 * 60 * 60));

                if ($daysSinceLastPurchase <= 90) {
                    $customer['segment'] = 'active';
                } elseif ($daysSinceLastPurchase <= 365) {
                    $customer['segment'] = 'at_risk';
                    $segments['inactive']['count']++;
                    $segments['inactive']['last_active'] = \max($segments['inactive']['last_active'] ?? 0, $lastDate);
                } else {
                    $customer['segment'] = 'churned';
                    $segments['inactive']['count']++;
                    $segments['inactive']['last_active'] = \max($segments['inactive']['last_active'] ?? 0, $lastDate);
                }

                // New vs returning classification
                $isNewCustomer = ($firstDate == $lastDate);
                if ($isNewCustomer) {
                    $segments['new']['count']++;
                    $segments['new']['revenue'] += $customer['total_spend'];
                    $customer['customer_type'] = 'new';
                } else {
                    $segments['returning']['count']++;
                    $segments['returning']['revenue'] += $customer['total_spend'];
                    $customer['customer_type'] = 'returning';
                }
            }
        }

        // Sort customers by total spend
        \usort($customers, function ($a, $b) {
            return $b['total_spend'] <=> $a['total_spend'];
        });

        // Get top customers
        $topCustomers = \array_slice($customers, 0, 10);

        // Calculate RFM (Recency, Frequency, Monetary) segmentation
        $rfmSegmentation = $this->calculateRFMSegmentation($customers, $now);

        // Calculate customer retention rate
        $retentionRate = $totalCustomers > 0 ?
            ($segments['returning']['count'] / $totalCustomers) * 100 : 0;

        // Format inactive last active date if exists
        if ($segments['inactive']['last_active']) {
            $segments['inactive']['last_active'] = \date('Y-m-d', $segments['inactive']['last_active']);
        }

        return [
            'top_customers' => $topCustomers,
            'customer_segments' => $segments,
            'total_customers' => $totalCustomers,
            'retention_rate' => \round($retentionRate, 2),
            'rfm_segmentation' => $rfmSegmentation,
        ];
    }

    /**
     * Calculate RFM (Recency, Frequency, Monetary) segmentation for customers
     */
    private function calculateRFMSegmentation(array $customers, int $now): array {
        if (empty($customers)) {
            return [
                'segments' => [],
                'distribution' => [],
            ];
        }

        // Calculate RFM scores
        $rfmData = [];

        foreach ($customers as $customer) {
            $recency = !empty($customer['last_purchase']) ?
                ($now - \strtotime($customer['last_purchase'])) / (24 * 60 * 60) : 999;

            $frequency = $customer['purchase_frequency'] ?? 0;
            $monetary = $customer['total_spend'] ?? 0;

            $rfmData[] = [
                'customer_id' => $customer['customer_id'],
                'recency' => $recency,
                'frequency' => $frequency,
                'monetary' => $monetary,
            ];
        }

        // Sort data for scoring
        \usort($rfmData, function ($a, $b) {
            return $a['recency'] <=> $b['recency']; // Lower is better for recency
        });

        $count = \count($rfmData);
        $quintileSize = \ceil($count / 5);

        // Assign recency scores (5 = best, 1 = worst)
        for ($i = 0; $i < $count; $i++) {
            $rfmData[$i]['recency_score'] = 5 - \min(4, \floor($i / $quintileSize));
        }

        // Sort by frequency and assign scores
        \usort($rfmData, function ($a, $b) {
            return $b['frequency'] <=> $a['frequency']; // Higher is better
        });

        for ($i = 0; $i < $count; $i++) {
            $rfmData[$i]['frequency_score'] = 5 - \min(4, \floor($i / $quintileSize));
        }

        // Sort by monetary value and assign scores
        \usort($rfmData, function ($a, $b) {
            return $b['monetary'] <=> $a['monetary']; // Higher is better
        });

        for ($i = 0; $i < $count; $i++) {
            $rfmData[$i]['monetary_score'] = 5 - \min(4, \floor($i / $quintileSize));
        }

        // Calculate RFM segments
        $segments = [
            'champions' => 0,
            'loyal_customers' => 0,
            'potential_loyalists' => 0,
            'new_customers' => 0,
            'promising' => 0,
            'customers_needing_attention' => 0,
            'at_risk' => 0,
            'cant_lose_them' => 0,
            'hibernating' => 0,
            'lost' => 0,
        ];

        foreach ($rfmData as $data) {
            $r = $data['recency_score'];
            $f = $data['frequency_score'];
            $m = $data['monetary_score'];

            $avgFM = ($f + $m) / 2;

            if ($r >= 4 && $avgFM >= 4) {
                $segment = 'champions';
            } elseif ($r >= 2 && $avgFM >= 3) {
                $segment = 'loyal_customers';
            } elseif ($r >= 3 && $avgFM >= 1 && $avgFM < 3) {
                $segment = 'potential_loyalists';
            } elseif ($r >= 4 && $avgFM < 2) {
                $segment = 'new_customers';
            } elseif ($r >= 3 && $avgFM < 1) {
                $segment = 'promising';
            } elseif ($r >= 2 && $r < 3 && $avgFM < 3) {
                $segment = 'customers_needing_attention';
            } elseif ($r >= 1 && $r < 2 && $avgFM >= 2) {
                $segment = 'at_risk';
            } elseif ($r < 1 && $avgFM >= 4) {
                $segment = 'cant_lose_them';
            } elseif ($r < 2 && $avgFM >= 1 && $avgFM < 4) {
                $segment = 'hibernating';
            } else {
                $segment = 'lost';
            }

            $segments[$segment]++;
        }

        // Convert to percentage distribution
        $distribution = [];
        foreach ($segments as $segment => $count) {
            $distribution[] = [
                'segment' => $segment,
                'count' => $count,
                'percentage' => $count > 0 ? \round(($count / \count($rfmData)) * 100, 2) : 0,
            ];
        }

        return [
            'segments' => $segments,
            'distribution' => $distribution,
        ];
    }

    /**
     * Perform comparative analysis (e.g., year-over-year, category comparison)
     */
    private function performComparativeAnalysis(array $data): array {
        $yearlyData = [];
        $productComparison = [];
        $categoryComparison = [];

        foreach ($data as $item) {
            $date = $item['date'] ?? '';
            if (empty($date)) {
                continue;
            }

            $amount = (float)($item['amount'] ?? 0);
            $year = \date('Y', \strtotime($date));
            $month = \date('m', \strtotime($date));
            $yearMonth = "$year-$month";

            $productId = $item['product_id'] ?? '';
            $category = $item['category'] ?? 'Uncategorized';

            // Yearly data
            if (!isset($yearlyData[$year])) {
                $yearlyData[$year] = ['total' => 0, 'months' => []];
            }

            $yearlyData[$year]['total'] += $amount;

            if (!isset($yearlyData[$year]['months'][$month])) {
                $yearlyData[$year]['months'][$month] = 0;
            }

            $yearlyData[$year]['months'][$month] += $amount;

            // Product comparison data
            if (!empty($productId)) {
                if (!isset($productComparison[$productId])) {
                    $productComparison[$productId] = [
                        'product_id' => $productId,
                        'product_name' => $item['product_name'] ?? "Product $productId",
                        'years' => [],
                        'total' => 0,
                    ];
                }

                if (!isset($productComparison[$productId]['years'][$year])) {
                    $productComparison[$productId]['years'][$year] = 0;
                }

                $productComparison[$productId]['years'][$year] += $amount;
                $productComparison[$productId]['total'] += $amount;
            }

            // Category comparison data
            if (!isset($categoryComparison[$category])) {
                $categoryComparison[$category] = [
                    'category' => $category,
                    'years' => [],
                    'total' => 0,
                ];
            }

            if (!isset($categoryComparison[$category]['years'][$year])) {
                $categoryComparison[$category]['years'][$year] = 0;
            }

            $categoryComparison[$category]['years'][$year] += $amount;
            $categoryComparison[$category]['total'] += $amount;
        }

        // Process yearly data for comparison
        $years = \array_keys($yearlyData);
        \sort($years);

        $yearlyComparison = [];
        $monthlyComparison = [];
        $currentYear = \date('Y');

        // Calculate year-over-year growth
        for ($i = 1; $i < \count($years); $i++) {
            $prevYear = $years[$i - 1];
            $currYear = $years[$i];

            $prevTotal = $yearlyData[$prevYear]['total'];
            $currTotal = $yearlyData[$currYear]['total'];

            $yearGrowth = $prevTotal > 0 ?
                (($currTotal - $prevTotal) / $prevTotal) * 100 : 0;

            $yearlyComparison[] = [
                'year' => $currYear,
                'previous_year' => $prevYear,
                'current_sales' => $currTotal,
                'previous_sales' => $prevTotal,
                'growth_percentage' => \round($yearGrowth, 2),
            ];

            // Process monthly data for the most recent year
            if ($currYear == $currentYear || $i == \count($years) - 1) {
                for ($month = 1; $month <= 12; $month++) {
                    $monthStr = \str_pad($month, 2, '0', STR_PAD_LEFT);

                    $currMonthSales = $yearlyData[$currYear]['months'][$monthStr] ?? 0;
                    $prevMonthSales = $yearlyData[$prevYear]['months'][$monthStr] ?? 0;

                    $monthGrowth = $prevMonthSales > 0 ?
                        (($currMonthSales - $prevMonthSales) / $prevMonthSales) * 100 : 0;

                    $monthlyComparison[] = [
                        'month' => $monthStr,
                        'month_name' => \date('F', \mktime(0, 0, 0, $month, 10)),
                        'current_year' => $currYear,
                        'previous_year' => $prevYear,
                        'current_sales' => $currMonthSales,
                        'previous_sales' => $prevMonthSales,
                        'growth_percentage' => \round($monthGrowth, 2),
                    ];
                }
            }
        }

        // Process product comparison
        $productComparisonArray = [];
        foreach ($productComparison as $product) {
            $yearData = [];
            $growthData = [];

            foreach ($years as $i => $year) {
                $yearSales = $product['years'][$year] ?? 0;
                $yearData[] = [
                    'year' => $year,
                    'sales' => $yearSales,
                ];

                if ($i > 0) {
                    $prevYear = $years[$i - 1];
                    $prevSales = $product['years'][$prevYear] ?? 0;

                    $growth = $prevSales > 0 ?
                        (($yearSales - $prevSales) / $prevSales) * 100 : 0;

                    $growthData[] = [
                        'year' => $year,
                        'previous_year' => $prevYear,
                        'growth_percentage' => \round($growth, 2),
                    ];
                }
            }

            $productComparisonArray[] = [
                'product_id' => $product['product_id'],
                'product_name' => $product['product_name'],
                'yearly_sales' => $yearData,
                'yearly_growth' => $growthData,
                'total_sales' => $product['total'],
            ];
        }

        // Process category comparison
        $categoryComparisonArray = [];
        foreach ($categoryComparison as $category) {
            $yearData = [];
            $growthData = [];

            foreach ($years as $i => $year) {
                $yearSales = $category['years'][$year] ?? 0;
                $yearData[] = [
                    'year' => $year,
                    'sales' => $yearSales,
                ];

                if ($i > 0) {
                    $prevYear = $years[$i - 1];
                    $prevSales = $category['years'][$prevYear] ?? 0;

                    $growth = $prevSales > 0 ?
                        (($yearSales - $prevSales) / $prevSales) * 100 : 0;

                    $growthData[] = [
                        'year' => $year,
                        'previous_year' => $prevYear,
                        'growth_percentage' => \round($growth, 2),
                    ];
                }
            }

            $categoryComparisonArray[] = [
                'category' => $category['category'],
                'yearly_sales' => $yearData,
                'yearly_growth' => $growthData,
                'total_sales' => $category['total'],
            ];
        }

        // Sort product and category arrays by total sales
        \usort($productComparisonArray, function ($a, $b) {
            return $b['total_sales'] <=> $a['total_sales'];
        });

        \usort($categoryComparisonArray, function ($a, $b) {
            return $b['total_sales'] <=> $a['total_sales'];
        });

        // Get top products and categories
        $topProducts = \array_slice($productComparisonArray, 0, 5);
        $topCategories = \array_slice($categoryComparisonArray, 0, 5);

        return [
            'year_over_year' => $yearlyComparison,
            'month_over_month' => $monthlyComparison,
            'top_products_comparison' => $topProducts,
            'top_categories_comparison' => $topCategories,
        ];
    }

    /**
     * Perform comprehensive analysis combining all analysis types
     */
    private function performComprehensiveAnalysis(array $data): array {
        // Perform all analysis types
        $basicAnalysis = $this->performBasicAnalysis($data);
        $trendsAnalysis = $this->analyzeTrends($data);
        $seasonalAnalysis = $this->analyzeSeasonality($data);
        $productAnalysis = $this->analyzeProductPerformance($data);
        $customerAnalysis = $this->analyzeCustomerBehavior($data);
        $comparativeAnalysis = $this->performComparativeAnalysis($data);

        // Extract key insights from each analysis
        $insights = [];

        // Basic insights
        $insights[] = [
            'category' => 'summary',
            'insight' => 'Total sales amount: ' . \round($basicAnalysis['summary']['total_sales'], 2) .
                ' across ' . $basicAnalysis['summary']['total_orders'] . ' orders.',
            'importance' => 'high',
        ];

        $insights[] = [
            'category' => 'summary',
            'insight' => 'Average order value: ' . \round($basicAnalysis['summary']['average_order_value'], 2),
            'importance' => 'medium',
        ];

        // Trend insights
        if (!empty($trendsAnalysis['trend_indicators'])) {
            $trendDirection = $trendsAnalysis['trend_indicators']['direction'] ?? 'stable';
            $avgGrowth = $trendsAnalysis['trend_indicators']['average_growth'] ?? 0;

            $insights[] = [
                'category' => 'trends',
                'insight' => "Sales trend is {$trendDirection} with an average growth rate of {$avgGrowth}%.",
                'importance' => 'high',
            ];

            if (!empty($trendsAnalysis['trend_indicators']['forecast'])) {
                $lastForecast = \end($trendsAnalysis['trend_indicators']['forecast']);

                $insights[] = [
                    'category' => 'trends',
                    'insight' => "Forecasted sales for {$lastForecast['period']}: " . \round($lastForecast['forecasted_sales'], 2),
                    'importance' => 'medium',
                ];
            }
        }

        // Seasonality insights
        if (!empty($seasonalAnalysis['monthly_patterns']['peak_months'])) {
            $peakMonths = \implode(', ', $seasonalAnalysis['monthly_patterns']['peak_months']);

            $insights[] = [
                'category' => 'seasonality',
                'insight' => "Peak sales months: {$peakMonths}",
                'importance' => 'medium',
            ];
        }

        if (!empty($seasonalAnalysis['monthly_patterns']['seasonality_category'])) {
            $seasonalityStrength = $seasonalAnalysis['monthly_patterns']['seasonality_category'];

            $insights[] = [
                'category' => 'seasonality',
                'insight' => "Seasonality strength is {$seasonalityStrength}.",
                'importance' => 'medium',
            ];
        }

        // Product insights
        if (!empty($productAnalysis['top_products']) && \count($productAnalysis['top_products']) > 0) {
            $topProduct = $productAnalysis['top_products'][0];

            $insights[] = [
                'category' => 'product',
                'insight' => "Top performing product: {$topProduct['product_name']} with " .
                    \round($topProduct['total_sales'], 2) . ' in sales.',
                'importance' => 'high',
            ];
        }

        if (!empty($productAnalysis['pareto_analysis']['pareto_principle_applies'])) {
            $paretoApplies = $productAnalysis['pareto_analysis']['pareto_principle_applies'];

            if ($paretoApplies) {
                $productsPercentage = $productAnalysis['pareto_analysis']['products_percentage'];

                $insights[] = [
                    'category' => 'product',
                    'insight' => "The 80/20 rule applies: {$productsPercentage}% of products generate 80% of revenue.",
                    'importance' => 'high',
                ];
            }
        }

        // Customer insights
        if (!empty($customerAnalysis['retention_rate'])) {
            $retentionRate = $customerAnalysis['retention_rate'];

            $insights[] = [
                'category' => 'customer',
                'insight' => "Customer retention rate: {$retentionRate}%",
                'importance' => 'high',
            ];
        }

        if (!empty($customerAnalysis['top_customers']) && \count($customerAnalysis['top_customers']) > 0) {
            $topCustomer = $customerAnalysis['top_customers'][0];

            $insights[] = [
                'category' => 'customer',
                'insight' => "Top customer: {$topCustomer['customer_name']} with " .
                    \round($topCustomer['total_spend'], 2) . ' in total purchases.',
                'importance' => 'medium',
            ];
        }

        // Comparative insights
        if (!empty($comparativeAnalysis['year_over_year']) && \count($comparativeAnalysis['year_over_year']) > 0) {
            $latestYoY = \end($comparativeAnalysis['year_over_year']);

            $insights[] = [
                'category' => 'comparative',
                'insight' => "Year-over-year growth ({$latestYoY['previous_year']} to {$latestYoY['year']}): " .
                    \round($latestYoY['growth_percentage'], 2) . '%',
                'importance' => 'high',
            ];
        }

        // Sort insights by importance
        \usort($insights, function ($a, $b) {
            $importanceOrder = ['high' => 0, 'medium' => 1, 'low' => 2];
            return $importanceOrder[$a['importance']] <=> $importanceOrder[$b['importance']];
        });

        return [
            'summary' => $basicAnalysis['summary'],
            'key_insights' => $insights,
            'trend_analysis' => [
                'direction' => $trendsAnalysis['trend_indicators']['direction'] ?? 'stable',
                'growth_rate' => $trendsAnalysis['trend_indicators']['average_growth'] ?? 0,
            ],
            'top_products' => \array_slice($productAnalysis['top_products'] ?? [], 0, 3),
            'seasonal_patterns' => [
                'peak_months' => $seasonalAnalysis['monthly_patterns']['peak_months'] ?? [],
                'low_months' => $seasonalAnalysis['monthly_patterns']['low_months'] ?? [],
            ],
            'customer_metrics' => [
                'retention_rate' => $customerAnalysis['retention_rate'] ?? 0,
                'top_segments' => \array_slice($customerAnalysis['rfm_segmentation']['distribution'] ?? [], 0, 3),
            ],
            'detailed_analysis' => [
                'basic' => $basicAnalysis,
                'trends' => $trendsAnalysis,
                'seasonality' => $seasonalAnalysis,
                'product' => $productAnalysis,
                'customer' => $customerAnalysis,
                'comparative' => $comparativeAnalysis,
            ],
        ];
    }
}
