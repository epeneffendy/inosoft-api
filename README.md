<p align="center">API Laravel 8 Dengan MongoDB 4.2</p>

###Instalation
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

###API
Dokumentasi API bisa di lihat di [postman documentation](https://documenter.getpostman.com/view/2058663/2s93eX1DTb)
### Endpoint Users 
| Method | Path                      | Description                                                                                 | Auth        |
|--------|---------------------------|---------------------------------------------------------------------------------------------|-------------|
| POST   | *`…/register`*           | Mendaftarkan pengguna Request Body terdiri dari name, email, password                       |             |
| POST   | *`…/login`*              | Login pengguna dan generate token                                                           | token       |
| POST   | *`…/me`*                 | Menampilakn user pengguna dan di validasi dengan token                                      | token       |

###Endpoint Motor
| Method | Path                      | Description                                                                                 | Auth        |
|--------|---------------------------|---------------------------------------------------------------------------------------------|-------------|
| GET   | *`…/motor`*               | Menampilakan data motor                                                                     | token            |
| GET   | *`…/motor/{id}`*          | Menampilan data motor sesuai dengan ID yang dipilih                                         | token       |
| POST   | *`…/motor`*              | Menambahkan data motor                                       | token       |
| PUT   | *`…/motor`*              | Merubah data motor                                       | token       |
| DELETE   | *`…/motor`*              | Menghapus data motor                                       | token       |

###Endpoint Mobil
| Method | Path                      | Description                                                                                 | Auth        |
|--------|---------------------------|---------------------------------------------------------------------------------------------|-------------|
| GET   | *`…/mobil`*               | Menampilakan data mobil                                                                     | token            |
| GET   | *`…/mobil/{id}`*          | Menampilan data mobil sesuai dengan ID yang dipilih                                         | token       |
| POST   | *`…/mobil`*              | Menambahkan data mobil                                       | token       |
| PUT   | *`…/mobil`*              | Merubah data mobil                                       | token       |
| DELETE   | *`…/mobil`*              | Menghapus data mobil                                       | token       |

###Stok
| Method | Path                      | Description                                                                                 | Auth        |
|--------|---------------------------|---------------------------------------------------------------------------------------------|-------------|
| GET   | *`…/stok-kendaraan/{type}`*               | menampilkan stok kendaraan (type: mobil/motor)                                                                     | token            |

###Penjualan
| Method | Path                      | Description                                                                                 | Auth        |
|--------|---------------------------|---------------------------------------------------------------------------------------------|-------------|
| POST   | *`…/penjualan-kendaraan`*               | Proses penjualan kendaraan mobil/motor                                                                      | token            |
| GET   | *`…/laporan-penjualan/{col}/{value}`*               | Menampilkan laporan penjualan dengan filter kolom tanggal, type_kendaraan, merk                                                                      | token            |

##Resource
1. MongoDB Comunity Server : https://www.mongodb.com/try/download/community

2. PHP MongoDB Extentension : https://windows.php.net/downloads/pecl/releases/mongodb/1.13.0/php_mongodb-1.13.0-8.0-ts-vs16-x64.zip


