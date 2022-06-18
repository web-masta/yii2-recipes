<?php

namespace webmasta\yii2recipes\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use webmasta\yii2recipes\models\Recipes;
use yii\helpers\VarDumper;

/**
 * RecipesSearch represents the model behind the search form of `webmasta\yii2recipes\models\Recipes`.
 */
class RecipesSearch extends Recipes
{
    /**
     * {@inheritdoc}
     */
    public $ingredients;
    public function rules(): array
    {
        return [
            [['id'], 'integer'],
            [['title', 'description'], 'safe'],
            [['ingredients'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios(): array
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Recipes::find();
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['id' => $this->id,])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}