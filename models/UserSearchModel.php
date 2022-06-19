<?php

namespace webmasta\yii2recipes\models;

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
    }

    /**
     * Returns matching recipes and its ingredients ids
     * @return array
     */
    public function returnRecipes(): array
    {
        foreach ($this->ingredients as $ingredient) {
            $recipes = RecipesIngredients::findAll(['ingredients_id' => $ingredient]);
            foreach ($recipes as $recipe) {
                $this->recipes[$recipe->recipes_id]['ingredients'][] = $recipe->ingredients_id;
            }
        }
        return $this->countIngredients();
    }

    /**
     * Counts number of matched ingredients for each recipe found
     * @return array
     */
    public function countIngredients(): array
    {
        foreach ($this->recipes as $key => $value) {
            $this->counter[$key] = count($this->getIngredients($key));
            $this->recipes[$key]['exactMatch'] = count($this->recipes[$key]['ingredients']);
        }
        $this->cutCounter();
        if (count($this->counter) < $this->min) {
            Yii::$app->getSession()->setFlash('danger', 'Ничего не найдено');
        }
        krsort($this->counter);
        return $this->counter;
    }

    /**
     * Cuts off recipes with number of matched ingredients less than $this->min
     * @return void
     */
    public function cutCounter(): void
    {
        foreach ($this->counter as $key => $value) {

            $this->recipes[$key]['activeStatus'] = $this->getIngredientsActiveStatus($key);

            if($this->recipes[$key]['exactMatch'] < $this->min
                || in_array(0, $this->recipes[$key]['activeStatus'])) {
                unset($this->counter[$key]);
            } elseif ($this->recipes[$key]['exactMatch'] == $this->counter[$key]) {
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
     * Return all ingredients of recipe
     * @param int $recipeId
     * @return array
     */
    public function getIngredients(int $recipeId) {
        $ids = [];
        foreach (RecipesIngredients::findAll(['recipes_id' => $recipeId]) as $ingredient) {
            $ids[] = $ingredient->ingredients_id;
        }
        return $ids;
    }

    /**
     * Return array with ingredient active status
     * @param int $recipeId
     * @return array
     */
    public function getIngredientsActiveStatus(int $recipeId) {
        $status = [];
        $ingredients = $this->getIngredients($recipeId);
        foreach ($ingredients as $ingredient) {
            $status[] = Ingredients::findOne($ingredient)->active;
        }
        return $status;
    }

    /**
     * Returns ingredients names from array of ids
     * @param array $ingredients
     * @return array
     */
    public function getIngredientsNames(array $ingredients): array {
        $names = [];
        foreach ($ingredients as $ingredient) {
            $names[] = Ingredients::findOne($ingredient)->title;
        }
        return $names;
    }

    /**
     * For debug only
     * @return array
     */
    public function printRecipes() {
        return $this->recipes;
    }

    /**
     * Get recipes, matching search and filter criteria and prepare it for ArrayDataProvider
     * @return array
     */
    public function getRecipes(): array
    {
        $recipes = [];
        foreach (Recipes::findAll(['id' => array_keys($this->getCounter())]) as $val) {
            $recipes[] = [
                'id' => $val->id,
                'title' => $val->title,
                'description' => $val->description,
                'count' => $this->getCounter()[$val->id],
                'match' => $this->recipes[$val->id]['exactMatch'],
                'ingredients' => join(', ', $this->getIngredientsNames($this->getIngredients($val->id))),
            ];
        }
        return $recipes;
    }
}