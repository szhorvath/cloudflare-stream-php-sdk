<?php

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use Nyholm\Psr7\Response;
use Szhorvath\CloudflareStream\ClientBuilder;
use Szhorvath\CloudflareStream\Enums\Status;
use Szhorvath\CloudflareStream\Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(TestCase::class)->in(__DIR__);

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/
function mockBuilder(?MockClient $client = null)
{
    return new ClientBuilder(
        httpClient: $client ?? new MockClient,
    );
}

function response(Status $status, string $name): Response
{
    return new Response(
        status: $status->value,
        body: Psr17FactoryDiscovery::findStreamFactory()->createStream(
            fixture($name),
        ),

    );
}

function fixture(string $name): string
{
    if (! file_exists(filename: __DIR__."/Fixtures/{$name}.json")) {
        throw new InvalidArgumentException(
            message: "Fixture not found [{$name}].",
        );
    }

    return (string) file_get_contents(
        filename: __DIR__."/Fixtures/{$name}.json",
    );
}
