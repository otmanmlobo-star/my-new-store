<?php
namespace App\Core;

class Jwt
{
    private $secret;
    public function __construct($secret)
    {
        $this->secret = $secret;
    }

    private function base64url_encode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public function encode(array $payload, $exp = 3600)
    {
        $header = ['alg' => 'HS256', 'typ' => 'JWT'];
        $payload['iat'] = time();
        $payload['exp'] = time() + $exp;
        $segments = [];
        $segments[] = $this->base64url_encode(json_encode($header));
        $segments[] = $this->base64url_encode(json_encode($payload));
        $signing_input = implode('.', $segments);
        $signature = hash_hmac('sha256', $signing_input, $this->secret, true);
        $segments[] = $this->base64url_encode($signature);
        return implode('.', $segments);
    }

    public function decode($jwt)
    {
        $parts = explode('.', $jwt);
        if (count($parts) !== 3) return null;
        list($b64head, $b64payload, $b64sig) = $parts;
        $payload = json_decode(base64_decode(strtr($b64payload, '-_', '+/')), true);
        $signing_input = $b64head.'.'.$b64payload;
        $signature = base64_decode(strtr($b64sig, '-_', '+/'));
        $verified = hash_hmac('sha256', $signing_input, $this->secret, true);
        if (!hash_equals($verified, $signature)) return null;
        if (isset($payload['exp']) && time() > $payload['exp']) return null;
        return $payload;
    }
}
