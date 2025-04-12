<?php

declare(strict_types=1);

namespace app\classes\llmagents\sitestatuschecker\tools;

use LLM\Agents\Tool\PhpTool;

/**
 * @extends PhpTool<GetDnsInfoInput>
 */
final class GetDnsInfoTool extends PhpTool {
    public const NAME = 'get_dns_info';

    public function __construct() {
        parent::__construct(
            name: self::NAME,
            inputSchema: GetDnsInfoInput::class,
            description: 'This tool retrieves DNS information for a given domain, including IP addresses and name servers.',
        );
    }

    public function execute(object $input): string {
        // Implement the actual DNS info retrieval here
        // This is a placeholder implementation
        $dnsRecords = \dns_get_record(str_ireplace(['https://', 'http://'], '', $input->domain), DNS_A + DNS_NS);

        $ipAddresses = \array_column(array_filter($dnsRecords, fn ($record) => $record['type'] === 'A'), 'ip');
        $nameServers = \array_column(array_filter($dnsRecords, fn ($record) => $record['type'] === 'NS'), 'target');

        return \json_encode([
            'ip_addresses' => $ipAddresses,
            'name_servers' => $nameServers,
        ]);
    }
}
