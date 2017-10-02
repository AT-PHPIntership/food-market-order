# GET DATA WITH SEARCH AND WITH
## Syntax convention 
### Search module

#### RULE

**Search**

```
    .../foods?search=keyword
```

- The query has something like this:

```mysql
    SELECT 
            *
        FROM
            `foods`
        WHERE
            `foods`.`name` LIKE '%keyword%'
                OR `foods`.`description` LIKE '%keyword%'
```

***condition***

```
    .../foods?search=|name:ca%20ngu-category_id:23
```
- Query:

```mysql
    SELECT 
            *
        FROM
            `foods`
        WHERE
          `foods.name` = 'ca ngu'
                AND `foods.category_id` = 23
```
***Search with condition***

```
    .../foods?search=keyword|name:ca%20ngu-category_id:23
```

- Query will have something like this

```mysql
    SELECT 
        *
    FROM
        `foods`
    WHERE
        (`foods`.`name` LIKE '%keyword%'
            OR `foods`.`description` LIKE '%keyword%')
            AND `foods.name` = 'ca ngu'
            AND `foods.category_id` = 23
```

- The Response will like this

```json
{
  "id": 1,
  "name": "ca ngu",
  "category_id": 23,
  "description": "des"
}
```
**Join**

```
    .../materials?join=categories*category_id:id;suppliers*supplier_id:id
```

- Explain: the table `materials` `left join` with table `categories` as column `category_id` of `materials` equals column `id` of `categories`, and `left join` with table `suppliers` as column `supplier_id` of `materials` equals column `id` of `suppliers`

- Query:

```mysql
    SELECT 
        *
    FROM
        `materials`
            LEFT JOIN
        `categories` ON `materials`.`category_id` = `categories`.`id`
            LEFT JOIN
        `suppliers` ON `materials`.`supplier_id` = `suppliers`.`id`
```

**SearchField**

```
    .../users?search=keyword&searchField=name-category_id-description
```

- Explain: search keyword in column name, category_id and description of table foods

- Query:

```mysql
    SELECT 
        *
    FROM
        `foods`
    WHERE
        `foods`.`name` LIKE '%keyword%'
            OR `foods`.`category_id` LIKE '%keyword%'
            OR `foods`.`description` LIKE '%keyword%'
```
- If want to search with column of another table has joins with current table:

```
    .../foods?search=keyword&searchField=food*name-description;categories*name&join=categories*category_id:id
```
- Query:

```mysql
    SELECT 
        *
    FROM
        `foods`
            LEFT JOIN
        `categories` ON `foods`.`category_id` = `categories`.`id`
    WHERE
        `foods`.`name` LIKE '%keyword%'
            OR `foods`.`description` LIKE '%keyword%'
            OR `categories`.`name` LIKE '%keyword%'

```

**Filter**

```
    .../foods?filter=name-description
```

- Explain: just get data of 2 column name, description of table foods

- The query like this:

```mysql
    SELECT 
        `foods`.`name`, `foods`.`description`
    FROM
        `foods`
```
- If want to filter with column of another table has joins with current table:

```
   .../foods?join=categories*category_id:id&filter=foods*name;category*name as category_name 
```
- Query:

```mysql
    SELECT 
        `foods`.`name`, `categories`.`name` AS `category_name`
    FROM
        `foods`
            LEFT JOIN
        `categories` ON `foods`.`category_id` = `categories`.`id`
```

**OrderBy**

```
    .../foods?orderBy=id:desc-name:asc
```
- Explain : use order by with column id of table foods is desc, column name of table foods is asc

```mysql
    SELECT 
        *
    FROM
        `foods`
    ORDER BY `foods`.`id` DESC , `foods`.`name` ASC
```

- If want to order by with column of another table has join with current table

```
    .../foods?join=categories*category_id:id&orderBy=categories*id:asc;foods*id:desc-name:asc
```
- Query:

```mysql
    SELECT 
        *
    FROM
        `foods`
            LEFT JOIN
        `categories` ON `foods`.`category_id` = `categories`.`id`
    ORDER BY `categories`.`id` ASC , `foods`.`id` DESC , `foods`.`name` ASC
``` 

### With-relations function
#### RULE

- For Example:

```
    .../users/with=posts*id-title-comments:id~user_id
```

- `posts` : the relation ship of users
- `id`, `title`: the column of table relation to get data of table posts
- `comment`: the relation ship of posts
g- `id`, `user_id`: the column of table relation to get data of table comments

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
  }
}
```

