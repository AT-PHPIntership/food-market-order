## Statistic - API

### `GET` List Resources Count Value
```
/api/statistics/counts
```
Count data for Category, DailyMenu, Food, Material, Order, Supplier, User
#### Request Header

| Key | Value |
|---|---|
|Accept|application/json

#### Sample Response
```json
{
    "data": {
        "categories": 30,
        "daily-menus": 58,
        "foods": 89,
        "materials": 42,
        "orders": 50,
        "suppliers": 4,
        "users": 92
    },
    "success": true
}
```
### `GET` List Trend Food and Material
```
/api/statistics/trends
```
Get data for Foods and Materials was orderest by user
#### Request Header

| Key | Value |
|---|---|
|Accept|application/json

#### Sample Response
```json
{
    "data": {
        "foods": [
            {
                "id": 43,
                "name": "Ellie Schamberger DVM",
                "category_id": 18,
                "price": "57.00",
                "image": "http://link-to-host.com/images/foods/echxaoxasot.jpg",
                "description": "Description",
                "total_order": 20
            },
            {
                "id": 44,
                "name": "Ellie Scotfield",
                "category_id": 19,
                "price": "56.00",
                "image": "http://link-to-host.com/images/foods/echxaoxasot1.jpg",
                "description": "Description2",
                "total_order": 19
            },
            {
                "id": 45,
                "name": "DVM",
                "category_id": 18,
                "price": "59.00",
                "image": "http://link-to-host.com/images/foods/echxaoxasot2.jpg",
                "description": "Description",
                "total_order": 18
            },
            {
                "id": 46,
                "name": "Ellie",
                "category_id": 19,
                "price": "56.00",
                "image": "http://link-to-host.com/images/foods/echxaoxasot3.jpg",
                "description": "Description2",
                "total_order": 17
            },
            {
                "id": 47,
                "name": "Scotfield",
                "category_id": 19,
                "price": "56.00",
                "image": "http://link-to-host.com/images/foods/echxaoxasot4.jpg",
                "description": "Description2",
                "total_order": 16
            }
        ],
        "materials": [
            {
                "id": 43,
                "name": "Ellie Schamberger DVM",
                "category_id": 18,
                "price": "57.00",
                "image": "http://link-to-host.com/images/materials/echxaoxasot.jpg",
                "description": "Description",
                "total_order": 30
            },
            {
                "id": 44,
                "name": "DVM",
                "category_id": 21,
                "price": "57.00",
                "image": "http://link-to-host.com/images/materials/echxaoxasot1.jpg",
                "description": "Description",
                "total_order": 25
            },
            {
                "id": 45,
                "name": "Ellie",
                "category_id": 18,
                "price": "57.00",
                "image": "http://link-to-host.com/images/materials/echxaoxasot2.jpg",
                "description": "Description",
                "total_order": 23
            },
            {
                "id": 46,
                "name": "Schamberger",
                "category_id": 20,
                "price": "57.00",
                "image": "http://link-to-host.com/images/materials/echxaoxasot3.jpg",
                "description": "Description",
                "total_order": 21
            },
            {
                "id": 47,
                "name": "Scoff",
                "category_id": 20,
                "price": "57.00",
                "image": "http://link-to-host.com/images/materials/echxaoxasot4.jpg",
                "description": "Description",
                "total_order": 20
            }
        ]
    },
    "success": true
}
```