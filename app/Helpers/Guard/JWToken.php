<?php
namespace App\Helpers\Guard;

class JWToken
{
    protected string $secret = '';

    public function __construct()
    {
        $this->secret = base64_encode(config('jwt.key'));
    }

    public function generate(array $headers, array $payload, int $expires = 86400)
    {
        if($expires > 0)
        {
            $payload['iat'] = (new \DateTime())->getTimestamp();
            $payload['exp'] = $payload['iat'] + $expires;
        }

        $base64Header = base64_encode(json_encode($headers));

        $base64Payload = base64_encode(json_encode($payload));

        $base64Header = str_replace(['+', '/', '='], ['-', '_', ''], $base64Header);

        $base64Payload = str_replace(['+', '/', '='], ['-', '_', ''], $base64Payload);

        $signature = hash_hmac('sha256', $base64Header.'.'.$base64Payload, $this->secret, true);

        $base64Signature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        $jwtoken = $base64Header.'.'.$base64Payload.'.'.$base64Signature;

        return $jwtoken;
    }

    public function check(string $token)
    {
        $header = $this->getHeader($token);

        $payload = $this->getPayload($token);

        $checkToken = $this->generate($header, $payload, $this->secret, 0);

        return $token === $checkToken;
    }

    public function getSecret()
    {
        return $this->secret;
    }

    public function getHeader(string $token)
    {
        return json_decode(base64_decode(explode('.', $token)[0]), true);
    }

    public function getPayload(string $token)
    {
        return json_decode(base64_decode(explode('.', $token)[1]), true);
    }

    public function isExpired(string $token)
    {
        $payload = $this->getPayload($token);

        return $payload['exp'] < (new \DateTime())->getTimestamp();
    }

    public function isValid(string $token)
    {
        return preg_match(
            '#^[a-zA-Z0-9\-\_\=]+\.[[a-zA-Z0-9\-\_\=]+\.[[a-zA-Z0-9\-\_\=]+$#',
            $token
        ) === 1;
    }
}
