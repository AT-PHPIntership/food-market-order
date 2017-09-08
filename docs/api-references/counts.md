## Counts - API

### `GET` List Count Value
```
/api/counts
```
Get all object and its count value
#### Request Header

| Key | Value |
|---|---|
|Accept|application/json

#### Sample Response
```json
{
    "success": true,
    "data": {
        "Category": 30,
        "DailyMenu": 58,
        "Food": 89,
        "Material": 42,
        "Order": 50,
        "OrderItem": 134,
        "Supplier": 4,
        "User": 92
    }
}
```