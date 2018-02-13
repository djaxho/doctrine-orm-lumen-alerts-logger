# Alert Service

Manages system alerts.

## Setup

Make sure to copy all of the `.env` file and `etc/mysql.env`

Then run `docker-compose up`.

From inside of the `emporium-svc-alert-php` container. run `./artisan doctrine:migrations:migrate -n` to load migrations.

## Playground

If you ever need to test any code, you can create a playground file which allows you to test anything in the system.

Create the play ground file in the root of the repo.

```
cp playground.example.php playground.php
```

## Debugging

Use the `dump` command to printout useful information.

## Routes

Routes are defined in `src/app.php`

## Model

The model holds all of the business logic and entities for the system.

## Commands

All commands are created in the `src/Console` directory and are registered in the `AlertServiceProvider`.

## Doctrine

Migrations are generated in `src/Doctrine/Migrations`.

File mappings are in `config/doctrine-mapping`.

Run `./artisan doctrine:migrations:migrate -n` to run all migrations.

Run `./artisan doctrine:migrations:diff` to generate migration from the

Perform DQL Queries

```php
<?php

$query = $em->createQuery('SELECT alert FROM Alert:Alert alert');
$query->getResult();
```

Use an entity repo

```php
<?php

$repo = $em->getRepository('Alert:Alert');
$report = $repo->findOneBy([
    'severity' => $severity
]);
```

Persist an entity

```php
<?php

$alert = new Alert();
$em->persist($alert);

// flush will persist to the db, you only need to call it like once or twice per request
$em->flush();
```
