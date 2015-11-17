Loyalty cards test application
==============================

INSTALLATION
------------

```
# Make a folder and move into it:
mkdir test_starcode && cd $_

# Install from git:
git clone git@github.com:sedpro/test_starcode.git .

# Install composer:
curl -sS https://getcomposer.org/installer | php

# Run composer:
php composer.phar install

# Edit the file config/db.php with real data
nano config/db.php

# Run migrations to create tables:
php yii migrate

# Run built-in web server:
php -S 127.0.0.1:8080 -t web/

# Open in browser the page:
http://127.0.0.1:8080
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
