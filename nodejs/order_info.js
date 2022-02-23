/**
 * Make sure to install the requirements:
 *
 *     $ npm install axios
 */

const axios = require('axios');

const USERNAME = "";  // your username
const PASSWORD = "";  // your password
const HOSTNAME = "https://api.sandbox.biller.ai";  // for prod use https://api.biller.ai/
const ORDER_UUID = "";  // your order UUID

auth_url = HOSTNAME + "/v1/api/token/";
order_info_url = HOSTNAME + "/v1/api/orders/" + ORDER_UUID;
auth_payload = { "username": USERNAME, "password": PASSWORD };

axios
  .post(auth_url, auth_payload)
  .then(auth_res => {
    token = auth_res.data.access;
    config = { "headers": { "Authorization": "Bearer " + token } };
    axios.get(order_info_url, config)
        .then(order_info_res => {
            console.log(order_info_res.data)
        })

  })
  .catch(error => {
    console.error(error)
  });