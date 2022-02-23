<?php

const USERNAME = "";  // your username
const PASSWORD = "";  // your password
const HOSTNAME = "https://api.sandbox.biller.ai";  // for prod use https://api.biller.ai/
const ORDER_UUID = "";  // your order UUID

function makeRequest($url, $request) {
    $context  = stream_context_create($request);
    $response = file_get_contents($url, false, $context);
    return json_decode($response, true);
}

$auth_request = array(
        'http' => array(
            'header'  => "Content-type: application/json",
            'method'  => 'POST',
            'content' => json_encode([ "username" => USERNAME, "password" => PASSWORD ])
        )
    );

$auth_url = HOSTNAME . "/v1/api/token/";

$auth_response = makeRequest($auth_url, $auth_request);
$token = $auth_response["access"];

$order_info_request = array(
        'http' => array(
            'header'  => array( "Content-type: application/json", "Authorization: Bearer ".$token),
            'method'  => 'GET',
        )
    );
$order_info_url = HOSTNAME . "/v1/api/orders/".ORDER_UUID;
$order_info_response = makeRequest($order_info_url, $order_info_request);
print_r($order_info_response);
