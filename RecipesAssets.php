<?php

namespace app\modules\recipes;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class RecipesAssets extends AssetBundle
{
    public $sourcePath = '@app/modules/recipes/assets';
    public $css = [
        'css/multi-select.css',
    ];
    public $js = [
        'js/jquery.multi-select.js',
        'js/selectHandler.js',
    ];
    public $depends = [
        JqueryAsset::class,
    ];
}