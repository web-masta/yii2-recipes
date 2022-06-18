<?php

use webmasta\yii2recipes\models\Ingredients;
use webmasta\yii2recipes\RecipesAssets;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model webmasta\yii2recipes\models\Recipes */
/* @var $form yii\widgets\ActiveForm */

RecipesAssets::register($this);

$this->registerJs(
        "$('#recipes-ingredients').multiSelect({
            selectableHeader: \"<div class='custom-header'>List</div>\",
            selectionHeader: \"<div class='custom-header'>Selected</div>\",
        })",
    View::POS_READY,
    'multi-select-handler'
);

?>

<div class="recipes-form">

    <?php
        $form = ActiveForm::begin();
        echo $form->field($model, 'title')->textInput(['maxlength' => true]);
        echo $form->field($model, 'description')->textarea(['rows' => 6]);

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
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
