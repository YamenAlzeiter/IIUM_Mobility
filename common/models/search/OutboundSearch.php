<?php

namespace common\models\search;

use common\helpers\Variables;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Outbound;

/**
 * OutboundSearch represents the model behind the search form of `common\models\outbound`.
 */
class OutboundSearch extends Outbound
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
            [['id', 'status', 'dean_id', 'hod_id'], 'integer'],
            [['matric_card', 'name', 'citizenship', 'gender', 'birth_date', 'mobile_number', 'email', 'passport_number', 'passport_expiration', 'country', 'state', 'permanent_address', 'post_code', 'mailing_country', 'mailing_state', 'mailing_permanent_address', 'mailing_post_code', 'emergency_name', 'emergency_relationship', 'emergency_mobile_number', 'emergency_email', 'emergency_country', 'emergency_state', 'emergency_postcode', 'emergency_address', 'academic_education_lvl', 'academic_kulliyyah', 'academic_current_semester', 'academic_current_year', 'academic_program_name', 'academic_cgpa', 'research', 'english_proficiency', 'third_language', 'financial_funded_accept', 'sponsorship_name', 'mobility_type', 'mobility_from', 'mobility_until', 'host_university_name', 'host_university_country', 'credit_transform_availability', 'host_university_pic_name', 'host_university_pic_mobile_number', 'host_university_pic_email', 'host_university_pic_position', 'host_university_pic_country', 'host_university_pic_postcode', 'host_university_pic_address', 'host_scholarship', 'host_scholarship_amount', 'f_academic_transcript', 'f_program_brochure', 'f_latest_payslip', 'f_other_latest_payslip', 'f_proof_sponsorship', 'f_proof_sponsorship_cover', 'f_letter_indemnity', 'f_flight_ticket', 'f_offer_letter', 'f_files', 'token', 'temp', 'updated_at', 'created_at', 'mobility_program', 'applications', 'full_info', 'year'], 'safe'],
            [['english_result', 'sponsorship_funding'], 'number'],
            [['agreement_accept'], 'boolean'],
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
        $query = Outbound::find();

        // Add conditions that should always apply here
        $query->andWhere(['IS NOT', 'status', new \yii\db\Expression('NULL')]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20, // Adjust the page size as needed
            ],
            'sort' => [
                'attributes' => [
                    'status' => [
                        'asc' => ['FIELD(status, 10, 11, 31, 51, 71)' => SORT_ASC],
//                        'desc' => ['FIELD(status, 10, 11, 31, 51, 71)' => SORT_DESC],
                    ],
                    // Add other attributes if needed
                ],
                'defaultOrder' => [
                    'status' => SORT_DESC, // Default sorting by status, with specified statuses on top
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // Uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // Grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'citizenship' => $this->citizenship,
            'country' => $this->country,
        ]);

        if ($this->applications === 'new_applications') {
            $query->andWhere(['not in', 'status', [61,81]]);
        } elseif ($this->applications === 'active_applications') {
            $query->andWhere(['OR', ['status' => 100], ['status' => 91]]);
        } elseif ($this->applications === 'expired_applications') {
            $query->andWhere(['OR', ['status' => 102], ['status' => 92]]);
        }

        if ($this->year) {
            $query->andFilterWhere([
                'or',
                ['extract(year from mobility_from)' => $this->year],
                ['extract(year from mobility_until)' => $this->year],
            ]);
        }


        $query->orFilterWhere(['ilike', 'matric_card', $this->full_info])
            ->orFilterWhere(['ilike', 'name', $this->full_info])
            ->orFilterWhere(['ilike', 'gender', $this->full_info])
            ->orFilterWhere(['ilike', 'mobile_number', $this->full_info])
            ->orFilterWhere(['ilike', 'email', $this->full_info])
            ->orFilterWhere(['ilike', 'passport_number', $this->full_info])
            ->orFilterWhere(['ilike', 'state', $this->full_info])
            ->orFilterWhere(['ilike', 'permanent_address', $this->full_info])
            ->orFilterWhere(['ilike', 'post_code', $this->full_info])
            ->orFilterWhere(['ilike', 'academic_education_lvl', $this->full_info])
            ->orFilterWhere(['ilike', 'academic_kulliyyah', $this->full_info])
            ->orFilterWhere(['ilike', 'academic_current_semester', $this->full_info])
            ->orFilterWhere(['ilike', 'academic_current_year', $this->full_info])
            ->orFilterWhere(['ilike', 'academic_program_name', $this->full_info])
            ->orFilterWhere(['ilike', 'academic_cgpa', $this->full_info])
            ->orFilterWhere(['ilike', 'english_proficiency', $this->full_info])
            ->orFilterWhere(['ilike', 'third_language', $this->full_info])
            ->orFilterWhere(['ilike', 'financial_funded_accept', $this->full_info])
            ->orFilterWhere(['ilike', 'sponsorship_name', $this->full_info])
            ->orFilterWhere(['ilike', 'mobility_type', $this->full_info])
            ->orFilterWhere(['ilike', 'host_university_name', $this->full_info])
            ->orFilterWhere(['ilike', 'host_university_country', $this->full_info])
            ->orFilterWhere(['ilike', 'credit_transform_availability', $this->full_info])
            ->orFilterWhere(['ilike', 'host_university_pic_name', $this->full_info])
            ->orFilterWhere(['ilike', 'host_university_pic_mobile_number', $this->full_info])
            ->orFilterWhere(['ilike', 'host_university_pic_email', $this->full_info])
            ->orFilterWhere(['ilike', 'host_university_pic_position', $this->full_info])
            ->orFilterWhere(['ilike', 'host_university_pic_country', $this->full_info])
            ->orFilterWhere(['ilike', 'host_university_pic_postcode', $this->full_info])
            ->orFilterWhere(['ilike', 'host_university_pic_address', $this->full_info])
            ->orFilterWhere(['ilike', 'host_scholarship', $this->full_info])
            ->orFilterWhere(['ilike', 'host_scholarship_amount', $this->full_info])
            ->orFilterWhere(['ilike', 'mobility_program', $this->full_info]);

        return $dataProvider;
    }

    public function getCountryCount($year = null)
    {
        $query = Outbound::find();

        // Default to the current year if no year is provided
        if ($year === null) {
            $year = date('Y');
        }

        // Apply filters
        $query->andFilterWhere([
            'or',
            ['extract(year from mobility_from)' => $year],
            ['extract(year from mobility_until)' => $year],
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
        $query = Outbound::find();

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
        $query = Outbound::find();

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
