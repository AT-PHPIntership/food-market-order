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