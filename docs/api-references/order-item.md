## OrderItem - API

### `DELETE` Delete An Order Item
```
api/orderitems/{id}
```
Delete an order item of user current.
#### Request Header
| Key | Value |
|---|---|
| Accept | application/json |
|Content-Type| application/json |
| Authorization | {token_type} {access_token} |

#### Sample Response
```json
{
	"data": {
        "id": 23,
        "itemtable_type": "App\\Food",
        "itemtable_id": 34,
        "quantity": 10,
        "order_id": 74,
        "deleted_at": "2017-09-13 11:30:00",
        "itemtable" : {
            "id": 34,
            "name": "Food 34",
            "price": 5500.00,
            "image": "https://lorempixel.com/640/480/?78294",
            "status": 1
        }
    },
	"success": true
}
```
