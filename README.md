Blacklist
=============

University task. Public URLs list, which are reported for something.

Installation
------------

Run these commands to install application:

```
git clone https://github.com/kaunas163/Blacklist.git
composer install
```

Check connection to database settings under ``` app\config\parameters.yml ```

Then run some more commands which will create database and all needed tables:

```
php bin/console doctrine:database:create
php bin/console doctrine:schema:create
```

To run application use command:
```
php bin/console server:run
```
