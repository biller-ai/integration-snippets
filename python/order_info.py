"""
Make sure to install the requirements:

    $ pip install requests
"""

import requests

USERNAME = ""  # your username
PASSWORD = ""  # your password
HOSTNAME = "https://api.sandbox.biller.ai"  # for prod use https://api.biller.ai/
ORDER_UUID = ""  # your order UUID

auth_url = HOSTNAME + "/v1/api/token/"

auth_response = requests.post(auth_url, {"username": USERNAME, "password": PASSWORD})
token = auth_response.json()["access"]

order_info_url = HOSTNAME + "/v1/api/orders/" + ORDER_UUID
order_info_response = requests.get(order_info_url, headers={"Authorization": "Bearer " + token})
print(order_info_response.json())
