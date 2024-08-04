<?php

namespace common\models;

use common\helpers\Variables;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "outbound".
 *
 * @property int $id
 * @property int|null $status
 * @property string|null $matric_card
 * @property string|null $name
 * @property string|null $citizenship
 * @property string|null $gender
 * @property string|null $birth_date
 * @property string|null $mobile_number
 * @property string|null $email
 * @property string|null $passport_number
 * @property string|null $passport_expiration
 * @property string|null $country
 * @property string|null $state
 * @property string|null $permanent_address
 * @property string|null $post_code
 * @property string|null $mailing_country
 * @property string|null $mailing_state
 * @property string|null $mailing_permanent_address
 * @property string|null $mailing_post_code
 * @property string|null $emergency_name
 * @property string|null $emergency_relationship
 * @property string|null $emergency_mobile_number
 * @property string|null $emergency_email
 * @property string|null $emergency_country
 * @property string|null $emergency_state
 * @property string|null $emergency_postcode
 * @property string|null $emergency_address
 * @property string|null $academic_education_lvl
 * @property string|null $academic_kulliyyah
 * @property string|null $academic_current_semester
 * @property string|null $academic_current_year
 * @property string|null $academic_program_name
 * @property string|null $academic_cgpa
 * @property string|null $research
 * @property string|null $english_proficiency
 * @property float|null $english_result
 * @property string|null $third_language
 * @property string|null $financial_funded_accept
 * @property string|null $sponsorship_name
 * @property float|null $sponsorship_funding
 * @property string|null $mobility_type
 * @property string|null $mobility_program
 * @property string|null $mobility_program_other
 * @property string|null $mobility_from
 * @property string|null $mobility_until
 * @property string|null $host_university_name
 * @property string|null $host_university_country
 * @property string|null $credit_transform_availability
 * @property string|null $host_university_pic_name
 * @property string|null $host_university_pic_mobile_number
 * @property string|null $host_university_pic_email
 * @property string|null $host_university_pic_position
 * @property string|null $host_university_pic_country
 * @property string|null $host_university_pic_postcode
 * @property string|null $host_university_pic_address
 * @property string|null $host_scholarship
 * @property string|null $host_scholarship_amount
 * @property string|null $f_academic_transcript
 * @property string|null $f_program_brochure
 * @property string|null $f_latest_payslip
 * @property string|null $f_other_latest_payslip
 * @property string|null $f_proof_sponsorship
 * @property string|null $f_proof_sponsorship_cover
 * @property string|null $f_letter_indemnity
 * @property string|null $f_flight_ticket
 * @property string|null $f_offer_letter
 * @property string|null $f_files
 * @property int|null $dean_id
 * @property int|null $hod_id
 * @property bool|null $agreement_accept
 * @property string|null $token
 * @property string|null $temp
 * @property string|null $reason
 * @property string|null $updated_at
 * @property string|null $created_at
 *
 * @property Pic $dean
 * @property Pic $hod
 * @property HostUniversityCources[] $hostUniversityCources
 * @property LocalUniversityCources[] $localUniversityCources
 */
class Outbound extends \yii\db\ActiveRecord
{
public $f_academic_transcript_file;
public $f_program_brochure_file;
public $f_latest_payslip_file;
public $f_other_latest_payslip_file;
public $f_proof_sponsorship_file;
public $f_proof_sponsorship_cover_file;
public $f_letter_indemnity_file;
public $f_flight_ticket_file;
public $f_offer_letter_file;
public $f_files_file;
public $mobility_program_other;


public $pic_id;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'outbound';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'matric_card', 'name', 'citizenship', 'gender', 'birth_date', 'mobile_number', 'email', 'passport_number', 'passport_expiration', 'country', 'state', 'permanent_address', 'post_code', 'mailing_country', 'mailing_state', 'mailing_permanent_address', 'mailing_post_code',
                    'emergency_name', 'emergency_relationship', 'emergency_mobile_number', 'emergency_email', 'emergency_country', 'emergency_state', 'emergency_postcode', 'emergency_address',
                    'academic_education_lvl', 'academic_kulliyyah', 'academic_current_semester', 'academic_current_year', 'academic_program_name', 'academic_cgpa',
                    'english_proficiency', 'english_result',
                    'financial_funded_accept',
                    'mobility_type', 'mobility_from',  'mobility_until', 'mobility_program',
                    'host_university_name', 'host_university_country', 'credit_transform_availability', 'host_university_pic_name', 'host_university_pic_mobile_number', 'host_university_pic_email', 'host_university_pic_position', 'host_university_pic_country', 'host_university_pic_postcode', 'host_university_pic_address', 'host_scholarship',
                ],'required', 'on' => 'creating'
            ],
            [['f_offer_letter_file'], 'required', 'when' => function($model) {
                return empty($model->f_offer_letter);
            }, 'on' => 'creating'],
            [['f_academic_transcript_file'], 'required', 'when' => function($model) {
                return empty($model->f_academic_transcript);
            }, 'on' => 'creating'],
            [['f_program_brochure_file'], 'required', 'when' => function($model) {
                return empty($model->f_program_brochure);
            }, 'on' => 'creating'],
            [['f_latest_payslip_file'], 'required', 'when' => function($model) {
                return empty($model->f_latest_payslip);
            }, 'on' => 'creating'],

            [['f_proof_sponsorship_file'], 'required', 'when' => function($model) {
                return empty($model->f_proof_sponsorship);
            }, 'on' => 'uploader'],
            [['f_proof_sponsorship_cover_file'], 'required', 'when' => function($model) {
                return empty($model->f_proof_sponsorship_cover);
            }, 'on' => 'uploader'],
            [['f_letter_indemnity_file'], 'required', 'when' => function($model) {
                return empty($model->f_letter_indemnity);
            }, 'on' => 'uploader'],

            [['status'], 'required', 'on' => 'actioner'],

            [
                ['third_language'], 'required',
                'when' => function ($model) {
                    return $model->english_proficiency == 'Other';
                },
                'whenClient' => "function (attribute, value) {
                    return $('#english-test').val() == 'Other';
                }"
            ],
            [
                ['research'], 'required',
                'when' => function ($model) {
                    return $model->academic_education_lvl == 'Postgraduate';
                },
                'whenClient' => "function (attribute, value) {
                    return $('#education-lvl').val() == 'Other';
                }"
            ],
            [
                ['sponsorship_name', 'sponsorship_funding'], 'required',
                'when' => function ($model) {
                    return $model->english_proficiency == 'Yes';
                },
                'whenClient' => "function (attribute, value) {
                    return $('#funding').val() == 'Yes';
                }"
            ],
            [
                ['host_scholarship_amount'], 'required',
                'when' => function ($model) {
                    return $model->host_scholarship == 'Yes';
                },
                'whenClient' => "function (attribute, value) {
                    return $('#scholarship').val() == 'Yes';
                }"
            ],
            ['passport_expiration', 'validatePassportExpiration'],
            ['mobility_until' , 'compare', 'compareAttribute' => 'mobility_from', 'operator' => '>=', 'message' => 'Proposal duration end must be greater than or equal to proposal duration start.', 'on' => 'creating'],

            [['status', 'dean_id', 'hod_id'], 'default', 'value' => null],
            [['status', 'dean_id', 'hod_id'], 'integer'],
            [['birth_date', 'passport_expiration', 'mobility_from', 'mobility_until', 'updated_at', 'created_at'], 'safe'],
            [['permanent_address', 'mailing_permanent_address', 'emergency_address', 'research', 'host_university_pic_address', 'token', 'temp', 'reason'], 'string'],
            [['english_result', 'sponsorship_funding'], 'number'],
            [['agreement_accept'], 'boolean'],
            [['matric_card'], 'string', 'max' => 15],
            [['name', 'citizenship', 'gender', 'mobile_number', 'email', 'passport_number', 'country', 'state', 'post_code', 'mailing_country', 'mailing_state', 'mailing_post_code', 'emergency_name', 'emergency_relationship', 'emergency_mobile_number', 'emergency_email', 'emergency_country', 'emergency_state', 'emergency_postcode', 'academic_education_lvl', 'academic_kulliyyah', 'academic_current_semester', 'academic_current_year', 'academic_program_name', 'academic_cgpa', 'english_proficiency', 'third_language', 'financial_funded_accept', 'sponsorship_name', 'mobility_type', 'host_university_name', 'host_university_country', 'credit_transform_availability', 'host_university_pic_name', 'host_university_pic_mobile_number', 'host_university_pic_email', 'host_university_pic_position', 'host_university_pic_country', 'host_university_pic_postcode', 'host_scholarship', 'host_scholarship_amount', 'f_academic_transcript', 'f_program_brochure', 'f_latest_payslip', 'f_other_latest_payslip', 'f_proof_sponsorship', 'f_proof_sponsorship_cover', 'f_letter_indemnity', 'f_flight_ticket', 'f_offer_letter', 'f_files', 'mobility_program'], 'string', 'max' => 255],
            [['dean_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pic::class, 'targetAttribute' => ['dean_id' => 'id']],
            [['hod_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pic::class, 'targetAttribute' => ['hod_id' => 'id']],
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
        $uploadPath = Yii::getAlias('@common/uploads/outbound_application_') . $id . '/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $files = [
            'f_academic_transcript_file' => 'f_academic_transcript',
            'f_program_brochure_file' => 'f_program_brochure',
            'f_latest_payslip_file' => 'f_latest_payslip',
            'f_other_latest_payslip_file' => 'f_other_latest_payslip',
            'f_proof_sponsorship_file' => 'f_proof_sponsorship',
            'f_proof_sponsorship_cover_file' => 'f_proof_sponsorship_cover',
            'f_letter_indemnity_file' => 'f_letter_indemnity',
            'f_flight_ticket_file' => 'f_flight_ticket',
            'f_offer_letter_file' => 'f_offer_letter',
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
    public function uploadMultipleFiles($id)
    {
        $files = UploadedFile::getInstances($this, 'f_files_file');
        if ($files) {
            $path = Yii::getAlias('@common/uploads/outbound_application_') . $id . '/gallery/';
            $fileNames = [];

            foreach ($files as $file) {
                $fileName = $file->baseName . '.' . $file->extension;
                $filePath = $path . $fileName;

                if (!file_exists(dirname($filePath))) {
                    mkdir(dirname($filePath), 0777, true);
                }

                if ($file->saveAs($filePath)) {
                    $fileNames[] = $fileName;
                }
            }

            $this->f_files_file = json_encode($fileNames);
            $this->f_files = $path;
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

            'matric_card' => 'Matric Number',
            'name' => 'Name',
            'citizenship' => 'Citizenship',
            'gender' => 'Gender',
            'birth_date' => 'Date of Birth',
            'mobile_number' => 'Mobile Number',
            'email' => 'Email',
            'passport_number' => 'Passport Number',
            'passport_expiration' => 'Passport Expiration',
            'country' => 'Country',
            'state' => 'State',
            'permanent_address' => 'Permanent Address',
            'post_code' => 'Post Code',
            'mailing_country' => 'Mailing Country',
            'mailing_state' => 'Mailing State',
            'mailing_permanent_address' => 'Mailing Address',
            'mailing_post_code' => 'Mailing Post Code',

            'emergency_name' => 'Name',
            'emergency_relationship' => 'Relationship',
            'emergency_mobile_number' => 'Mobile Number',
            'emergency_email' => 'Email',
            'emergency_country' => 'Country',
            'emergency_state' => 'State',
            'emergency_postcode' => 'Postcode',
            'emergency_address' => 'Address',

            'academic_education_lvl' => 'Level of Education',
            'academic_kulliyyah' => 'Kulliyyah',
            'academic_current_semester' => 'Current Semester',
            'academic_current_year' => 'Current Year',
            'academic_program_name' => 'Name of Program',
            'academic_cgpa' => 'CGPA',
                'research' => 'Research',

            'english_proficiency' => 'English Proficiency',
            'english_result' => 'English Result',
                'third_language' => 'Third Language',

            'financial_funded_accept' => 'Financial Funded',
                'sponsorship_name' => 'Sponsorship Name',
                'sponsorship_funding' => 'Sponsorship Funding',

            'mobility_type' => 'Mobility Type',
            'mobility_from' => 'Mobility From',
            'mobility_until' => 'Mobility Until',
            'mobility_program' => 'Mobility Program',

            'host_university_name' => 'Host University Name',
            'host_university_country' => 'Host University Country',
            'credit_transform_availability' => 'Credit Transform Availability',
            'host_university_pic_name' => 'Name',
            'host_university_pic_mobile_number' => 'Mobile Number',
            'host_university_pic_email' => 'Email',
            'host_university_pic_position' => 'Position',
            'host_university_pic_country' => 'Country',
            'host_university_pic_postcode' => 'Postcode',
            'host_university_pic_address' => 'Address',
            'host_scholarship' => 'Scholarship',
                'host_scholarship_amount' => 'Scholarship Amount',

            'f_academic_transcript' => 'Academic Transcript',
            'f_program_brochure' => 'Program Brochure',
            'f_latest_payslip' => 'Latest Payslip',
            'f_other_latest_payslip' => 'Other Latest Payslip',
            'f_proof_sponsorship' => 'Proof Sponsorship',
            'f_proof_sponsorship_cover' => 'Proof Sponsorship Cover',
            'f_letter_indemnity' => 'Letter Indemnity',
            'f_flight_ticket' => 'Flight Ticket',
            'f_offer_letter' => 'Offer Letter',
            'f_files' => 'Files',

            'f_academic_transcript_file' => 'Academic Transcript',
            'f_program_brochure_file' => 'Program Brochure',
            'f_latest_payslip_file' => 'Latest Payslip',
            'f_other_latest_payslip_file' => 'Other Latest Payslip',
            'f_proof_sponsorship_file' => 'Proof Sponsorship',
            'f_proof_sponsorship_cover_file' => 'Proof Sponsorship Cover',
            'f_letter_indemnity_file' => 'Letter Indemnity',
            'f_flight_ticket_file' => 'Flight Ticket',
            'f_offer_letter_file' => 'Offer Letter',
            'f_files_file' => 'Upload photos and videos',

            'dean_id' => 'Dean ID',
            'hod_id' => 'Hod ID',
            'agreement_accept' => 'Agreement Accept',
            'token' => 'Token',
            'temp' => 'Temp',
            'reason' => 'Reason',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Dean]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDean()
    {
        return $this->hasOne(Pic::class, ['id' => 'dean_id']);
    }

    /**
     * Gets query for [[Hod]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHod()
    {
        return $this->hasOne(Pic::class, ['id' => 'hod_id']);
    }

    /**
     * Gets query for [[HostUniversityCources]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHostUniversityCources()
    {
        return $this->hasMany(HostUniversityCources::class, ['application_id' => 'id']);
    }

    /**
     * Gets query for [[LocalUniversityCources]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLocalUniversityCources()
    {
        return $this->hasMany(LocalUniversityCources::class, ['application_id' => 'id']);
    }
    public function getCountry()
    {
        return $this->hasOne(Country::class, ['country' => 'id']);
    }
}
