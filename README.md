<p align="center">API Laravel 8 Dengan MongoDB 4.2</p>

##Instalation
Laravel 8.XX menggunakan PHP versi 8.1 MongoDB 4.2

1. Clone repository, bisa di download .zip atau dengan perintah git clone seperti ini
```
git clone https://github.com/epeneffendy/inosoft-api.git
```

2. Masuk ke Directori nya
```
cd c:/xampp/htdocs/inosoft-api
```

3. Lakukan intall composer
```
composer install
```

##API
Dokumentasi API bisa di lihat di [postman documentation](https://documenter.getpostman.com/view/25656509/2s93CNMtFD)
### Endpoint Users 
| Method | Path                      | Description                                                                                 | Auth        |
|--------|---------------------------|---------------------------------------------------------------------------------------------|-------------|
| POST   | *`…/register`*            | Registering user and token generated. Request body consist of full_name, email and password | token       |
| POST   | *`…/users/login`*         | User login and token generated. Request body consist email and password                     | token       |
| POST   | *`…/users/me`*          | User edit profile validated with token                                                      | token       |
| POST   | *`…/users/logout`*        | User delete profile validated with token                                                    | token       |




##Resource
1. MongoDB Comunity Server : https://www.mongodb.com/try/download/community

2. PHP MongoDB Extentension : https://windows.php.net/downloads/pecl/releases/mongodb/1.13.0/php_mongodb-1.13.0-8.0-ts-vs16-x64.zip


