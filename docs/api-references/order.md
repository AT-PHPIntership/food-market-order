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
### `GET` Order by User Current
```
/api/orders
```
Get order item of a order.

#### Request header
| Key | Value |
|---|---|
| Accept | application/json |
| Authorization | {token_type} {access_token} |

#### Sample Response
```json
{
  "current_page": 1,
  "data": [
      {
          "id": 51,
          "status": 1,
          "created_at": "2017-09-19 02:02:48",
          "total_price": "0.00"
      },
      {
          "id": 52,
          "status": 1,
          "created_at": "2017-09-19 02:27:17",
          "total_price": "0.00"
      },
      {
          "id": 53,
          "status": 1,
          "created_at": "2017-09-19 02:28:41",
          "total_price": "0.00"
      },
      {
          "id": 54,
          "status": 1,
          "created_at": "2017-09-19 02:29:03",
          "total_price": "2440.00"
      }
  ],
  "from": 1,
  "last_page": 1,
  "next_page_url": null,
  "path": "http://192.168.33.10/api/orders",
  "per_page": 10,
  "prev_page_url": null,
  "to": 4,
  "total": 4
}
```

### `GET` Order Item of A Order
```
/api/orders/{id}/getItems
```
Get order item of a order.

#### Request header
| Key | Value |
|---|---|
| Accept | application/json |
| Authorization | {token_type} {access_token} |

#### Sample Response
```json
{
  "data": {
    "id": 74,
    "user_id": 3,
    "created_at": "1999-02-16 03:27:10",
    "updated_at": "1999-02-16 03:27:10",
    "trans_at": "1999-02-16 06:33:10",
    "total_price": 92500,
    "status": 2,
    "address": "140 Hoàng Diệu, Tp Đà Nẵng",
    "order_items": [
    	{
    		"id": 23,
    		"itemtable_type": "App\\Food",
    		"itemtable_id": 34,
            "quantity": 10,
            "order_id": 74,
    		"itemtable" : {
    			"id": 34,
                "name": "Food 34",
                "price": 5500.00,
                "image": "https://lorempixel.com/640/480/?78294",
                "status": 1
    		}
    	},
		{
            "id": 42,
            "itemtable_type": "App\\Food",
            "quantity": 5,
            "itemtable_id": 14,
            "order_id": 74,
            "itemtable" : {
            	"id": 14,
            	"name": "Food 14",
            	"price": 7500.00,
            	"image": "https://lorempixel.com/640/480/?52948",
            	"status": 1
            }
        }
    ]
  },
  "success": true
}

```

### `PUT` Update Order
```
api/orders/{id}
```
Update order from client.
#### Request Header
| Key | Value |
|---|---|
| Accept | application/json |
|Content-Type| application/json |
| Authorization | {token_type} {access_token} |
#### Parameters
| Key | Type | Required | Description |
|---|---|---|---|
| address_ship | String | required | Address shipping |
| trans_at | String | required | Time shipping |
| items | Array | required | List item |
#### Sample Request
```json
{
	"address_ship": "33 Trần Quý Cáp",
	"trans_at": "2017-09-13 11:30:00",
	"items": [ 
		{ 
			"id" : 15,
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
		"user_id": 1,
		"address_ship": "33 Trần Quý Cáp",
		"total_price": 50000 
	},
	"success": true
}
```
