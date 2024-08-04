<?php

namespace common\models\search;

use common\helpers\Variables;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Inbound;

/**
 * InboundSearch represents the model behind the search form of `common\models\Inbound`.
 */
class InboundSearch extends Inbound
{
    public $full_info;
    public $applications;
    public $year;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'kulliyyah_id', 'cps_id'], 'integer'],
            [['name', 'gender', 'relation_ship', 'birth_date', 'mobile_number', 'email', 'passport_number', 'passport_expiration', 'religion', 'mazhab', 'citizenship', 'country', 'country_of_origin', 'country_of_residence', 'permanent_address', 'post_code', 'emergency_name', 'emergency_relationship', 'emergency_mobile_number', 'emergency_email', 'emergency_address', 'emergency_postcode', 'emergency_country', 'academic_home_university', 'academic_education_lvl', 'academic_program_name', 'academic_semester', 'academic_year', 'academic_faculty_name', 'academic_research_title', 'memorandum_of_agreement', 'language_is_native_english', 'language_english_test_name', 'propose_program_type', 'propose_mobility_type', 'propose_kulliyyah_applied', 'propose_duration_start', 'propose_duration_end', 'propose_study_duration', 'propose_transform_credit_hours', 'financial_accommodation_in_campus', 'campus_location', 'financial_funding', 'sponsor_name', 'room_type', 'home_university_pic_name', 'home_university_pic_email', 'home_university_pic_mobile_number', 'home_university_pic_position', 'home_university_approval_date', 'f_language_english_certificate', 'f_recommendation_letter', 'f_passport', 'f_latest_passport_photo', 'f_latest_academic_transcript', 'f_confirmation_letter', 'f_sponsorship_letter', 'f_offer_letter', 'f_proof_of_payment', 'token', 'temp', 'updated_at', 'created_at', 'applications', 'full_info', 'year'], 'safe'],
            [['academic_result', 'sponsor_amount'], 'number'],
            [['agreement'], 'boolean'],
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
        $query = Inbound::find();

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
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'citizenship' => $this->citizenship,
            'propose_duration_start' => $this->propose_duration_start,
            'propose_duration_end' => $this->propose_duration_end,
            'kulliyyah_id' => $this->kulliyyah_id,
        ]);

        if ($this->applications === 'new_applications') {
            $query->andWhere(['not in', 'status', [65,85]]);
        } elseif ($this->applications === 'active_applications') {
            $query->andWhere(['OR', ['status' => 100], ['status' => 91]]);
        } elseif ($this->applications === 'expired_applications') {
            $query->andWhere(['OR', ['status' => 102], ['status' => 92]]);
        }

        if ($this->year) {
            $query->andFilterWhere([
                'or',
                ['extract(year from propose_duration_start)' => $this->year],
                ['extract(year from propose_duration_end)' => $this->year],
            ]);
        }


        $query->orFilterWhere(['ilike', 'name', $this->full_info])
            ->orFilterWhere(['ilike', 'gender', $this->full_info])
            ->orFilterWhere(['ilike', 'relation_ship', $this->full_info])
            ->orFilterWhere(['ilike', 'mobile_number', $this->full_info])
            ->orFilterWhere(['ilike', 'email', $this->full_info])
            ->orFilterWhere(['ilike', 'passport_number', $this->full_info])
            ->orFilterWhere(['ilike', 'religion', $this->full_info])
            ->orFilterWhere(['ilike', 'mazhab', $this->full_info])
            ->orFilterWhere(['ilike', 'country', $this->full_info])
            ->orFilterWhere(['ilike', 'country_of_origin', $this->full_info])
            ->orFilterWhere(['ilike', 'country_of_residence', $this->full_info])
            ->orFilterWhere(['ilike', 'academic_home_university', $this->full_info])
            ->orFilterWhere(['ilike', 'academic_education_lvl', $this->full_info])
            ->orFilterWhere(['ilike', 'academic_program_name', $this->full_info])
            ->orFilterWhere(['ilike', 'academic_semester', $this->full_info])
            ->orFilterWhere(['ilike', 'academic_year', $this->full_info])
            ->orFilterWhere(['ilike', 'academic_faculty_name', $this->full_info])
            ->orFilterWhere(['ilike', 'academic_research_title', $this->full_info])
            ->orFilterWhere(['ilike', 'language_english_test_name', $this->full_info])
            ->orFilterWhere(['ilike', 'propose_program_type', $this->full_info])
            ->orFilterWhere(['ilike', 'propose_mobility_type', $this->full_info])
            ->orFilterWhere(['ilike', 'propose_kulliyyah_applied', $this->full_info])
            ->orFilterWhere(['ilike', 'propose_study_duration', $this->full_info])
            ->orFilterWhere(['ilike', 'propose_transform_credit_hours', $this->full_info])
            ->orFilterWhere(['ilike', 'financial_accommodation_in_campus', $this->full_info])
            ->orFilterWhere(['ilike', 'campus_location', $this->full_info])
            ->orFilterWhere(['ilike', 'financial_funding', $this->full_info])
            ->orFilterWhere(['ilike', 'sponsor_name', $this->full_info])
            ->orFilterWhere(['ilike', 'room_type', $this->full_info])
            ->orFilterWhere(['ilike', 'home_university_pic_name', $this->full_info])
            ->orFilterWhere(['ilike', 'home_university_pic_email', $this->full_info])
            ->orFilterWhere(['ilike', 'home_university_pic_mobile_number', $this->full_info])
            ->orFilterWhere(['ilike', 'home_university_pic_position', $this->full_info]);

        return $dataProvider;
    }

    public function getCountryCount($year = null)
    {
        $query = Inbound::find();

        // Default to the current year if no year is provided
        if ($year === null) {
            $year = date('Y');
        }

        // Apply filters
        $query->andFilterWhere([
            'or',
            ['extract(year from propose_duration_start)' => $year],
            ['extract(year from propose_duration_end)' => $year],
        ]);

        // Count distinct countries
        $query->select(['country', 'COUNT(*) AS count'])
            ->groupBy('country');

        // Get the results as an array
        $results = $query->asArray()->all();

        // Transform results into the desired format
        $countryCountData = [];
        foreach ($results as $item) {
            $countryCountData[] = [
                'name' => $item['country'],
                'data' => [[$item['country'], (int)$item['count']]],
            ];
        }

        return $countryCountData;
    }
    public function getMonthlyRecordCount($year = null)
    {
        $query = Inbound::find();

        // Default to the current year if no year is provided
        if ($year === null) {
            $year = date('Y');
        }

        // Apply filters for the specified year and ensure status is not null
        $query->where(['EXTRACT(YEAR FROM created_at)' => $year])
            ->andWhere(['IS NOT', 'status', null]);

        // Group by month and count the records
        $query->select(['EXTRACT(MONTH FROM created_at) as month', 'COUNT(*) as count'])
            ->groupBy(['EXTRACT(MONTH FROM created_at)'])
            ->orderBy(['month' => SORT_ASC]);

        return $query->asArray()->all();
    }
    public function getStatusCount($year = null)
    {
        $query = Inbound::find();

        // Default to the current year if no year is provided
        if ($year === null) {
            $year = date('Y');
        }

        // Apply filters
        $query->andFilterWhere([
            'or',
            ['extract(year from created_at)' => $year],
            ['status' => [Variables::application_accepted_inbound, Variables::application_rejected_inbound]],
        ]);

        // Get the count of approved and rejected records
        $query->select(['status', 'COUNT(*) AS count'])
            ->groupBy('status');

        return $query->asArray()->all();
    }

}
