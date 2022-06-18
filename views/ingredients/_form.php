<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model webmasta\yii2recipes\models\Ingredients */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ingredients-form">

    <?php
        $form = ActiveForm::begin();
        echo $form->field($model, 'title')->textInput(['maxlength' => true]);
        echo $form->field($model, 'active')->dropDownList([
            '1' => 'Yes',
            '0' => 'No',
        ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
