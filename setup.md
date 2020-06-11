*1.* Require a laminas-db and laminas-paginator component:

```bash
composer require laminas/laminas-db
composer require laminas/laminas-paginator
```

*2.* Database config

```bash
<?php
// config/autoload/local.php
declare(strict_types=1);

return [
    'db' => [
        'username' => 'root',
        'password' => '',
        'driver'   => 'Pdo',
        'dsn' => 'mysql:dbname=mezzio_vue;host=localhost',
        'driver_options' => [
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ],
    ],
];
```

*3.* Create database, table, and insert some example data

```bash
create database mezzio_vue;

use mezzio_vue;

CREATE TABLE portfolio(
    id SMALLINT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
    title varchar(255) NOT NULL,
    image varchar(255) NOT NULL,
    link  varchar(255) NULL DEFAULT NULL
);

INSERT INTO `portfolio` (`id`, `title`, `image`, `link`) VALUES (NULL, 'WEBSITE A', 'WEBSITE-A.PNG', 'www.website-a.com');
INSERT INTO `portfolio` (`id`, `title`, `image`, `link`) VALUES (NULL, 'WEBSITE B', 'WEBSITE-B.PNG', 'www.website-b.com');
```



