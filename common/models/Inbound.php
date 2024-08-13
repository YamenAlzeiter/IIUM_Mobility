<?php

namespace common\models;

use Yii;
use yii\bootstrap5\Html;
use yii\web\UploadedFile;
use function Symfony\Component\Translation\t;

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
 * @property string|null $f_academic_study_plan
 * @property int|null $kulliyyah_id
 * @property int|null $cps_id
 * @property bool|null $agreement
 * @property string|null $token
 * @property string|null $temp
 * @property string|null $reason
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
    public $language_english_test_name_other;
    public $propose_program_type_other;
    public $financial_funding_other;

    public $f_language_english_certificate_file;
    public $f_recommendation_letter_file;
    public $f_passport_file;
    public $f_latest_passport_photo_file;
    public $f_latest_academic_transcript_file;
    public $f_confirmation_letter_file;
    public $f_sponsorship_letter_file;
    public $f_offer_letter_file;
    public $f_proof_of_payment_file;
    public $f_academic_study_plan_file;
    public $pic_id;
    public $file_mail;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%inbound}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'name', 'gender', 'relation_ship', 'birth_date', 'mobile_number', 'email', 'passport_number', 'passport_expiration', 'religion', 'mazhab', 'citizenship', 'country', 'country_of_origin', 'country_of_residence', 'permanent_address', 'post_code',
                    'emergency_name', 'emergency_relationship', 'emergency_mobile_number', 'emergency_email', 'emergency_address', 'emergency_postcode', 'emergency_country',
                    'academic_home_university', 'academic_education_lvl', 'academic_program_name', 'academic_program_name',  'academic_year', 'academic_faculty_name', 'academic_result',
                    'memorandum_of_agreement', 'language_is_native_english', 'language_english_test_name',
                    'propose_program_type',  'propose_mobility_type', 'propose_kulliyyah_applied', 'propose_duration_start', 'propose_duration_end', 'propose_transform_credit_hours',
                    'financial_accommodation_in_campus', 'financial_funding',
                    'home_university_pic_name', 'home_university_pic_email', 'home_university_pic_mobile_number', 'home_university_pic_position', 'home_university_approval_date',
                ],'required', 'on' => 'creating'
            ],
            [
                [
                    'f_language_english_certificate_file', 'f_recommendation_letter_file', 'f_passport_file',
                    'f_latest_academic_transcript_file', 'f_confirmation_letter_file', 'f_latest_passport_photo_file',
                    'f_sponsorship_letter_file', 'f_offer_letter_file', 'f_proof_of_payment_file'
                ], 'file', 'extensions' => 'pdf'
            ],

            [['f_language_english_certificate_file'], 'required', 'when' => function($model) {
                return empty($model->f_language_english_certificate);
            }, 'on' => 'creating'],

            [['f_recommendation_letter_file'], 'required', 'when' => function($model) {
                return empty($model->f_recommendation_letter);
            }, 'on' => 'creating'],

            [['f_passport_file'], 'required', 'when' => function($model) {
                return empty($model->f_passport);
            }, 'on' => 'creating'],

            [['f_latest_academic_transcript_file'], 'required', 'when' => function($model) {
                return empty($model->f_latest_academic_transcript);
            }, 'on' => 'creating'],

            [['f_proof_of_payment_file'], 'required', 'when' => function($model) {
                return empty($model->f_proof_of_payment);
            }, 'on' => 'uploader'],


            // Conditional required rules
            [
                ['language_english_test_name_other'], 'required',
                'when' => function ($model) {
                    return $model->language_english_test_name == 'Other';
                },
                'whenClient' => "function (attribute, value) {
                    return $('#english-test').val() == 'Other';
                }"
            ],
            [
                ['propose_program_type_other'], 'required',
                'when' => function ($model) {
                    return $model->propose_program_type == 'Other';
                },
                'whenClient' => "function (attribute, value) {
                    return $('#programme-type').val() == 'Other';
                }"
            ],
            [
                ['financial_funding_other'], 'required',
                'when' => function ($model) {
                    return $model->financial_funding == 'Other';
                },
                'whenClient' => "function (attribute, value) {
                    return $('#funding').val() == 'Other';
                }"
            ],
            [
                ['sponsor_amount', 'sponsor_name'], 'required',
                'when' => function ($model) {
                    return $model->financial_funding == 'Scholarship';
                },
                'whenClient' => "function (attribute, value) {
                    return $('#funding').val() == 'Scholarship';
                }"
            ],
            [
                ['room_type', 'campus_location'], 'required',
                'when' => function ($model) {
                    return $model->financial_accommodation_in_campus == 'Yes';
                },
                'whenClient' => "function (attribute, value) {
                    return $('#accommodation').val() == 'Yes';
                }"
            ],
            ['file_mail', 'file', 'extensions' => 'pdf'],
            [['status'], 'required', 'on' => 'actioner'],
            ['passport_expiration', 'validatePassportExpiration'],
            ['propose_duration_end' , 'compare', 'compareAttribute' => 'propose_duration_start', 'operator' => '>=', 'message' => 'Proposal duration end must be greater than or equal to proposal duration start.', 'on' => 'creating'],
            ['propose_duration_start', 'validateDate' , 'on' => 'creating'],
            [['status', 'kulliyyah_id', 'cps_id'], 'default', 'value' => null],
            [['status', 'kulliyyah_id', 'cps_id'], 'integer'],
            [['birth_date', 'passport_expiration', 'propose_duration_start', 'propose_duration_end', 'home_university_approval_date', 'updated_at', 'created_at'], 'safe'],
            [['permanent_address', 'emergency_address', 'academic_research_title', 'campus_location', 'f_language_english_certificate', 'f_recommendation_letter', 'f_passport', 'f_latest_passport_photo', 'f_latest_academic_transcript', 'f_confirmation_letter', 'f_sponsorship_letter', 'f_offer_letter', 'f_proof_of_payment', 'token', 'temp'], 'string'],
            [['academic_result', 'sponsor_amount'], 'number'],
            [[ 'agreement'], 'boolean'],
            [['language_is_native_english', 'name', 'gender', 'relation_ship', 'mobile_number', 'email', 'passport_number', 'religion', 'mazhab', 'citizenship', 'country', 'country_of_origin', 'country_of_residence', 'post_code', 'emergency_name', 'emergency_relationship', 'emergency_mobile_number', 'emergency_email', 'emergency_postcode', 'emergency_country', 'academic_home_university', 'academic_education_lvl', 'academic_program_name', 'academic_semester', 'academic_year', 'academic_faculty_name', 'memorandum_of_agreement', 'language_english_test_name', 'propose_program_type', 'propose_mobility_type', 'propose_kulliyyah_applied', 'propose_study_duration', 'propose_transform_credit_hours', 'financial_accommodation_in_campus', 'financial_funding', 'sponsor_name', 'room_type', 'home_university_pic_name', 'home_university_pic_email', 'home_university_pic_mobile_number', 'home_university_pic_position'], 'string', 'max' => 255],
            [['kulliyyah_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pic::class, 'targetAttribute' => ['kulliyyah_id' => 'id']],
            [['cps_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pic::class, 'targetAttribute' => ['cps_id' => 'id']],
        ];
    }

    public function validatePassportExpiration($attribute, $params)
    {
        $expirationDate = strtotime($this->$attribute);
        $sixMonthsLater = strtotime("+6 months");

        if ($expirationDate < $sixMonthsLater) {
            $this->addError($attribute, 'Passport expiration date must be at least 6 months after the current date.');
        }
    }
    public function validateDate($attribute, $params)
    {
        $date = strtotime($this->$attribute);
        $currentDate = strtotime(date('Y-m-d'));

        if ($date < $currentDate) {
            $this->addError($attribute, 'Date must be greater than or equal to the current date.');
        }
    }
    public function uploadFiles($id)
    {
        $uploadPath = Yii::getAlias('@common/uploads/inbound_application_') . $id . '/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $files = [
            'f_language_english_certificate_file' => 'f_language_english_certificate',
            'f_recommendation_letter_file' => 'f_recommendation_letter',
            'f_passport_file' => 'f_passport',
            'f_latest_passport_photo_file' => 'f_latest_passport_photo',
            'f_latest_academic_transcript_file' => 'f_latest_academic_transcript',
            'f_confirmation_letter_file' => 'f_confirmation_letter',
            'f_sponsorship_letter_file' => 'f_sponsorship_letter',
            'f_offer_letter_file' => 'f_offer_letter',
            'f_proof_of_payment_file' => 'f_proof_of_payment',
            'f_academic_study_plan_file' => 'f_academic_study_plan'
        ];

        foreach ($files as $fileAttr => $dbAttr) {
            $file = UploadedFile::getInstance($this, $fileAttr);
            if ($file) {
                if (!empty($this->$dbAttr)) {
                    $oldFilePath = $uploadPath . $this->$dbAttr;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
                $fileName = $file->baseName . '.' . $file->extension;
                $file->saveAs($uploadPath . $fileName);
                $this->$dbAttr = $fileName;
            }
        }
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
            'relation_ship' => 'Relationship',
            'birth_date' => 'Date of Birth',
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

            'emergency_name' => 'Name',
            'emergency_relationship' => 'Relationship',
            'emergency_mobile_number' => 'Mobile Number',
            'emergency_email' => 'Email',
            'emergency_address' => 'Address',
            'emergency_postcode' => 'Postcode',
            'emergency_country' => 'Country',

            'academic_home_university' => 'Home University',
            'academic_education_lvl' => 'Education Level',
            'academic_program_name' => 'Program Name',
            'academic_semester' => 'Semester',
            'academic_year' => 'Year',
            'academic_faculty_name' => 'Faculty Name',
            'academic_result' => 'Result',
            'academic_research_title' => 'Research Title',

            'memorandum_of_agreement' => 'Memorandum Of Agreement',

            'language_is_native_english' => 'Language Is Native English',
            'language_english_test_name' => 'Language English Test Name',
            'language_english_test_name_other' => 'Other',

            'propose_program_type' => 'Propose Program Type',
            'propose_program_type_other' => 'Other',
            'propose_mobility_type' => 'Propose Mobility Type',
            'propose_kulliyyah_applied' => 'Propose Kulliyyah Applied',
            'propose_duration_start' => 'Propose Duration Start',
            'propose_duration_end' => 'Propose Duration End',
            'propose_study_duration' => 'Propose Study Duration',
            'propose_transform_credit_hours' => 'Propose Transform Credit Hours',

            'financial_accommodation_in_campus' => 'Financial Accommodation In Campus',
            'campus_location' => 'Campus Location',
            'room_type' => 'Room Type',

            'financial_funding' => 'Financial Funding',
            'financial_funding_other' => 'Other',
            'sponsor_name' => 'Sponsor Name',
            'sponsor_amount' => 'Sponsor Amount',

            'home_university_pic_name' => 'Home University Pic Name',
            'home_university_pic_email' => 'Home University Pic Email',
            'home_university_pic_mobile_number' => 'Home University Pic Mobile Number',
            'home_university_pic_position' => 'Home University Pic Position',
            'home_university_approval_date' => 'Home University Approval Date',

            'f_language_english_certificate' => 'Language English Certificate',
            'f_recommendation_letter' => 'Recommendation Letter',
            'f_passport' => 'Passport',
            'f_latest_passport_photo' => 'Scanned of Passport Info Page',
            'f_latest_academic_transcript' => 'Latest Academic Transcript (Written in English)',
            'f_confirmation_letter' => 'Confirmation Letter (from Home University)',
            'f_sponsorship_letter' => 'Sponsorship Letter',
            'f_offer_letter' => 'Offer Letter',
            'f_proof_of_payment' => 'Proof Of Payment',
            'file_mail' => 'Attached File' ,


            'f_passport_file' => 'Passport Information Page',
            'f_latest_passport_photo_file' => 'Passport Photo',
            'f_latest_academic_transcript_file' => 'Full Academic Transcript',
            'f_sponsorship_letter_file' => 'Official Letter of Sponsorship',
            'f_confirmation_letter_file' => 'Confirmation Letter of Enrollment (from Home University)',
            'f_proof_of_payment_file' => 'Receipt Payment of processing fee 100USD',
            'f_academic_study_plan_file' => 'Study Plan at Home University',
            'f_language_english_certificate_file' => 'English Certificate',

            'f_recommendation_letter_file' => 'Recommendation Letter',
            'f_offer_letter_file' => 'Offer Letter',

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
