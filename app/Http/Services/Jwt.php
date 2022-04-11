<?php

namespace App\Http\Services;

class Jwt{

    public $name;
    public $headers;
    public $payload;
    public $secret;

    public function __construct(){
        //$this->name=auth()->user->name;
        $this->secret = 'secret';
        $this->headers = [
            'alg'=>'HS256','typ'=>'JWT'
        ];
        $this->payload = [
            'sub'=>'1234567890','name'=>$this->name,
            'admin'=>true, 'exp'=>(time() + config('jwt.expireTime'))
        ];
    }

    public function setName($name){
        $this->name=$name;
    }


    public function generate_jwt() {

        $headers_encoded = $this->base64url_encode(json_encode($this->headers));
        $payload_encoded = $this->base64url_encode(json_encode($this->payload));

        $signature = hash_hmac('SHA256', "$headers_encoded.$payload_encoded", $this->secret, true);
        $signature_encoded = $this->base64url_encode($signature);

        $jwt = "$headers_encoded.$payload_encoded.$signature_encoded";

        return $jwt;
    }

    public function base64url_encode($str) {
        return rtrim(strtr(base64_encode($str), '+/', '-_'), '=');
    }

    public function is_jwt_valid($jwt) {
        // split the jwt
        $tokenParts = explode('.', $jwt);
        $header = base64_decode($tokenParts[0]);
        $payload = base64_decode($tokenParts[1]);
        $signature_provided = $tokenParts[2];

        // check the expiration time - note this will cause an error if there is no 'exp' claim in the jwt
        $expiration = json_decode($payload)->exp;
        $is_token_expired = ($expiration - time()) < 0 ? 1: 0;

        // build a signature based on the header and payload using the secret
        $base64_url_header = $this->base64url_encode($header);
        $base64_url_payload = $this->base64url_encode($payload);

        $signature = hash_hmac('SHA256', $base64_url_header . "." . $base64_url_payload, $this->secret,true);
        $base64_url_signature = $this->base64url_encode($signature);

        // verify it matches the signature provided in the jwt
        $is_signature_valid = ($base64_url_signature === $signature_provided);

        if ($is_token_expired || !$is_signature_valid) {
            return "false";
        } else {
            return "true";
        }
    }

}
