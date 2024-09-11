<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\Concerns;

use DateTimeImmutable;
use RuntimeException;

/**
 * @see https://developers.cloudflare.com/stream/viewing-videos/securing-your-stream/#option-2-generating-signed-tokens-without-calling-the-token-endpoint
 */
class StreamSigner
{
    /** @var array<string,mixed> */
    protected array $headers = [];

    /** @var array<string,mixed> */
    protected array $payload = [];

    public function __construct(
        private string $pem,
        private string $keyId,
    ) {}

    public function tokenFor(string $videoId): string
    {
        $encodedPayload = $this->arrayToBase64url($this->payload($videoId));
        $encodedHeader = $this->arrayToBase64url($this->headers());

        $signed = openssl_sign(
            data: "$encodedHeader.$encodedPayload",
            signature: $signature,
            private_key: $this->privateKey(),
            algorithm: OPENSSL_ALGO_SHA256
        );

        if (! $signed) {
            throw new RuntimeException('Failed to sign token');
        }

        $encodedSignature = $this->encodeToBase64Url($signature);

        return "$encodedHeader.$encodedPayload.$encodedSignature";
    }

    /**
     * @return array<string,mixed>
     */
    protected function headers(): array
    {
        $this->headers = [
            'alg' => 'RS256',
            'kid' => $this->keyId,
        ];

        return $this->headers;
    }

    /**
     * @return array<string,mixed>
     */
    protected function payload(string $videoId): array
    {
        $this->addPayload(['kid' => $this->keyId]);
        $this->addPayload(['sub' => $videoId]);

        if (! isset($this->payload['exp'])) {
            $this->expires(new DateTimeImmutable('+1 hour'));
        }

        return $this->payload;
    }

    public function expires(DateTimeImmutable $dateTime): self
    {
        $this->addPayload(['exp' => $dateTime->getTimestamp()]);

        return $this;
    }

    public function availableFrom(DateTimeImmutable $dateTime): self
    {
        $this->addPayload(['nbf' => $dateTime->getTimestamp()]);

        return $this;
    }

    public function downloadable(bool $downloadable = true): self
    {
        $this->addPayload(['downloadable' => $downloadable]);

        return $this;
    }

    /**
     * @param  array<int,array{action?:string,country?:array{string},ip?:array{string},type?:string}>  $accessRules
     */
    public function accessRules(array $accessRules): self
    {
        $this->addPayload(['accessRules' => $accessRules]);

        return $this;
    }

    /**
     * @param  array<string,mixed>  $payload
     */
    protected function addPayload(array $payload): self
    {
        $this->payload = array_merge($this->payload, $payload);

        return $this;
    }

    protected function removePayload(string $key): self
    {
        unset($this->payload[$key]);

        return $this;
    }

    protected function privateKey(): \OpenSSLAsymmetricKey
    {
        if (! $key = openssl_pkey_get_private(base64_decode($this->pem))) {
            throw new RuntimeException('Invalid private key');
        }

        return $key;
    }

    /**
     * @param  array{sub:string,kid:string,exp:int,accessRules?:array{action?:string,country?:array{string},ip?:array{string},type?:string}}  $payload
     */
    protected function token(array $payload): string
    {
        return $this->arrayToBase64url($this->headers()).'.'.$this->arrayToBase64url($payload);
    }

    private function encodeToBase64Url(string $str): string
    {
        return rtrim(strtr(base64_encode($str), '+/', '-_'), '=');
    }

    /**
     * @param  array<string|int,mixed>  $data
     */
    private function arrayToBase64url(array $data): string
    {
        return $this->encodeToBase64Url(json_encode(
            value: $data,
            flags: JSON_THROW_ON_ERROR
        ));
    }
}
