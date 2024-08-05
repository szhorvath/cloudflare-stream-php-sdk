<?php

declare(strict_types=1);

use Szhorvath\CloudflareStream\StreamSdk;

it('should build a new client')
    ->expect(new StreamSdk(token: '1234567890'))
    ->toBeInstanceOf(StreamSdk::class);
