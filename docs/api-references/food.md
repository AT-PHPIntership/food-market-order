## Food Api
### `GET` Food
```
/api/foods/{id}
```
Get infomation about a food

#### Request Headers

| Key | Value |
|---|---|
|Accept|application\json

#### Response
```json
{
    "data": {
        "id": 123,
        "name": "Foooood",
        "category_id": 2,
        "price": 1000,
        "description": "",
        "image": "http://link-to-image.com/image_name.npg",
        "category": {
            "id": 9,
            "name": "Balistreri, Schaden and Swaniawski"
        }
    },
    "susccess": true
}
```
### `GET` List Foods
```
/foods
```
Get information list all foods
#### Request Headers

| Key | Value |
|---|---|
|Accept|application\json

#### Response
```json
{
    "current_page": 1,
    "from": 1,
    "last_page": 5,
    "next_page_url": "http://laravel-foodorder.com/api/foods?page=2",
    "path": "http://laravel-foodorder.com/api/foods",
    "per_page": 10,
    "prev_page_url": null,
    "to": 10,
    "total": 50,
    "data": [
        {
            "id": 1,
            "name": "Baylee Rodriguez",
            "category_id": 9,
            "price": "41.00",
            "image": "http://laravel-foodorder.com/images/foods/image.png",
            "description": "Neque voluptatem sit eligendi accusantium ad quisquam sit. A maxime non et est accusamus. Magnam et voluptatem et autem minus.",
            "category": {
                "id": 9,
                "name": "Balistreri, Schaden and Swaniawski"
            }
        },
        {
            "id": 2,
            "name": "Elaina Champlin",
            "category_id": 9,
            "price": "29.00",
            "image": "http://laravel-foodorder.com/images/foods/image.png",
            "description": "Non consectetur numquam et molestiae omnis ducimus sed. Qui esse reprehenderit fugit facilis ea et dicta. Est est voluptates impedit. Repellat quia est eaque facilis quo aut eos ea. Perferendis assumenda explicabo est ea.",
            "category": {
                "id": 9,
                "name": "Balistreri, Schaden and Swaniawski"
            }
        },
        {
            "id": 3,
            "name": "Prof. Marquise Romaguera",
            "category_id": 9,
            "price": "43.00",
            "image": "http://laravel-foodorder.com/images/foods/image.png",
            "description": "Est vel dolorem quo odit in veritatis voluptas. Illum similique rerum laudantium unde. Architecto voluptas non in nemo fugiat qui.",
            "category": {
                "id": 9,
                "name": "Balistreri, Schaden and Swaniawski"
            }
        },
        {
            "id": 4,
            "name": "Aron Crooks",
            "category_id": 17,
            "price": "70.00",
            "image": "http://laravel-foodorder.com/images/foods/image.png",
            "description": "Quaerat accusantium quae amet veniam voluptatem possimus. Aspernatur doloremque rem accusantium. Doloremque ut iste a dignissimos vel.",
            "category": {
                "id": 17,
                "name": "Jaskolski-Welch"
            }
        },
        {
            "id": 5,
            "name": "Lulu Koepp",
            "category_id": 1,
            "price": "55.00",
            "image": "http://laravel-foodorder.com/images/foods/image.png",
            "description": "Magnam voluptatem in aliquid voluptates. Velit incidunt exercitationem nobis at quia maiores ut facilis. Labore iure voluptatem commodi praesentium officia.",
            "category": {
                "id": 1,
                "name": "Champlin, Torp and Auer"
            }
        },
        {
            "id": 6,
            "name": "Aglae Gottlieb",
            "category_id": 6,
            "price": "44.00",
            "image": "http://laravel-foodorder.com/images/foods/image.png",
            "description": "Ab animi maxime ullam velit et vero aut. Est placeat sapiente quae temporibus dicta. Maxime rem commodi id rem ratione quidem.",
            "category": {
                "id": 6,
                "name": "Keeling-Fay"
            }
        },
        {
            "id": 7,
            "name": "Mr. Junius Cronin",
            "category_id": 18,
            "price": "58.00",
            "image": "http://laravel-foodorder.com/images/foods/image.png",
            "description": "Molestiae voluptatem omnis eum rerum. Dolorem quos doloremque natus perferendis et. Sint porro enim eum dolore nisi.",
            "category": {
                "id": 18,
                "name": "Johns-Schuster"
            }
        },
        {
            "id": 8,
            "name": "Ottilie Graham",
            "category_id": 9,
            "price": "66.00",
            "image": "http://laravel-foodorder.com/images/foods/image.png",
            "description": "Possimus tempore ipsum iure occaecati accusamus. Non aut laboriosam minus voluptate placeat beatae quia. Expedita nulla impedit nulla praesentium doloremque possimus.",
            "category": {
                "id": 9,
                "name": "Balistreri, Schaden and Swaniawski"
            }
        },
        {
            "id": 9,
            "name": "Fannie Swaniawski I",
            "category_id": 20,
            "price": "27.00",
            "image": "http://laravel-foodorder.com/images/foods/image.png",
            "description": "Qui distinctio saepe quia sunt facilis cumque. Nihil deserunt possimus aut in nesciunt. Illo doloribus delectus consequatur inventore et et. Quia doloribus iste voluptatem et aliquid ipsum ducimus. Natus qui quia possimus quisquam in ab facilis.",
            "category": {
                "id": 20,
                "name": "Kling, Sporer and DuBuque"
            }
        },
        {
            "id": 10,
            "name": "Melyna Champlin II",
            "category_id": 12,
            "price": "22.00",
            "image": "http://laravel-foodorder.com/images/foods/image.png",
            "description": "Quia voluptas dolores ipsam quia. Ut minus corrupti quos voluptas aut voluptatum. Aut omnis sequi sequi voluptatem et reiciendis omnis.",
            "category": {
                "id": 12,
                "name": "Dare, Nicolas and Zboncak"
            }
        }
    ],
    "susccess": true
}
```
