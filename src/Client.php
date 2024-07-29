<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream;

use Http\Client\Common\HttpMethodsClient;
use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin;
use Http\Client\Common\Plugin\AuthenticationPlugin;
use Http\Client\Common\Plugin\BaseUriPlugin;
use Http\Client\Common\Plugin\ErrorPlugin;
use Http\Client\Common\Plugin\RetryPlugin;
use Http\Client\Common\PluginClient;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Http\Message\Authentication\Bearer;
use Psr\Http\Client\ClientInterface;

class Client
{
    public function __construct(
        private readonly string $url,
        private readonly string $token,
        private ?ClientInterface $client = null,
        private array $plugins = [],
    ) {}

    /**
     * @param  array<int, Plugin>  $plugins
     */
    public function withPlugins(array $plugins): self
    {
        $this->plugins = array_merge($this->defaultPlugins(), $plugins);

        return $this;
    }

    public function defaultPlugins(): array
    {
        return [
            new RetryPlugin,
            new ErrorPlugin,
            new AuthenticationPlugin(
                authentication: new Bearer($this->token)
            ),
            new BaseUriPlugin(
                uri: Psr17FactoryDiscovery::findUriFactory()->createUri($this->url)
            ),
        ];
    }

    public function client(): HttpMethodsClientInterface
    {
        $pluginClient = new PluginClient(
            client: Psr18ClientDiscovery::find(),
            plugins: $this->defaultPlugins(),
        );

        return new HttpMethodsClient(
            $pluginClient,
            Psr17FactoryDiscovery::findRequestFactory(),
            Psr17FactoryDiscovery::findStreamFactory()
        );

    }

    public function setClient(ClientInterface $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function url(): string
    {
        return $this->url;
    }

    public function token(): string
    {
        return $this->token;
    }

    public function checkToken()
    {
        return $this->client()->get('/user/tokens/verify');
    }
}
