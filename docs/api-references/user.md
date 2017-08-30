## Food - Example API

### `GET` Food
```
/foods/{id}
```
Get information about a food.

#### Sample Response
```json
{
    "data": {
        "id": 123,
        "name": "Foooood",
        "category_id": 2,
        "price": 1000,
        "description": "",
        "image": "http://link-to-image.com/image_name.npg"
    },
    "success": true,
    "status": 200
}
```

### `POST` Food
```
/foods
```
Create a food

#### Parameters
| Key | Type | Required | Description |
|---|---|---|---|
| name | String | required | Name of food |
| category_id | Integer | required | Category ID |
| price | Decimal | required | Price of food |
| description | String | optional | Description |
| image | String | optional | Image |

#### Sample Request
```json
{
    "name": "Foooood",
    "category_id": 2,
    "price": 1000,
    "description": "",
    "image": "image_name.npg"
}
```

#### Sample Response
```json
{
    "data": {
        "id": 123,
        "name": "Foooood",
        "category_id": 2,
        "price": 1000,
        "description": "",
        "image": "http://link-to-image.com/image_name.npg"
    },
    "success": true,
    "status": 201
}
```
