## Cart - API

### `POST` Get Food List In Cart
```
api/carts/foods
```
Get food list in cart.
#### Request header
| Key | Value |
|---|---|
| Accept | application/json |
| Authorization | {token_type} {access_token} |
#### Parameters
| Key | Type | Required | Description |
|---|---|---|---|
| items | Array | required | List id food |
#### Sample Request
```json
{  
    "items":[  
        {  
            "id": 21
        },
        {  
            "id": 33
        }
    ]
}
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
api/carts/materials
```
Get material list in cart.
#### Request header
| Key | Value |
|---|---|
| Accept | application/json |
| Authorization | {token_type} {access_token} |
#### Parameters
| Key | Type | Required | Description |
|---|---|---|---|
| items | Array | required | List id material |
#### Sample Request
```json
{  
    "items":[  
        {  
            "id": 21
        },
        {  
            "id": 33
        }
    ]
}
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
