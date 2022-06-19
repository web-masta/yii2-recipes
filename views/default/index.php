<?php
/* @var $this yii\web\View */
/* @var $model \webmasta\yii2recipes\models\UserSearchModel */

$this->title = 'Recipe search';

use webmasta\yii2recipes\RecipesAssets;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;

RecipesAssets::register($this);

echo "<h1>" . Html::encode($this->title) . "</h1>";

$form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
]);
echo $form->field($model, 'ingredients')->listBox($model->rangeSelection(), ['multiple' => true, 'id' => 'recipe-search']);
?>
    <div class="form-group">
        <?php echo Html::submitButton('Search', ['class' => 'btn btn-primary', 'id' => 'recipe-search-button']) ?>
    </div>
<?php ActiveForm::end(); ?>

    <div id="filter-message" class="alert alert-warning" style="display: none; margin: 20px"></div>

<?php
$dataProvider = new ArrayDataProvider([
    'allModels' => $model->getRecipes(),
    'pagination' => [
        'pageSize' => 20,
    ],
    'sort' => [
        'attributes' => ['title', 'count', 'match'],
        'defaultOrder' => ['match' => SORT_DESC],
    ],
]);

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'title',
        'match',
        'ingredients',
    ],
]);
?>