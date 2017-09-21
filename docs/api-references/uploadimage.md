### Upload Image API
#### `POST` Image

```
/api/users/upload-image
```
**Upload image**

##### Request header
| Key | Value |
|---|---|
| Accept | application/json |
| Content-Type | image/* |
| Authorization | {token_type} {access_token} |

##### Request parameter
| Key | Description |
|---|---|
| file |  A binary file (up to 10Mb) |

##### Response parameter

| Key | Type | Description |
|---|---|---|
| file_name | string | the name of image |

##### Sample Response the name of file save success
```json
{
  "file_name": "1505789329number-1.png"
}
```

**Remove image**

##### Request header
| Key | Value |
|---|---|
| Accept | application/json |
| Content-Type | application/json |
| Authorization | {token_type} {access_token} |

##### Sample Request body
```json
{
  "file_name": "fileName.jpg"
}
```

##### Sample Response

```json
{
  "success": true
}
  
```

or

```json
{
  "success": false,
  "message": "Error during remove image"
  
}
```
