<?php

namespace webmasta\yii2recipes\migrations;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%recipes}}`.
 */
class m220608_143514_create_recipes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%recipes}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->text(),
        ]);

        $sql = "INSERT into recipes (title) VALUES 
                ('Борщ'), ('Салат'), ('Щи'), ('Ватрушка'), ('Оливье'), ('Салат с творогом'), ('Кутабы с мясом'),
                ('Шашлык свиной'), ('Салат Новогодний'), ('Салат мясной'), ('Вкуснятина'), ('Шашлык'),
                ('Что-то вкусное'), ('Суп гороховый'), ('Запеченый лосось'), ('Мясное ассорти')";

        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%recipes}}');
        $this->dropTable('{{%recipes}}');
    }
}
