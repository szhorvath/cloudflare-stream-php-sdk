<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\DataObjects;

use Illuminate\Support\Collection;
use League\ObjectMapper\Constructor;
use Szhorvath\CloudflareStream\Contracts\ResultContract;

class ApiResponse
{
    /**
     * @param  Collection<int, Error>  $errors
     * @param  Collection<int Message>  $messages
     */
    public function __construct(
        public readonly bool $success,
        public readonly ResultContract $result,
        public readonly Collection $errors,
        public readonly Collection $messages,
    ) {}

    #[Constructor]
    public static function from(array $data, string $resultClass): self
    {
        return new self(
            success: $data['success'],
            result: $resultClass::from($data['result']),
            errors: (new Collection($data['errors']))->map(fn ($error) => Error::from($error)),
            messages: (new Collection($data['messages']))->map(fn ($message) => Message::from($message))
        );
    }
}
