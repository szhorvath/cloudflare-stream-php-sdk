<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\Resources\Token;

use Szhorvath\CloudflareStream\Resources\Resource;

class TokenResource extends Resource
{
    public function verify(): bool
    {
        $response = $this->client()->get('/user/tokens/verify');

        $responseBody = $response->getBody()->getContents();

        return json_decode($responseBody)->success;
    }
}
