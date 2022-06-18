<?php

namespace app\modules\recipes\models;

use JetBrains\PhpStorm\ArrayShape;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "recipes".
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 *
 * @property Ingredients[] $ingredients
 * @property RecipesIngredients[] $recipesIngredients
 */
class Recipes extends ActiveRecord
{
    /**
     * @var mixed|null
     */
    public int $count;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'recipes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['title'], 'required'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    #[ArrayShape(['id' => "integer", 'title' => "string", 'description' => "string"])]
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[Ingredients]].
     *
     * @return ActiveQuery
     */
    public function getIngredients(): ActiveQuery
    {
        return $this->hasMany(Ingredients::className(), ['id' => 'ingredients_id'])->via('recipesIngredients');
    }

    /**
     * Gets query for [[RecipesIngredients]].
     *
     * @return ActiveQuery
     */
    public function getRecipesIngredients(): ActiveQuery
    {
        return $this->hasMany(RecipesIngredients::className(), ['recipes_id' => 'id']);
    }
}
