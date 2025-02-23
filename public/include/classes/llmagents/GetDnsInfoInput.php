<?php

declare(strict_types=1);

namespace app\public\include\classes\llmagents;

//use Spiral\JsonSchemaGenerator\Attribute\Field;

final readonly class GetDnsInfoInput
{
    public function __construct(
        ##[Field(title: 'Domain', description: 'The domain name to look up DNS information for')]
        public string $domain,
    ) {}
}
