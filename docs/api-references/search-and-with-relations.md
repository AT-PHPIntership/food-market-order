#GET DATA WITH SEARCH AND WITH
##Syntax convention 
###Search module

#### RULE

**Search**

```links
    .../users/search=keyword|users*name:Dung%20Van-age:23
    // Or like this if not have joins with another table:
    .../users/search=keyword|name:Dung%20Van-age:23
```

- Query will have something like this

```mysql
    SELECT * FROM `users` WHERE (`users.name` LIKE "%keyword%" OR ... LIKE "%keyword%" ...) 
    AND `users.name` = 'Dung Van' AND `users.age` = 20
```

- The Response will like this

```json
{
  "id": 1,
  "name": "Dung Van",
  "age": 20,
  "gender": "male"
}
```
**Join**

```
    .../users/join=posts*post_id:id;comment*comments_id:id
```

- Query:

```mysql
    SELECT * FROM `users` LEFT JOIN `posts` ON `users`.`post_id` = `posts`.`id`
    LEFT JOIN `comments` ON `users`.`comment_id` = `comments`.`id`
```

**SearchField**

```
    .../users/search=keyword&searchField=users*name-age-address
    -- Or like this if not have joins with another table:
    .../users/search=keyword&searchField=name-age-address
```

- Explain: search keyword in column name, age and address of table users

- Query:

```mysql
    SELECT * FROM `users` WHERE `users`.name LIKE "%keyword%" OR age LIKE "%keyword%" OR address LIKE "%keyword%"
```

**Filter**

```
    .../users/filter=users*id-name-age
    -- OR like this if not have joins with another table or no-conflict column name:
    .../users/filter=id-name-age
```

- Explain: just get data of 3 column id, name, age of table users

- The query like this:

```mysql
    SELECT `users`.`id`, `users`.`name`, `users`.`age` FROM `users`
```

**OrderBy**

```
    .../users/orderby=users*id:desc-name:asc
```
- Explain : use order by with column id of table users is desc, column name of table users is asc

```mysql
    SELECT * FROM `users` ORDER BY `users`.`id` DESC, `users`.`name` ASC
```

####Example

```
    .../users/search=dung|users*age:23-gender:male&join=posts*post_id:id
    &searchField=user*name&filter=users*id-name-age-gender;post*id&orderBy=users*id:desc
```

- This is the full query:

```mysql
  SELECT `users`.`id`, `users`.`name`, `users`.`age`, `users`.`gender`, `posts`.`id`
  FROM `users` LEFT JOIN `posts` ON `users`.`post_id` = `posts`.`id`
  WHERE `users`.`name` LIKE "%dung%" AND `users`.`age` = 23 AND `users`.`gender` = 'male'
  ORDER BY `users`.`id` DESC
```

###With-relations function
####RULE

```
    .../users/with=posts*id-title-comments:id~user_id
```

- `posts` : the relation ship of users
- `id`, `title`: the column of table relation to get data of table posts
- `comment`: the relation ship of posts
- `id`, `user_id`: the column of table relation to get data of table comments

- The response will have something like this

```json
{
  "id": 1,
  "name": "Dung Van",
  "posts": {
    "id": 5,
    "title": "post 1",
    "comments": {
      "id": 7,
      "user_id": 3
    }
    ...
  }
  ...
}
```

