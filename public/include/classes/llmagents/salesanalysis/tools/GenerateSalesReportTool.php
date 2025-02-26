<?php

namespace app\public\include\classes\llmagents\salesanalysis\tools;

use LLM\Agents\Tool\PhpTool;

/**
 * @extends PhpTool<GenerateSalesReportInput>
 */
final class GenerateSalesReportTool extends PhpTool
{
    public const NAME = 'generate_sales_report';

    public function __construct()
    {
        parent::__construct(
            name: self::NAME,
            inputSchema: GenerateSalesReportInput::class,
            description: 'This tool generates comprehensive sales reports based on provided data, time period, and report type.',
        );
    }

    public function execute(object $input): string
    {
        // Validate input data path
        if (!\file_exists($input->filePath)) {
            return \json_encode([
                'success' => false,
                'error' => 'Sales data file not found',
                'message' => "The file at path '{$input->filePath}' does not exist.",
            ]);

        // Generate the appropriate report based on type
        $report = file_get_contents($input->filePath);

        return \json_encode([
            'success' => true,
            'report_type' => $input->reportType,
            'report_data' => $report,
        ]);
    }
}
