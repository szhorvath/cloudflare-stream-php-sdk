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
    public function __construct(
        private string $pem,
        private string $keyId,
    ) {}

    /**
     * @param  array<int,array{action?:string,country?:array{string},ip?:array{string},type?:string}>  $accessRules
     */
    public function signedToken(string $videoId, array $accessRules = [], ?DateTimeImmutable $expiresAt = null): string
    {
        $data = [
            'sub' => $videoId,
            'kid' => $this->keyId,
            'exp' => $expiresAt ? $expiresAt->getTimestamp() : time() + 3600,
            'accessRules' => $accessRules,
        ];

        $token = $this->token($data);

        $signed = openssl_sign(
            data: $token,
            signature: $signature,
            private_key: $this->privateKey(),
            algorithm: OPENSSL_ALGO_SHA256
        );

        if (! $signed) {
            throw new RuntimeException('Failed to sign token');
        }

        $signedToken = $token.'.'.$this->encodeToBase64Url($signature);

        return $signedToken;
    }

    /**
     * @return array{alg:string,kid:string}
     */
    protected function headers(): array
    {
        return [
            'alg' => 'RS256',
            'kid' => $this->keyId,
        ];
    }

    protected function privateKey(): \OpenSSLAsymmetricKey
    {
        if (! $key = openssl_pkey_get_private(base64_decode($this->pem))) {
            throw new RuntimeException('Invalid private key');
        }

        return $key;
    }

    /**
     * @param  array{sub:string,kid:string,exp:int,accessRules?:array{action?:string,country?:array{string},ip?:array{string},type?:string}}  $data
     */
    protected function token(array $data): string
    {
        return $this->arrayToBase64url($this->headers()).'.'.$this->arrayToBase64url($data);
    }

    private function encodeToBase64Url(string $str): string
    {
        return rtrim(strtr(base64_encode($str), '+/', '-_'), '=');
    }

    /**
     * @param  array<string|int,mixed>  $payload
     */
    private function arrayToBase64url(array $payload): string
    {
        return $this->encodeToBase64Url(json_encode(
            value: $payload,
            flags: JSON_THROW_ON_ERROR
        ));
    }
}
