### Code
---

##### Procfile
```script
web: vendor/bin/heroku-php-nginx -C nginx.conf web
```

##### post-install-cmd.sh
```script
#!/bin/sh
if [ -n "$DYNO" ]  && [ -n "$ENV" ]; then
    php init --env=$ENV --overwrite=All
    php yii migrate/up --interactive=0
    php yii cache/flush-all
    php yii cache/flush-schema --interactive=0
fi
```
##### nginx.conf
```script
location / {
    index index.php;
    try_files $uri $uri/ /index.php?$args;
}
```

##### composer.json
```json
    "require": {
        "ext-intl": "*",
        "ext-gd": "*",
        ...
    }
  ...
    "scripts": {
        "post-install-cmd": [
            ...,
            "sh post-install-cmd.sh"
        ],
        "post-create-project-cmd": [
            ...
        ]
    },
```

##### config/db.php
```php
<?php

$db = parse_url(getenv("DATABASE_URL"));
$db["path"] = ltrim($db["path"], "/");

return [
    'class' => 'yii\db\Connection',
    'dsn' =>  'pgsql:host=' . $db["host"] . ';port=' . $db["port"] . ';dbname=' . $db["path"],
    'username' => $db["user"],
    'password' => $db["pass"],
    'charset' => 'utf8',
];
```