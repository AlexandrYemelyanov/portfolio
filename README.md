## Задача

Нужно разработать веб-приложение для розыгрыша призов. После аутентификации пользователь может
нажать на кнопку и получить случайный приз. Призы бывают 3х типов: денежный (случайная сумма в
интервале), бонусные баллы (случайная сумма в интервале), физический предмет (случайный предмет из
списка). 

Денежный приз может быть перечислен на счет пользователя в банке (HTTP запрос к API банка), баллы
зачислены на счет лояльности в приложении, предмет отправлен по почте (вручную работником).
Денежный приз может конвертироваться в баллы лояльности с учетом коэффициента. От приза можно
отказаться. Деньги и предметы ограничены, баллы лояльности нет.

#### Комментарии к задаче:

- Нужно предоставить прототип в PHP 7.4+ без использования фреймворков, но можно использовать любые
библиотеки.
- Нужно добавить консольную команду которая будет отправлять денежные призы на счета пользователей,
которые еще не были отправлены пачками по N штук.
- Не нужно реализовывать все. Нам важно понять, как вы думаете.
- Готовое задание нужно отправить ссылкой на репозиторий.
- В данном задании оценивается не внешний вид приложения, а сам код, в связи с чем необходимо
ориентироваться на code review, а не визуальную и функциональную оценку приложения.

## Сборка

- Apache 2.4
- PHP 7.4 x64
- MySQL 8.0 x64 

## Установка
```bash
composer require --dev phpunit/phpunit ^9.5
```
```bash
composer require --dev mockery/mockery
```

Необходимо создать базу данных и импортировать в нее файл ./db.sql
```bash
mysql -uusername -ppassword db_new < db.sql
```

В файле ./app/config/db.php задать настройки подключения к базе данных.

В файле ./app/config/settings.php задать настройки проекта.

## Тесты

Находятся в папке ./tests phpunit тесты. Запустить тесты можно так
```bash
vendor\bin\phpunit
```
Тесты сгрупированы по папкам. Их можно запускать раздельно
```bash
vendor\bin\phpunit tests\User
```
Нагрузочные ab тесты выолнялись со следующими настройками
```bash
ab -k -c 200 -n 10000 example.com/
```
ps. Больше 200 одновременных запросов моя ОС не позволила сделать.

## Комментарии к реализации:
Для того чтобы пользователь смог запустить розыгрыш призов, ему нужно зарегистрироваться и авторизоваться.
Список физических призов хранится в базе в таблице prize_phys. 
Если пользователю выпал физический приз и он его забрал, то название приза и данные для отправки почтой приходят на e-mail админу.

Если пользователю выпал денежный приз и он его забрал, то данные о платеже записываются в базу (табл prize_to_send).
После эти платежи можно отправкить из консоли командой
```bash
php cli.php sendmoney -n 100
```
где 100 это количество платежей.

Для того чтобы узнать количество подготовленных на отправку платежей, необходимо выполнить команду
```bash
php cli.php sendmoney -q
```
Можно запустить все платежи
```bash
php cli.php sendmoney
```
После запуска отправки платежей будет выведен статус отправки
```bash
Acc: 9876322829  Summ: 7840  Status: OK
Acc: 9876322829  Summ: 6410  Status: BAD
Acc: 9876322829  Summ: 2932  Status: OK
Acc: 9876322829  Summ: 9467  Status: BAD
```
Платежи со Status: BAD это платежи которые не прошли через api банка. Такие платежи остаются в базе и будут запущены при повторной оптавке платежей.
## Фидбек по реализации

Плюсы
- Есть тесты
- Есть возможность управлять настраивать приложение
Минусы:
- не используются psr автолоад (что является проблемой производительности)
- не используются возможность PHP 7.4 (например указание типов)
- не используются транзакции в запросах (что несет потенциальную проблему с выдачей сверх лимитов)
- не используются встроеные функции для парсинга аргументов консоли
- используются не стабильные версии библиотек
- сессия стартует в index.php без проверок что тоже приведет к проблемам под нагрузкой