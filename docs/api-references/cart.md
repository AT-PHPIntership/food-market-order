## Cart - API

### `POST` Get Food List In Cart
```
api/carts/getCartFoods
```
Get food list in cart.
#### Request header
| Key | Value |
|---|---|
| Accept | application/json |
| Authorization | {token_type} {access_token} |

#### Sample Request
```json
[2,33]
```

#### Sample Response
```json
{
    "data": [
        {
            "id": 2,
            "name": "Food 2",
            "price": 5200.00,
            "image": "https://lorempixel.com/640/480/?78294",
            "status": 1			
        },
        {
            "id": 33,
            "name": "Food 33",
            "price": 4200.00,
            "image": "https://lorempixel.com/640/480/?74294",
            "status": 1			
        }
    ] ,
    "success": true
}

```

### `POST` Get Material List In Cart
```
api/carts/getCartMaterials
```
Get material list in cart.
#### Request header
| Key | Value |
|---|---|
| Accept | application/json |
| Authorization | {token_type} {access_token} |

#### Sample Request
```json
[21,33]
```

#### Sample Response
```json
{
    "data": [
        {
            "id": 21,
            "name": "Material 21",
            "price": 5200.00,
            "image": "https://lorempixel.com/640/480/?78294",
            "status": 1			
        },
        {
            "id": 33,
            "name": "Material 33",
            "price": 4200.00,
            "image": "https://lorempixel.com/640/480/?74294",
            "status": 1			
        }
    ] ,
    "success": true
}

```
