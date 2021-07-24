INSTALLATION
------------

~~~
git clone https://github.com/furiae13/rest-api.git rest-api

cd /rest-api

composer install

php yii migrate
~~~

### Database

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];
```


TESTING
-------

~~~

GET /user/ - get all users
POST /user/signup - create new user  (email, password)
POST /user/login  - (email, password)
POST /user-info/set  - set user info (first_name, last_name, phone_number)

~~~
