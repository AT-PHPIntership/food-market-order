## Order - API

### `POST` Add New Order
```
api/orders
```
Add new order from client.
#### Request Header
| Key | Value |
|---|---|
| Accept | application/json |
|Content-Type| application/json |
| Authorization | {token_type} {access_token} |
#### Parameters
| Key | Type | Required | Description |
|---|---|---|---|
| user_id | Integer | required | Id of current user |
| address_ship | String | required | Address shipping |
| type | String | required | Type of item is Food or Material |
| items | Array | required | List item |
#### Sample Request
```json
{
	"user_id": 1,
	"address_ship": "33 Trần Quý Cáp",
	"trans_at": "2017-09-13",
	"type": "App\\Food",
	"items": [ 
		{ 
			"id" : 1,
			"quantity" : 3
		},
		{ 
			"id" : 5,
			"quantity" : 10
		}
	]
}
```
#### Sample Response
```json
{
	"data": {
		"order_id": 123,
		"user_id": 3,
		"address_ship": "33 Trần Quý Cáp",
		"total_price": 50000 
	},
	"success": true
}
```