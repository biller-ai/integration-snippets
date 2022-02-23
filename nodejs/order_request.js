/**
 * Make sure to install the requirements:
 *
 *     $ npm install axios
 */

const axios = require('axios');

const WEBSHOP_UID = ""; // YOUR_WEBSHOP_UID
const SUCCESS_URL = ""; // YOUR_SUCCESS_URL
const ERROR_URL = ""; // YOUR_ERROR_URL
const CANCEL_URL = ""; // YOUR_CANCEL_URL
const WEBHOOK_URL = ""; // YOUR_WEBHOOK_URL

const USERNAME = '';
const PASSWORD = '';

const HOST_NAME = 'https://api.sandbox.biller.ai/';  // for prod use https://api.biller.ai/
const API_URL = HOST_NAME + 'v1/api/order-request/';
const AUTH_URL = HOST_NAME + 'v1/api/token/';

const PAYLOAD = {
  "order_lines": [
    {
      "quantity": 1,
      "product_id": "1441808338558",
      "product_name": "Electric toothbrush",
      "product_description": "Electric toothbrush including brushes.",
      "product_price_excl_tax": 40000, // all amount in cents
      "product_price_incl_tax": 48400,
      "product_tax_rate_percentage": "21.00"
    },
    {
      "quantity": 1,
      "product_id": "SHPNG",
      "product_name": "Shipping costs",
      "product_description": "Shipping costs",
      "product_price_excl_tax": 400,
      "product_price_incl_tax": 484,
      "product_tax_rate_percentage": "21.00"
    }
  ],
  "external_webshop_uid": WEBSHOP_UID,
  "external_order_uid": "7304421653023",
  "amount": 48884,
  "currency": "EUR",
  // "locale": "nl", // optional, default is English
  "buyer_company": {
    "name": "My Cool Company B.V.",
    "registration_number": "001234567000",
    "country": "NL"
  },
  "buyer_representative": {
    "first_name": "John",
    "last_name": "Doe",
    "email": "john.doe@my-cool-company.nl",
    "phone_number": "+31612345678"
  },
  "shipping_address": {
    "street": "Teststraat",
    "house_number": "1",
    "city": "Gröningen", // Groningen
    "postal_code": "9711 TT",
    "country": "NL"
  },
  "billing_address": {
    "street": "Teststraat",
    "house_number": "1",
    "city": "Groningen",
    "postal_code": "9711 TT",
    "country": "NL"
  },
  "seller_urls": {
    "success_url": SUCCESS_URL,
    "error_url": ERROR_URL,
    "cancel_url": CANCEL_URL,
  },
  "webhook_urls": {
    "webhook_url": WEBHOOK_URL
  }
};

axios
  .post(
    AUTH_URL, { username: USERNAME, password: PASSWORD }
  )
  .then(res => {
    console.log('data', res.data['access'])
    axios
      .post(
        API_URL,
        PAYLOAD,
        { headers: { 'Authorization': `Bearer ${res.data['access']}` } }
      )
      .then(res => {
        console.log(`statusCode: ${res.status}`)
        console.log(res)
      })
      .catch(error => {
        console.error(error)
      });
  })
  .catch(error => {
    console.error(error.data)
  });


