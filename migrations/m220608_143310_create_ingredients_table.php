<?php

namespace app\modules\recipes\migrations;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%ingredients}}`.
 */
class m220608_143310_create_ingredients_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%ingredients}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'active' => $this->integer(1)->notNull()->defaultValue(1),
        ]);

        $sql = "INSERT into ingredients (title) VALUES 
                ('Капуста'), ('Картошка'), ('Морковка'), ('Говрядина'), ('Свекла'), ('Лук'),
                ('Чеснок'), ('Банан'), ('Грудка куриная'), ('Бедро куриное'), ('Листья салата'),
                ('Зеленый горошек'), ('Кукуруза'), ('Мука'), ('Соль'), ('Перец'), ('Вода'),
                ('Арахис'), ('Баклажан'), ('Бальзамик'), ('Батат'), ('Бобы'), ('Горох'),
                ('Брынза'), ('Ваниль'), ('Взбитые сливки'), ('Грибы'), ('Вишня'), ('Вино'),
                ('Виски'), ('Желатин'), ('Изюм'), ('Творог'), ('Сахар'), ('Мёд'), ('Мята'),
                ('Редис'), ('Оругец'), ('Помидор'), ('Петрушка'), ('Масло растительное'),
                ('Базилик'), ('Горчица'), ('Яйцо куриное'), ('Фарш мясной'), ('Зелень'), ('Лаваш'),
                ('Сыр'), ('Кетчуп'), ('Креветки'), ('Кабачок'), ('Шейка свиная'), ('Колбаса докторская'), 
                ('Майонез'), ('Лимон'), ('Имбирь'), ('Бадьян'), ('Куркума'), ('Паприка'), ('Корица'), 
                ('Рыба'), ('Сметана'), ('Сливки'), ('Оливки'), ('Соевый соус'), ('Терияки'), ('Рис'), ('Вермишель')";

        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%ingredients}}');
        $this->dropTable('{{%ingredients}}');
    }
}
