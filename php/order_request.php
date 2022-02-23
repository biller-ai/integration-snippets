<?php

// fill in constants below
const USERNAME = "";
const PASSWORD = "";
const WEBSHOP_UID = "";
const SUCCESS_URL = "";
const ERROR_URL = "";
const CANCEL_URL = "";
const WEBHOOK_URL = "";

const HOSTNAME = "https://api.sandbox.biller.ai";  // for prod use https://api.biller.ai/

function makeRequest($url, $request) {
    $context  = stream_context_create($request);
    $response = file_get_contents($url, false, $context);
    $jsonResponse = json_decode($response, true);
    return $jsonResponse;
}


const PAYLOAD = [
    "order_lines" => [
        [
            "quantity" => 1,
            "product_id" => "1441808338558",
            "product_name" => "Electric toothbrush",
            "product_description" => "Electric toothbrush including brushes.",
            "product_price_excl_tax" => 40000, // all amount in cents
            "product_price_incl_tax" => 48400,
            "product_tax_rate_percentage" => "21.00"
        ],
        [
            "quantity" => 1,
            "product_id" => "SHPNG",
            "product_name" => "Shipping costs",
            "product_description" => "Shipping costs",
            "product_price_excl_tax" => 400,
            "product_price_incl_tax" => 484,
            "product_tax_rate_percentage" => "21.00"
        ]
    ],
    "external_webshop_uid" => WEBSHOP_UID,
    "external_order_uid" => "7304421653023",
    "amount" => 48884,
    "currency" => "EUR",
//     "locale" => "nl", // optional, default is English
    "buyer_company" => [
        "name" => "My Cool Company B.V.",
        "registration_number" => "001234567000",
        "country" => "NL"
    ],
    "buyer_representative" => [
        "first_name" => "John",
        "last_name" => "Doe",
        "email" => "john.doe@my-cool-company.nl",
        "phone_number" => "+31612345678"
    ],
    "shipping_address" => [
        "street_address_1" => "Teststraat 1",
        "city" => "Groningen",
        "postal_code" => "9711 TT",
        "country" => "NL"
    ],
    "billing_address" => [
        "street_address_1" => "Zijstraat 27",
        "street_address_2" => "Suite 123",
        "city" => "Groningen",
        "postal_code" => "9715 AB",
        "country" => "NL"
    ],
    "seller_urls" => [
        "success_url" => SUCCESS_URL,
        "error_url" => ERROR_URL,
        "cancel_url" => CANCEL_URL
    ],
    "webhook_urls" => [
         "webhook_url" => WEBHOOK_URL
    ]
];

$auth_url = HOSTNAME . "/v1/api/token/";
$auth_request = array(
        'http' => array(
            'header'  => "Content-type: application/json",
            'method'  => 'POST',
            'content' => json_encode([ "username" => USERNAME, "password" => PASSWORD ])
        )
    );

$auth_response = makeRequest($auth_url, $auth_request);
$token = $auth_response["access"];
print_r($token);

$order_request = array(
        'http' => array(
            'header'  => array( "Content-type: application/json", "Authorization: Bearer ".$token),
            'method'  => 'POST',
            'content' => json_encode(PAYLOAD)
        )
    );

$order_request_url = HOSTNAME . "/v1/api/order-request/";
$response = makeRequest($order_request_url, $order_request);
print_r($response);
