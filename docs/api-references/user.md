## User API

### `GET` User
```
/api/users/me
```
Get information about a current user login.

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
    "full_name": "dungvan2512",
    "email": "dungvan@test.email.com",
    "birthday": null,
    "gender": 0,
    "address": null,
    "phone_number": null,
    "image": "http://foodmarket.com/images/users/default.jpg",
    "is_admin": 1,
    "is_active": 0,
    "created_at": "2017-09-01 02:22:32",
    "updated_at": "2017-09-01 02:22:32",
    "deleted_at": null
  },
  "success": true
}
```

### `Post` user
```
/api/users
```
Registry a user

#### Parameters
| Key | Type | Required | Description |
|---|---|---|---|
| full_name | String | required | Name of user |
| email | String | required | email to login |
| password | String | required | password |
| password_confirmation | String | required | password confirmation |

#### Request header
| Key | Value |
|---|---|
| Accept | application/json |
|Content-Type| application/json |

#### Sample Request body
```json
{
  "full_name": "Van Duc Dung",
  "email": "vandung@test.email.com",
  "password": "123456",
  "password_confirmation": "123456"
}
```

#### Sample Response
```json
{
  "data": {
    "id": 74,
    "full_name": "dungvan2512",
    "email": "dungvan@test.email.com",
    "birthday": null,
    "gender": 0,
    "address": null,
    "phone_number": null,
    "image": "http://foodmarket.com/images/users/default.jpg",
    "is_admin": 1,
    "is_active": 0,
    "created_at": "2017-09-01 02:22:32",
    "updated_at": "2017-09-01 02:22:32",
    "deleted_at": null
  },
  "success": true
}
```
### `Post` user login

```
/api/users/login
```
Login system

#### Parameters
| Key | Type | Required | Description |
|---|---|---|---|
| email | String | required | email to login |
| password | String | required | password |

#### Request header
| Key | Value |
|---|---|
| Accept | application/json |
| Content-Type | application/json |

#### Sample Request body
```json
{
  "email": "vudang@gmail.com",
  "password": "123456"
}
```

#### Sample Response
```json
{
  "data": {
    "token_type": "Bearer",
    "expires_in": 1295999,
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjFhYTRjODhjN2ViMzUyYjZlZjcyMDVmMWY1MjE5ZTUwOTcxNTlmYTgwNjRmMmIwNTlhZGQ5NzZhOWIzYWIzMWEyZmRiNWIzMDA0ZmYwNTkyIn0.eyJhdWQiOiIyIiwianRpIjoiMWFhNGM4OGM3ZWIzNTJiNmVmNzIwNWYxZjUyMTllNTA5NzE1OWZhODA2NGYyYjA1OWFkZDk3NmE5YjNhYjMxYTJmZGI1YjMwMDRmZjA1OTIiLCJpYXQiOjE1MDQyMjQyNDcsIm5iZiI6MTUwNDIyNDI0NywiZXhwIjoxNTA1NTIwMjQ2LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.dWV3xbSfV_yl-oDEtxtkjyjfY0YovJ_TWE544-yFLP-PqtcXbfaGmxqGq5XhHGlo4HnOuCImHQmC602flFpryN0svlMiBRtKQwgAIwlI0dIS9qK2FK5DRFLPrytqYbVI5bVQ0QQ0mB0R4AUGVugt1l6MAaEw2POQkLqNxGJiQRUm-8A4QXIr1vex5U5V7V4OQxI2S1DAFWrZcn1UuAGB3VdGPSl1M95TnkWZ92-Wu6nPrmEoMFpp6EiHDYvIJ0ooU2-OC88S-P52rg_zspklIeZpvr98HfR6PhT1WscLHaR-dyga9MgrL2pYzJK1",
    "refresh_token": "def5020085af64a088aebc71c4746a7ec59fc7a92e40fcd48c225f464ccb0b45ee88fd89c867486eec01f2dd99adb76fceb04a0c4dca4e6bc849252f382c0404a358a602532cb55084f029f3e746450ec2d1e479c9eca263c93ec1e58c564c2abc1dfdd545810113bee9bda63da933cc84a1a131a7bdfe906d01195a9fdbd63e93bc543a098c99c20388fbbee9d949adbb7ec7167fd0da9d002c5fcd8c109efc75f83c424677757704d484b9322dbc02c292db9dcf72c30b8e6ea7237ece39bfc5015e1fe948a63913b9e2bd6037780d51bc5c193825c8917ee06e3e6c711a41c44c8f326e91c0a4a0e180ed3bf82cde06f57895e445e27ba3bed13948b86c1cf845a9b0549d8b02661ae39251d6983cba57292945b1cc3df6031e53a0f6f0aa0060071e81b96f61bbf4ca9a3f3b72abd22dbb9b1f3036f795257767ed8283fd2a4d9088a258749303296dd9085565f99a733a9b3959c5d26fb41dac19a87a"
  },
  "success": true
}
```

### `Put` user
```
/api/users/me
```
Update profile of current user

#### Parameters
| Key | Type | Required | Description |
|---|---|---|---|
| full_name | String | required | Name of user |
| birthday | String | required | email to login |
| gender | Integer | required | Default 0 : female, 1 : male  |
| address | String | required | address of user |
| phone_number | String | required | phone number of user |
| password | String | nullable | password |
| password_confirmation | String | nullable | password confirmation |

#### Request header

| Key | Value |
|---|---|
| Accept | application/json |
|Content-Type| application/json |
| Authorization | {token_type} {access_token} |

#### Sample Request body
```json
{
  "full_name":"dungvan25123",
  "birthday":"1994-03-12",
  "gender":1,
  "address":"DienDuong",
  "phone_number":"123456789"
}
```

#### Sample Response
```json
{
    "success": true
}
```
