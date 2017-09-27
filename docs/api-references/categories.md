## Category - API

### `GET` List Category
```
/api/categories
```
Get all categories list
#### Request Header

| Key | Value |
|---|---|
|Accept|application/json

#### Sample Response
```json
{
    "total": 30,
    "per_page": 15,
    "current_page": 1,
    "last_page": 2,
    "next_page_url": "http://link-to-host.com/api/categories?page=2",
    "path": "http://link-to-host.com/api/categories",
    "prev_page_url": null,
    "from": 1,
    "to": 15,
    "data": [
        {
            "id": 1,
            "name": "Dare, Beahan and Botsford",
            "description": "Optio ad aspernatur quis. Alias quae quo ea est. Dolores laudantium tempore fugiat odio placeat."
        },
        {
            "id": 2,
            "name": "Roberts-Wolf",
            "description": "Tempore explicabo enim repellendus. Quaerat velit delectus quam explicabo aut et. Perferendis molestiae suscipit explicabo est eum mollitia voluptate. Eum beatae non aut et sunt quisquam."
        },
        {
            "id": 3,
            "name": "Schoen Ltd",
            "description": "Sed sunt nesciunt ut distinctio amet. Dolorem et omnis iure aliquid molestiae. Dolorum officiis pariatur dolores exercitationem nemo in numquam. Quasi sed quia aut enim."
        },
        {
            "id": 4,
            "name": "Mertz-Crist",
            "description": "Enim minus in et aut est aut. Debitis et voluptatem ut id dolores possimus. Fugit labore id cumque. Provident accusamus soluta accusantium eum occaecati."
        },
        {
            "id": 5,
            "name": "O'Kon PLC",
            "description": "Quis commodi qui cum a facilis quasi et. Blanditiis eum quam consequatur in exercitationem. Quis a quibusdam accusantium veniam. Ut qui voluptas velit aut harum."
        },
        {
            "id": 6,
            "name": "Bailey-Wuckert",
            "description": "Sit consequatur repellat illum libero quasi sint laudantium. Doloribus ut voluptatem amet est laudantium occaecati. Sunt maiores officia dolorem aut sit est accusantium."
        },
        {
            "id": 7,
            "name": "Auer-Kunde",
            "description": "Aut non at dolorum omnis illum autem. Deserunt esse accusantium dolorem neque. Voluptatum distinctio atque voluptas asperiores nihil molestiae recusandae. Eum omnis incidunt maiores et dolor sint. Nostrum provident dolor quaerat porro nemo nobis."
        },
        {
            "id": 8,
            "name": "Legros-Kling",
            "description": "Dolores quo omnis eos voluptatem esse totam. Fuga quia voluptas aut possimus quidem aliquam. Sed doloremque et et enim. Aspernatur numquam enim nihil ipsum dolor."
        },
        {
            "id": 9,
            "name": "Hermann Ltd",
            "description": "Vel consequatur quia quae. Aut quo saepe non. Sint distinctio ipsa voluptas earum exercitationem nemo voluptas eos."
        },
        {
            "id": 10,
            "name": "Lubowitz PLC",
            "description": "Porro tempore et molestiae ex modi praesentium non. Quia tempora magnam est eveniet dolorum."
        },
        {
            "id": 11,
            "name": "Gorczany-Brekke",
            "description": "Quidem aspernatur accusamus nihil rerum ea consequatur molestiae molestiae. Porro nostrum ab velit nihil. Voluptatem quasi laudantium libero rem voluptatibus. Ea quidem quidem dicta eius molestiae sit. Quia aut quia quo fugiat voluptas et voluptatum."
        },
        {
            "id": 12,
            "name": "Rice PLC",
            "description": "Maxime maxime molestiae fugit culpa. Minima vel dolor sed voluptatum aut dignissimos est. Qui eos expedita quia accusantium."
        },
        {
            "id": 13,
            "name": "Marks and Sons",
            "description": "Placeat itaque voluptatem animi perferendis quis tempora est. Praesentium nihil voluptatem et tempore. Cupiditate nisi consequatur est praesentium libero. Laboriosam quas eius et atque dolores qui."
        },
        {
            "id": 14,
            "name": "Gorczany and Sons",
            "description": "Quidem est sit dolore sed deleniti voluptatem. Hic ex placeat fugiat aut blanditiis rerum. Architecto vel reprehenderit est molestiae repellendus corporis veniam. Fugit amet ut inventore."
        },
        {
            "id": 15,
            "name": "Abbott, Torp and Heller",
            "description": "Eveniet corporis dolorum iste sit et enim ea. Unde est ducimus aut minus repudiandae. Ex architecto cum aut omnis est earum sunt. Voluptatibus quisquam ullam reprehenderit aliquam."
        }
    ],
    "success": true
}

```

### `GET` Category Detail
```
/api/categories/{id}
```
Get all informations about this category
#### Request Header
| Key | Value |
|---|---|
|Accept|application/json

#### Sample Response
```json
{
    "data": {
        "id": 12,
        "name": "Rice PLC",
        "description": "Maxime maxime molestiae fugit culpa. Minima vel dolor sed voluptatum aut dignissimos est. Qui eos expedita quia accusantium."
    },
    "success": true
}
```
