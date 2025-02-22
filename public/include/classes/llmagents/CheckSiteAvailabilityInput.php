<?php

declare(strict_types=1);

namespace app\public\include\classes\llmagents;

//use Spiral\JsonSchemaGenerator\Attribute\Field;

final readonly class CheckSiteAvailabilityInput
{
    public function __construct(
//        #[Field(title: 'URL', description: 'The full URL of the website to check')]
        public string $url,
    ) {}
}
