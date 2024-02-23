<?php
require __DIR__ . '\vendor\autoload.php';

use Nowakowskir\JWT\JWT;
use Nowakowskir\JWT\Base64Url;

$secretKey = '1654949ewfwefweeg989e8weg9';

function generateJwtToken($payloadData, $secretKey) {
    // Encode token header and payload separately
    $header = Base64Url::encode(json_encode(['alg' => 'HS256', 'typ' => 'JWT']));
    $payload = Base64Url::encode(json_encode($payloadData));
    
    // Create signature (HS256 algorithm)
    $signature = Base64Url::encode(hash_hmac('sha256', "$header.$payload", $secretKey, true));

    $token = "$header.$payload.$signature";
    return $token;
}


function decodeJwtToken($token, $secretKey) {
    try {
        // Decode the token
        $decodedData = JWT::decode($token, $secretKey, 'HS256');
        // Return decoded data
        return $decodedData;
    } catch (Exception $e) {
        // Handle invalid token exception
        return false;
    }
}
