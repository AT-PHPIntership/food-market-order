## Cart - API

### `GET` Refresh Item In Cart
```
api/carts
```
Refresh item in cart.
#### Request header
| Key | Value |
|---|---|
| Accept | application/json |
| Content-type | application/json |
#### Sample Request
```
GET: api/carts?foods=2,33&materials=21,33
```
#### Sample Response
```json
{
    "data":{
          "foods": [
                {
                    "id": 2,
                    "name": "Food 2",
                    "price": 5200.00,
                    "image": "https://lorempixel.com/640/480/?78294"		
                },
                {
                    "id": 33,
                    "name": "Food 33",
                    "price": 4200.00,
                    "image": "https://lorempixel.com/640/480/?74294"		
                }
          ],
          "materials": [
                {
                    "id": 21,
                    "name": "Material 21",
                    "price": 5200.00,
                    "image": "https://lorempixel.com/640/480/?78294"
                },
                {
                    "id": 33,
                    "name": "Material 33",
                    "price": 4200.00,
                    "image": "https://lorempixel.com/640/480/?74294"
                }
          ] 
    },
    "success": true
}
```
