Yii 2 Test Application
============================

INSTALLATION
------------

```
# Make a folder and move into it:
mkdir yii2 && cd $_

# Install from git:
git clone git@github.com:sedpro/yii2-test-app.git .

# Install composer:
curl -sS https://getcomposer.org/installer | php

# Run composer:
php composer.phar install

# Run built-in web server
php -S 127.0.0.1:8080 -t web/

# Open in browser the page
http://127.0.0.1:8080
```

CONFIGURATION
-------------

### Database

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

TASK
----

Необходимо создать веб-приложение для управления базой данных бонусных карт (карты лояльности).

Инструменты: нативный PHP или любой PHP фреймворк. Можно использовать jQuery.

Список полей:
* серия карты
* номер карты
* дата выпуска карты
* дата окончания активности карты
* дата использования
* сумма
* статус карты (не активирована/активирована/просрочена)

Функционал приложения
- список карт с полями: серия, номер, дата выпуска, дата окончания активности, статус
- поиск по этим же полям
- просмотр профиля карты с историей покупок по ней
- активация/деактивация карты
- удаление карты
- Реализовать генератор карт, с указанием серии и количества генерируемых карт, а также "срок
окончания активности" со значениями "1 год", "6 месяцев" "1 месяц". После истечения срока
активности карты, у карты проставляется статус "просрочена".

Примечание: поля с датами должны содержать также и время.