<?php

namespace app\classes\llmagents\salesanalysis\tools;

use LLM\Agents\Tool\PhpTool;

/**
 * @extends PhpTool<GenerateSalesReportInput>
 */
final class GenerateSalesReportTool extends PhpTool {
    public const NAME = 'generate_sales_report';

    public function __construct() {
        parent::__construct(
            name: self::NAME,
            inputSchema: GenerateSalesReportInput::class,
            description: 'This tool generates comprehensive sales reports based on provided data, time period, and report type.',
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

        // Generate the appropriate report based on type
        $report = file_get_contents(APP_PATH . $input->reportPath);

        return \json_encode([
            'success' => true,
            'report_type' => $input->reportType ?? 'standard',
            'report_data' => $report,
        ]);
    }
}
