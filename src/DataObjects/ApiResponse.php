<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\DataObjects;

use League\ObjectMapper\Constructor;
use Szhorvath\CloudflareStream\Contracts\ResultContract;

// use Szhorvath\CloudflareStream\Contracts\ResultContract;

class ApiResponse
{
    public function __construct(
        public readonly bool $success,
        public readonly array $errors,
        public readonly ResultContract $result,
        public readonly array $messages = [],
    ) {}

    #[Constructor]
    public static function from(array $data, string $resultClass): self
    {
        return new self(
            success: $data['success'],
            errors: $data['errors'],
            result: $resultClass::from($data['result']),
            messages: $data['messages'] ?? [],
        );
    }
}
