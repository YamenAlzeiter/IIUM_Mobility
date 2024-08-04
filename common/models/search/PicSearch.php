<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Pic;

/**
 * PicSearch represents the model behind the search form of `common\models\Pic`.
 */
class PicSearch extends Pic
{
    /**
     * {@inheritdoc}
     */
    public $full_search;
    public function rules()
    {
        return [
            [['id', 'kcdio_id'], 'integer'],
            [['name', 'email', 'name_cc_x', 'email_cc_x', 'name_cc_xx', 'email_cc_xx', 'full_search'], 'safe'],
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
        $query = Pic::find();

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


        $query->orFilterWhere(['ilike', 'name', $this->full_search])
            ->orFilterWhere(['ilike', 'email', $this->full_search])
            ->orFilterWhere(['ilike', 'name_cc_x', $this->full_search])
            ->orFilterWhere(['ilike', 'email_cc_x', $this->full_search])
            ->orFilterWhere(['ilike', 'name_cc_xx', $this->full_search])
            ->orFilterWhere(['ilike', 'email_cc_xx', $this->full_search]);

        return $dataProvider;
    }
}
