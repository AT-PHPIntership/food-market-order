## Order - API

### `POST` Add New Order
```
api/orders/
```
Add new order from client.
#### Request Header
```
	"Accept": "application/json"
	"Content-type": "application/json"
	"Authorization": "Bearer <access_token>"
```
#### Parameters
| Key | Type | Required | Description |
|---|---|---|---|
| user-id | Integer | required | Id of user |
| address-ship | String | required | Address shipping |
| foods | Array | required | List item food |
| material | Array | required | List item material |
#### Sample Request
```json
{
	"user_id": 1,
	"address_ship": "33 Trần Quý Cáp",
	"foods": [ 
		{ 
			"id" : 1,
			"quantity" : 3
		},
		{ 
			"id" : 5,
			"quantity" : 10
		}
	],
	"materials": [ 
		{ 
			"id" : 10,
			"quantity" : 3
		},
		{ 
			"id" : 3,
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
		"created_at": "2017-02-16 03:27:10",
		"total_price": 50000 
	},
	"success": true,
	"status": 200
}
```