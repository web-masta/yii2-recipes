<?php

namespace app\modules\recipes\models;

use JetBrains\PhpStorm\ArrayShape;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "recipes_ingredients".
 *
 * @property int $recipes_id
 * @property int $ingredients_id
 *
 * @property Ingredients $ingredients
 * @property Recipes $recipes
 */
class RecipesIngredients extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'recipes_ingredients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['recipes_id', 'ingredients_id'], 'required'],
            [['recipes_id', 'ingredients_id'], 'integer'],
            [['recipes_id', 'ingredients_id'], 'unique', 'targetAttribute' => ['recipes_id', 'ingredients_id']],
            [['ingredients_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ingredients::className(), 'targetAttribute' => ['ingredients_id' => 'id']],
            [['recipes_id'], 'exist', 'skipOnError' => true, 'targetClass' => Recipes::className(), 'targetAttribute' => ['recipes_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    #[ArrayShape(['recipes_id' => "integer", 'ingredients_id' => "string"])]
    public function attributeLabels()
    {
        return [
            'recipes_id' => 'Recipes ID',
            'ingredients_id' => 'Ingredients ID',
        ];
    }

    /**
     * Gets query for [[Ingredients]].
     *
     * @return ActiveQuery
     */
    public function getIngredients(): ActiveQuery
    {
        return $this->hasOne(Ingredients::className(), ['id' => 'ingredients_id']);
    }

    /**
     * Gets query for [[Recipes]].
     *
     * @return ActiveQuery
     */
    public function getRecipes(): ActiveQuery
    {
        return $this->hasOne(Recipes::className(), ['id' => 'recipes_id']);
    }
}
