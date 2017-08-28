## Food Api
### `GET` Food
```
/foods/{id}
```
Get infomation about a food
#### Request Header
| Key | Value |
|---|---|
|Accept|application\json
#### Response
```json
{
	"data": {
		"id": 1,
		"name": "Material",
		"category_id": 1,
		"price": 10000,
		"description": "descrition about material",
		"image": "http://food-ordermatrket/image_name.jpg"
	},
	"susccess": true,
	"status": 200
}
```
### `GET` List Foods
```
/foods
```
Get information list all foods

#### Request Header
| Key | Value |
|---|---|
|Accept|application\json

#### Response
```json
{
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "name": "Isac Goyette",
                "category_id": 7,
                "price": "47.00",
                "image": "http://laravel-foodorder.com/images/foods/https://lorempixel.com/640/480/?48502",
                "description": "Ratione explicabo itaque doloremque consectetur eum. Neque voluptate aliquam et expedita pariatur aut quia. Possimus ut eveniet quod id. Harum omnis nemo nihil."
            },
            {
                "id": 2,
                "name": "Dr. Fausto Anderson",
                "category_id": 18,
                "price": "35.00",
                "image": "http://laravel-foodorder.com/images/foods/https://lorempixel.com/640/480/?25450",
                "description": "Ea rem quia et voluptatem nisi dolorem. Odit doloremque ratione doloremque nisi voluptatem ut. Deleniti nihil aliquam eius soluta eveniet. Et temporibus illum fugiat iste corporis aliquid ut aspernatur."
            },
            {
                "id": 3,
                "name": "Maci Morissette",
                "category_id": 10,
                "price": "83.00",
                "image": "http://laravel-foodorder.com/images/foods/https://lorempixel.com/640/480/?45492",
                "description": "Eveniet quia deleniti sunt temporibus. Voluptatem qui qui aperiam facilis dolores rem sunt. Quia facere et consequuntur."
            },
            {
                "id": 4,
                "name": "Miss Lorna Hettinger",
                "category_id": 4,
                "price": "38.00",
                "image": "http://laravel-foodorder.com/images/foods/https://lorempixel.com/640/480/?64283",
                "description": "Non cum et possimus et id. Est numquam et ipsam. Iusto possimus vel natus magnam aut omnis. Soluta culpa neque minus ea suscipit quos. Facere nemo est qui tempora impedit at adipisci."
            },
            {
                "id": 5,
                "name": "Maegan Mills V",
                "category_id": 9,
                "price": "71.00",
                "image": "http://laravel-foodorder.com/images/foods/https://lorempixel.com/640/480/?17548",
                "description": "Accusantium eos impedit soluta molestiae laborum. Omnis qui et reprehenderit ea ut non. Natus ea alias tempora eum esse fugit autem."
            },
        ],
        "from": 1,
        "last_page": 6,
        "next_page_url": "http://laravel-foodorder.com/api/foods?page=2",
        "path": "http://laravel-foodorder.com/api/foods",
        "per_page": 10,
        "prev_page_url": null,
        "to": 10,
        "total": 51
    },
    "success": "true"
}
```
