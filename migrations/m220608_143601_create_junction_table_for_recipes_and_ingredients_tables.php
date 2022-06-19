<?php

namespace webmasta\yii2recipes\migrations;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%recipes_ingredients}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%recipes}}`
 * - `{{%ingredients}}`
 */
class m220608_143601_create_junction_table_for_recipes_and_ingredients_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%recipes_ingredients}}', [
            'recipes_id' => $this->integer(),
            'ingredients_id' => $this->integer(),
            'PRIMARY KEY(recipes_id, ingredients_id)',
        ]);

        // creates index for column `recipes_id`
        $this->createIndex(
            '{{%idx-recipes_ingredients-recipes_id}}',
            '{{%recipes_ingredients}}',
            'recipes_id'
        );

        // add foreign key for table `{{%recipes}}`
        $this->addForeignKey(
            '{{%fk-recipes_ingredients-recipes_id}}',
            '{{%recipes_ingredients}}',
            'recipes_id',
            '{{%recipes}}',
            'id',
            'CASCADE'
        );

        // creates index for column `ingredients_id`
        $this->createIndex(
            '{{%idx-recipes_ingredients-ingredients_id}}',
            '{{%recipes_ingredients}}',
            'ingredients_id'
        );

        // add foreign key for table `{{%ingredients}}`
        $this->addForeignKey(
            '{{%fk-recipes_ingredients-ingredients_id}}',
            '{{%recipes_ingredients}}',
            'ingredients_id',
            '{{%ingredients}}',
            'id',
            'CASCADE'
        );

        $sql = "INSERT into recipes_ingredients (`recipes_id`, `ingredients_id`) 
                VALUES (1, 1), (1, 2), (1, 3), (1, 4), (1, 5), (2, 11), (2, 15),
                       (2, 1), (2, 39), (3, 1), (3, 6), (3, 17), (3, 40),(3, 37),
                       (3, 46), (3, 53), (4, 2), (4, 3), (4, 5), (4, 8), (4, 11), 
                       (4, 12), (4, 14), (4, 23), (4, 24), (4, 25), (4, 28), (4, 31), 
                       (4, 32), (4, 33), (4, 34), (4, 41), (4, 43), (4, 45), (4, 47), 
                       (4, 49), (4, 55), (5, 2), (5, 3), (5, 6), (5, 53), (5, 46), 
                       (5, 54), (6, 33), (6, 14), (6, 25), (6, 51), (7, 11), (7, 19), 
                       (7, 23), (7, 8), (7, 56), (8, 1), (8, 12), (8, 22), (8, 37), 
                       (8, 36), (9, 2), (9, 4), (9, 7), (9, 11), (9, 15), (9, 18), 
                       (9, 21), (9, 27), (9, 32), (9, 38), (9, 43), (9, 46), (9, 55), 
                       (9, 56), (9, 58), (9, 63), (10, 1), (10, 4), (10, 8), (10, 10), 
                       (10, 13), (10, 17),(10, 22), (10, 26), (10, 29), (10, 33), (10, 38), 
                       (10, 44), (10, 52), (10, 57), (10, 64), (11, 2), (11, 20), (11, 24), 
                       (11, 28), (12, 1), (12, 16), (12, 23), (12, 38), (12, 41), (12, 56), 
                       (12, 65), (13, 2), (13, 16),(13, 22), (13, 32), (13, 43), (13, 58), 
                       (13, 61), (14, 1), (14, 2), (14, 3), (14, 9), (14, 12), (14, 16), 
                       (14, 17), (14, 23), (14, 30), (14, 31), (14, 32), (14, 38), (14, 41), 
                       (14, 44), (14, 49), (14, 52), (14, 59), (14, 62), (14, 63), (15, 9), 
                       (15, 19), (15, 29), (15, 39), (15, 49), (15, 59), (16, 8), 
                       (16, 19), (16, 21), (16, 33), (16, 45), (16, 50), (16, 63)";
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%recipes}}`
        $this->dropForeignKey(
            '{{%fk-recipes_ingredients-recipes_id}}',
            '{{%recipes_ingredients}}'
        );

        // drops index for column `recipes_id`
        $this->dropIndex(
            '{{%idx-recipes_ingredients-recipes_id}}',
            '{{%recipes_ingredients}}'
        );

        // drops foreign key for table `{{%ingredients}}`
        $this->dropForeignKey(
            '{{%fk-recipes_ingredients-ingredients_id}}',
            '{{%recipes_ingredients}}'
        );

        // drops index for column `ingredients_id`
        $this->dropIndex(
            '{{%idx-recipes_ingredients-ingredients_id}}',
            '{{%recipes_ingredients}}'
        );

        $this->dropTable('{{%recipes_ingredients}}');
    }
}
