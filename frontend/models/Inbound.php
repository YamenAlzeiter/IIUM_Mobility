<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "inbound".
 *
 * @property int $id
 * @property int|null $status
 * @property string|null $name
 * @property string|null $gender
 * @property string|null $relation_ship
 * @property string|null $birth_date
 * @property string|null $mobile_number
 * @property string|null $email
 * @property string|null $passport_number
 * @property string|null $passport_expiration
 * @property string|null $religion
 * @property string|null $mazhab
 * @property string|null $citizenship
 * @property string|null $country
 * @property string|null $country_of_origin
 * @property string|null $country_of_residence
 * @property string|null $permanent_address
 * @property string|null $post_code
 * @property string|null $emergency_name
 * @property string|null $emergency_relationship
 * @property string|null $emergency_mobile_number
 * @property string|null $emergency_email
 * @property string|null $emergency_address
 * @property string|null $emergency_postcode
 * @property string|null $emergency_country
 * @property string|null $academic_home_university
 * @property string|null $academic_education_lvl
 * @property string|null $academic_program_name
 * @property string|null $academic_semester
 * @property string|null $academic_year
 * @property string|null $academic_faculty_name
 * @property float|null $academic_result
 * @property string|null $academic_research_title
 * @property string|null $memorandum_of_agreement
 * @property bool|null $language_is_native_english
 * @property string|null $language_english_test_name
 * @property string|null $propose_program_type
 * @property string|null $propose_mobility_type
 * @property string|null $propose_kulliyyah_applied
 * @property string|null $propose_duration_start
 * @property string|null $propose_duration_end
 * @property string|null $propose_study_duration
 * @property string|null $propose_transform_credit_hours
 * @property string|null $financial_accommodation_in_campus
 * @property string|null $campus_location
 * @property string|null $financial_funding
 * @property string|null $sponsor_name
 * @property float|null $sponsor_amount
 * @property string|null $room_type
 * @property string|null $home_university_pic_name
 * @property string|null $home_university_pic_email
 * @property string|null $home_university_pic_mobile_number
 * @property string|null $home_university_pic_position
 * @property string|null $home_university_approval_date
 * @property string|null $f_language_english_certificate
 * @property string|null $f_recommendation_letter
 * @property string|null $f_passport
 * @property string|null $f_latest_passport_photo
 * @property string|null $f_latest_academic_transcript
 * @property string|null $f_confirmation_letter
 * @property string|null $f_sponsorship_letter
 * @property string|null $f_offer_letter
 * @property string|null $f_proof_of_payment
 * @property int|null $kulliyyah_id
 * @property int|null $cps_id
 * @property bool|null $agreement
 * @property string|null $token
 * @property string|null $temp
 * @property string|null $updated_at
 * @property string|null $created_at
 *
 * @property Pic $cps
 * @property InboundHostUniversityCourses[] $inboundHostUniversityCourses
 * @property InboundLog[] $inboundLogs
 * @property Pic $kulliyyah
 * @property OutboundLog[] $outboundLogs
 */
class Inbound extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'inbound';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'kulliyyah_id', 'cps_id'], 'default', 'value' => null],
            [['status', 'kulliyyah_id', 'cps_id'], 'integer'],
            [['birth_date', 'passport_expiration', 'propose_duration_start', 'propose_duration_end', 'home_university_approval_date', 'updated_at', 'created_at'], 'safe'],
            [['permanent_address', 'emergency_address', 'academic_research_title', 'campus_location', 'f_language_english_certificate', 'f_recommendation_letter', 'f_passport', 'f_latest_passport_photo', 'f_latest_academic_transcript', 'f_confirmation_letter', 'f_sponsorship_letter', 'f_offer_letter', 'f_proof_of_payment', 'token', 'temp'], 'string'],
            [['academic_result', 'sponsor_amount'], 'number'],
            [['language_is_native_english', 'agreement'], 'boolean'],
            [['name', 'gender', 'relation_ship', 'mobile_number', 'email', 'passport_number', 'religion', 'mazhab', 'citizenship', 'country', 'country_of_origin', 'country_of_residence', 'post_code', 'emergency_name', 'emergency_relationship', 'emergency_mobile_number', 'emergency_email', 'emergency_postcode', 'emergency_country', 'academic_home_university', 'academic_education_lvl', 'academic_program_name', 'academic_semester', 'academic_year', 'academic_faculty_name', 'memorandum_of_agreement', 'language_english_test_name', 'propose_program_type', 'propose_mobility_type', 'propose_kulliyyah_applied', 'propose_study_duration', 'propose_transform_credit_hours', 'financial_accommodation_in_campus', 'financial_funding', 'sponsor_name', 'room_type', 'home_university_pic_name', 'home_university_pic_email', 'home_university_pic_mobile_number', 'home_university_pic_position'], 'string', 'max' => 255],
            [['kulliyyah_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pic::class, 'targetAttribute' => ['kulliyyah_id' => 'id']],
            [['cps_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pic::class, 'targetAttribute' => ['cps_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'name' => 'Name',
            'gender' => 'Gender',
            'relation_ship' => 'Relation Ship',
            'birth_date' => 'Birth Date',
            'mobile_number' => 'Mobile Number',
            'email' => 'Email',
            'passport_number' => 'Passport Number',
            'passport_expiration' => 'Passport Expiration',
            'religion' => 'Religion',
            'mazhab' => 'Mazhab',
            'citizenship' => 'Citizenship',
            'country' => 'Country',
            'country_of_origin' => 'Country Of Origin',
            'country_of_residence' => 'Country Of Residence',
            'permanent_address' => 'Permanent Address',
            'post_code' => 'Post Code',
            'emergency_name' => 'Emergency Name',
            'emergency_relationship' => 'Emergency Relationship',
            'emergency_mobile_number' => 'Emergency Mobile Number',
            'emergency_email' => 'Emergency Email',
            'emergency_address' => 'Emergency Address',
            'emergency_postcode' => 'Emergency Postcode',
            'emergency_country' => 'Emergency Country',
            'academic_home_university' => 'Academic Home University',
            'academic_education_lvl' => 'Academic Education Lvl',
            'academic_program_name' => 'Academic Program Name',
            'academic_semester' => 'Academic Semester',
            'academic_year' => 'Academic Year',
            'academic_faculty_name' => 'Academic Faculty Name',
            'academic_result' => 'Academic Result',
            'academic_research_title' => 'Academic Research Title',
            'memorandum_of_agreement' => 'Memorandum Of Agreement',
            'language_is_native_english' => 'Language Is Native English',
            'language_english_test_name' => 'Language English Test Name',
            'propose_program_type' => 'Propose Program Type',
            'propose_mobility_type' => 'Propose Mobility Type',
            'propose_kulliyyah_applied' => 'Propose Kulliyyah Applied',
            'propose_duration_start' => 'Propose Duration Start',
            'propose_duration_end' => 'Propose Duration End',
            'propose_study_duration' => 'Propose Study Duration',
            'propose_transform_credit_hours' => 'Propose Transform Credit Hours',
            'financial_accommodation_in_campus' => 'Financial Accommodation In Campus',
            'campus_location' => 'Campus Location',
            'financial_funding' => 'Financial Funding',
            'sponsor_name' => 'Sponsor Name',
            'sponsor_amount' => 'Sponsor Amount',
            'room_type' => 'Room Type',
            'home_university_pic_name' => 'Home University Pic Name',
            'home_university_pic_email' => 'Home University Pic Email',
            'home_university_pic_mobile_number' => 'Home University Pic Mobile Number',
            'home_university_pic_position' => 'Home University Pic Position',
            'home_university_approval_date' => 'Home University Approval Date',
            'f_language_english_certificate' => 'F Language English Certificate',
            'f_recommendation_letter' => 'F Recommendation Letter',
            'f_passport' => 'F Passport',
            'f_latest_passport_photo' => 'F Latest Passport Photo',
            'f_latest_academic_transcript' => 'F Latest Academic Transcript',
            'f_confirmation_letter' => 'F Confirmation Letter',
            'f_sponsorship_letter' => 'F Sponsorship Letter',
            'f_offer_letter' => 'F Offer Letter',
            'f_proof_of_payment' => 'F Proof Of Payment',
            'kulliyyah_id' => 'Kulliyyah ID',
            'cps_id' => 'Cps ID',
            'agreement' => 'Agreement',
            'token' => 'Token',
            'temp' => 'Temp',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Cps]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCps()
    {
        return $this->hasOne(Pic::class, ['id' => 'cps_id']);
    }

    /**
     * Gets query for [[InboundHostUniversityCourses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInboundHostUniversityCourses()
    {
        return $this->hasMany(InboundHostUniversityCourses::class, ['application_id' => 'id']);
    }

    /**
     * Gets query for [[InboundLogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInboundLogs()
    {
        return $this->hasMany(InboundLog::class, ['inbound_id' => 'id']);
    }

    /**
     * Gets query for [[Kulliyyah]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKulliyyah()
    {
        return $this->hasOne(Pic::class, ['id' => 'kulliyyah_id']);
    }

    /**
     * Gets query for [[OutboundLogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOutboundLogs()
    {
        return $this->hasMany(OutboundLog::class, ['outbound_id' => 'id']);
    }
}
