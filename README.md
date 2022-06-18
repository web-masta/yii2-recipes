Тестовое задание: создать модуль для выборки блюд по ингридиентам.

Установка
---
1) Запустить `composer require web-masta/yii2-recipes`

2) В файл `/config/web.php` добавить:

```phpt /config/web.php
    'modules' => [
        'recipes' => [
            'class' => 'webmasta\yii2recipes\Recipes',
        ],
    ],
```

3) В `/web/console.php` в секции controllerMap добавить:

```phpt /web/console.php
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationNamespaces' => [
                'app\migrations',
                'webmasta\yii2recipes\migrations',
            ]
        ],
    ],
```

4) Запустить миграции `php yii migrate`
5) Поиск рецептов доступен по адресу `/index.php?r=recipes` или просто `/recipes`, если включена опция `'enablePrettyUrl' => true` в конфиге сайта.
6) CRUD рецептов: `/recipes/recipes`
7) CRUD ингридиентов: `/recipes/ingredients`