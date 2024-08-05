<?php

declare(strict_types=1);

use Szhorvath\CloudflareStream\ClientBuilder;

it('should create a builder')
    ->expect(new ClientBuilder)
    ->toBeInstanceOf(ClientBuilder::class);
