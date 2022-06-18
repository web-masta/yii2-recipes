<?php

namespace app\modules\recipes\models;

use JetBrains\PhpStorm\ArrayShape;
use Yii;
use yii\base\Model;

class UserSearchModel extends Model
{

    public array $ingredients = [];
    private int $min = 2;
    private int $max = 5;
    private array $recipes = [];
    private array $counter = [];
    private array $exactMatch = [];

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['ingredients'], 'required'],
            ['ingredients', 'in', 'allowArray' => true, 'range' => $this->rangeSelection(true)],
        ];
    }

    /**
     * {@inheritdoc}
     */
    #[ArrayShape(['ingredients' => "string"])]
    public function attributeLabels(): array
    {
        return [
            'ingredients' => 'Ingredients',
        ];
    }

    /**
     * Returns range of available ingredients
     * @param bool $onlyIds
     * @return array
     */
    public function rangeSelection(bool $onlyIds = false): array {
        $items = [];
        foreach (Ingredients::find()->all() as $ingredient) {
            if($ingredient->active == 1) {
                $items[$ingredient->id] = $ingredient->title;
            }
        }
        if($onlyIds) {
            return array_keys($items);
        }
        return $items;
    }

    /**
     * Returns array of recipes id's as key and count of ingredients as value
     * @param array $params
     * @return array|null
     */
    public function getRecipesByIngredients(array $params): ?array
    {
        if(!empty($this->ingredients)) {
            if(count($this->ingredients) < $this->min)
            {
                Yii::$app->getSession()->setFlash('danger', 'Выберите больше ингредиентов');
            } elseif (count($this->ingredients) > $this->max)
            {
                Yii::$app->getSession()->setFlash('danger', 'Выберите не более 5 ингридиентов');
            } else {
                return $this->returnRecipes();
            }
        }
        return null;
    }

    /**
     * Returns matching recipes and its ingredients ids
     * @return array
     */
    public function returnRecipes(): array
    {
        $ids = [];
        foreach ($this->ingredients as $ingredient) {
            $recipes = RecipesIngredients::findAll(['ingredients_id' => $ingredient]);
            foreach ($recipes as $recipe) {
                $ids[$recipe->recipes_id][] = $recipe->ingredients_id;
                $this->counter[$recipe->recipes_id] = 0;
            }
        }
        $this->recipes = $ids;
        return $this->countIngredients();
    }

    /**
     * Counts number of matched ingredients for each recipe found
     * @return array
     */
    public function countIngredients(): array
    {
        foreach ($this->ingredients as $ingredient) {
            foreach ($this->recipes as $key => $value) {

                if(in_array($ingredient, $value)) {
                    $this->counter[$key]++;
                }
            }
        }
        $this->cutCounter();
        if (count($this->counter) < $this->min) {
            Yii::$app->getSession()->setFlash('danger', 'Ничего не найдено');
        }
        arsort($this->counter);
        return $this->counter;
    }

    /**
     * Cuts off recipes with number of matched ingredients less than $this->min
     * @return void
     */
    public function cutCounter(): void
    {
        foreach ($this->counter as $key => $value) {
            if($value < $this->min) {
                unset($this->counter[$key]);
            } elseif ($value == count($this->ingredients)) {
                // Если полное совпадение выбранных ингридиентов, создаём новый массив
                $this->exactMatch[$key] = $value;
                Yii::$app->getSession()->setFlash('success', 'Точное совпадение ингредиентов');
            }
        }
    }

    /**
     * Get recipe ids and number of matched ingredients
     * @return array
     */
    public function getCounter(): array
    {
        return $this->exactMatch ?: $this->counter;
    }

    /**
     * Get recipes, matching search and filter criteria and prepare it for ArrayDataProvider
     * @return array
     */
    public function getRecipes(): array
    {
        $recipes = [];
        foreach (Recipes::findAll(['id' => array_keys($this->getCounter())]) as $key => $val) {
            $recipes[] = [
                'id' => $val->id,
                'title' => $val->title,
                'description' => $val->description,
                'count' => $this->getCounter()[$val->id],
            ];
        }
        return $recipes;
    }
}