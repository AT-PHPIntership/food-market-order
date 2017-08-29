## Daily Menu - API

### `GET` List Daily Menu
```
/daily-menus
```
Get all daily menu list
#### Request Header
| Key | Value |
|---|---|
|Accept|application/json

#### Sample Response
```json
{
    "total": 1,
    "per_page": 15,
    "current_page": 1,
    "last_page": 1,
    "next_page_url": null,
    "path": "http://link-to-host.com/api/daily-menus",
    "prev_page_url": null,
    "from": 1,
    "to": 1,
    "data": [
	    {
		"date": "2017-09-02"
	    },
	    {
	    "date": "2017-09-01"
	    },
	    {
	    "date": "2017-08-31"
	    }
	],
	"success": true
}
```

### `GET` Daily Menu Detail
```
/daily-menus/{date}
```
Get all informations about daily menu was given by date
#### Request Header
| Key | Value |
|---|---|
|Accept|application/json

#### Sample Response
```json
{
    "total": 1,
    "per_page": 15,
    "current_page": 1,
    "last_page": 1,
    "next_page_url": null,
    "path": "http://link-to-host.com/api/daily-menus/2017-09-14",
    "prev_page_url": null,
    "from": 1,
    "to": 1,
    "data": [
        {
            "id": 86,
            "food_id": 43,
            "quantity": 6,
            "date": "2017-09-14",
            "created_at": "2017-08-18 09:55:25",
            "updated_at": "2017-08-24 05:51:41",
            "deleted_at": null,
            "food": {
                "id": 43,
                "name": "Ellie Schamberger DVM",
                "category_id": 18,
                "price": "57.00",
                "description": "At nostrum est tempore mollitia ut. Optio magni delectus culpa et.",
                "image": "http://link-to-host.com/images/foods/echxaoxasot.jpg",
                "created_at": "2017-07-31 13:58:02",
                "updated_at": "2017-07-31 13:58:02",
                "category": {
                    "id": 18,
                    "name": "Smith-Block",
                    "description": "Ad inventore quae consequatur unde eos similique.",
                    "created_at": "2017-07-31 13:58:02",
                    "updated_at": "2017-07-31 13:58:02"
                }
            }
        }
    ],
    "success": true
}
```