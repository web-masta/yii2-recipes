<?php

namespace webmasta\yii2recipes\models;

use JetBrains\PhpStorm\ArrayShape;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "ingredients".
 *
 * @property int $id
 * @property string $title
 * @property int|null $active
 *
 * @property Recipes[] $recipes
 * @property RecipesIngredients[] $recipesIngredients
 */
class Ingredients extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'ingredients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['title'], 'required'],
            [['active'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    #[ArrayShape(['id' => "integer", 'title' => "string", 'active' => "integer"])]
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'active' => 'Active',
        ];
    }

    /**
     * Gets query for [[Recipes]].
     *
     * @return ActiveQuery
     */
    public function getRecipes(): ActiveQuery
    {
        return $this->hasMany(Recipes::className(), ['id' => 'recipes_id'])->via('recipesIngredients');
    }

    /**
     * Gets query for [[RecipesIngredients]].
     *
     * @return ActiveQuery
     */
    public function getRecipesIngredients(): ActiveQuery
    {
        return $this->hasMany(RecipesIngredients::className(), ['ingredients_id' => 'id']);
    }
}
