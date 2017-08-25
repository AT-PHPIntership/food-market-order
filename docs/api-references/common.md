Food Market API
=======

# Overview

API document for Food Market
Verion: 1.0

## Post data to server
All request form data must be in `json` format

- Request header `Content-Type`: `application/json`
- Request body content : `json` format.

## Authentication

### Laravel Passport

## Response

### Response code
Reference: https://www.loggly.com/blog/http-status-code-diagram/


### Error response

- `4xx`: client error
- `5xx`: server error

|Status code| Meaning|
|---|---|
|400|Bad request|
|401|Unauthoziration|
|403|Permission denied|
|500|Internal server error|

#### Body response
All response body in case error must follow the format
```json
{
    "message": "The error content message"
}
```

`400` is also used in case validation error

### Maintenance

#### Response
- Status code: 503
- Body:
```json
{
    "message": "Maintenance message"
}
```
# API
## Food - Example API

### `GET` Food
```
/foods/{id}
```
Get information about a food.

#### HEADERS

| Key | Value |
|---|---|
|Authorization|Client-ID {{clientId}}

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

#### Headers

| Key | Value |
|---|---|
|Authorization|Client-ID {{clientId}}

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
