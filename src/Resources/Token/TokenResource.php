<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\Resources\Token;

use Szhorvath\CloudflareStream\DataObjects\ApiResponse;
use Szhorvath\CloudflareStream\DataObjects\Token\Verify;
use Szhorvath\CloudflareStream\Resources\Resource;

class TokenResource extends Resource
{
    public function verify(): ApiResponse
    {
        $response = $this->client()->get('/user/tokens/verify');

        return ApiResponse::from(
            data: $this->decodeResponse($response),
            resultClass: Verify::class
        );
    }
}
