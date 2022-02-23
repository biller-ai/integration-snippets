"""
Make sure to install the requirements:

    $ pip install requests
"""

import requests
import json

USERNAME = ''  # YOUR USERNAME
PASSWORD = ''  # YOUR PASSWORD

WEBSHOP_UID = ""  # YOUR_WEBSHOP_UID
SUCCESS_URL = ""  # YOUR_SUCCESS_URL
ERROR_URL = ""  # YOUR_ERROR_URL
CANCEL_URL = ""  # YOUR_CANCEL_URL
WEBHOOK_URL = ""  # YOUR_WEBHOOK_URL

HOST_NAME = 'https://api.sandbox.biller.ai/'  # for prod use https://api.biller.ai/
API_URL = HOST_NAME + 'v1/api/order-request/'
AUTH_URL = HOST_NAME + 'v1/api/token/'


def get_autherzation_key(username: str, password: str) -> str:
    """
    Function to retreive autherzation token from API
    :param username: Username for biller account
    :param password: Password for biller account
    :return: Bearer token from API
    """
    payload = {
        "username": username,
        "password": password
    }

    response = requests.post(
        url=AUTH_URL,
        json=payload
    )

    return json.loads(response.text).get('access')


PAYLOAD = {
    "order_lines": [
        {
            "quantity": 1,
            "product_id": "1441808338558",
            "product_name": "Electric toothbrush",
            "product_description": "Electric toothbrush including brushes.",
            "product_price_excl_tax": 40000,  # all amount in cents
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
    # "locale": "nl",   #  optional, default is English
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
        "city": "Groningen",
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
        "cancel_url": CANCEL_URL
    },
    "webhook_urls": {
        "webhook_url": WEBHOOK_URL
    }
}

token = get_autherzation_key(USERNAME, PASSWORD)
response = requests.post(
    url=API_URL,
    json=PAYLOAD,
    headers={"Authorization": f"Bearer {token}"},
)

print(response.ok)
print()
print(response.json())
