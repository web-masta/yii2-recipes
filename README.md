Тестовое задание: создать модуль для выборки блюд по ингридиентам.

Установка
---
1) Модуль положить в папку `/modules`

2) В файл `/config/web.php` добавить:

```phpt /config/web.php
    'modules' => [
        'recipes' => [
            'class' => 'app\modules\recipes\Recipes',
        ],
    ],
```

3) В `/web/console.php`:

```phpt /web/console.php
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationNamespaces' => [
                'app\migrations',
                'app\modules\recipes\migrations',
            ]
        ],
```

4) Запустить миграции `php yii migrate`
5) Поиск рецептов доступен по адресу `/index.php?r=recipes` или просто `/recipes`, если включена опция `'enablePrettyUrl' => true`.
6) CRUD рецептов: `/recipes/recipes`
7) CRUD ингридиентов: `/recipes/ingredients`

