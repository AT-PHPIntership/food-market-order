## Image

### Post upload image
- Url: `/images`
- Method: `POST`

#### Params
|Name|Type|Required|Example
|---|---|---|---
|image|the image form data|yes||
|type|int|yes|1: profile, 2: post, 3: post_image, 4: system|

###### Validation
|Target|Rule|
|---|---|
|image|required, image, mine:jpg/png/jpeg/gif, max_size:20MB|
|type|required, in:(1, 2, 3, 4)|

#### Response
```json
{
    "name": "3782D29D-B62E-41D1-AEAD-7FB7AE7A4E3A.jpg",
    "thumbnail": "https://s3..../3782D29D-B62E-41D1-AEAD-7FB7AE7A4E3A.jpg",
    "original": "https://s3..../3782D29D-B62E-41D1-AEAD-7FB7AE7A4E3A.jpg",
}
```
