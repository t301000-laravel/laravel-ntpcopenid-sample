# Laravel NTPC OpenID Sample

搭配 [Backpack for Laravel](https://backpackforlaravel.com/) 具有權限控管之功能

```
composer install
cp .env.example .env
```

編輯 .env，修改資料庫連線資訊

```
php artisan key:generate
php artisan migrate --seed
```

預設管理員帳密：admin@demo.com / 12345678

後台uri: /admin
