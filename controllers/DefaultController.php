<?php

namespace webmasta\yii2recipes\controllers;

use webmasta\yii2recipes\models\UserSearchModel;
use Yii;
use yii\web\Controller;

class DefaultController extends Controller
{
    public array $items = [];

    public function actionIndex(): string
    {
        $model = new UserSearchModel();

        if($model->load(Yii::$app->request->get()) && $model->validate()) {
            $model->getRecipesByIngredients($this->request->queryParams);
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }
}