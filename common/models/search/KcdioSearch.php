<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Kcdio;

/**
 * KcdioSearch represents the model behind the search form of `common\models\Kcdio`.
 */
class KcdioSearch extends Kcdio
{
    public $full_search;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['kcdio', 'tag', 'full_search'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
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
    public function search($params)
    {
        $query = Kcdio::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 15, // Adjust the page size as needed
            ],
            'sort' => [
                'defaultOrder' => [
                    'kcdio' => SORT_ASC, // Default sorting by kcdio in ascending order
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->orFilterWhere(['ilike', 'kcdio', $this->full_search])
            ->orFilterWhere(['ilike', 'tag', $this->full_search]);

        return $dataProvider;
    }
}
