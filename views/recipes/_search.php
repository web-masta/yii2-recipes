<?php

use app\modules\recipes\models\Ingredients;
use app\modules\recipes\RecipesAssets;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\recipes\models\RecipesSearch */
/* @var $form yii\widgets\ActiveForm */

RecipesAssets::register($this);

?>
<div class="recipes-search">

    <?php
        $form = ActiveForm::begin([
            'id' => 'recipe-search',
            'action' => ['index'],
            'method' => 'get',
        ]);
        $ingredients = Ingredients::find()->all();
        $items = [];
        if($ingredients) {
            foreach ($ingredients as $ingredient) {
                $items[$ingredient->id] = $ingredient->title;
            }
        }
        echo $form->field($model, 'ingredients')->listBox($items, ['multiple' => true]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?php /*= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) */?>
    </div>

    <?php ActiveForm::end(); ?>

    <div id="filter-message" class="alert alert-danger" style="display: none"></div>

</div>
