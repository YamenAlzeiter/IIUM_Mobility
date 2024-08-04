<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "host_university_cources".
 *
 * @property int $id
 * @property int|null $application_id
 * @property string|null $course_id
 * @property string|null $course_name
 * @property float|null $course_credit_hours
 *
 * @property Outbound $application
 */
class HostUniversityCources extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'host_university_cources';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['application_id'], 'default', 'value' => null],
            [['application_id'], 'integer'],
            [['course_credit_hours'], 'number'],
            [['course_id', 'course_name'], 'string', 'max' => 255],
            [['application_id'], 'exist', 'skipOnError' => true, 'targetClass' => Outbound::class, 'targetAttribute' => ['application_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'application_id' => 'Application ID',
            'course_id' => 'Course ID',
            'course_name' => 'Course Name',
            'course_credit_hours' => 'Course Credit Hours',
        ];
    }

    /**
     * Gets query for [[Application]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getApplication()
    {
        return $this->hasOne(Outbound::class, ['id' => 'application_id']);
    }
}
