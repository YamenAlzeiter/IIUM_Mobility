<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%outbound}}`.
 */
class m240703_191221_create_outbound_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%outbound}}', [
            'id' => $this->primaryKey(),
            'status' => $this->integer(2),

            'matric_card' => $this->char(15),
            'name'  => $this->string(100),
            'citizenship' => $this->string(50),
            'gender' => $this->string(7),
            'birth_date' => $this->date(),
            'mobile_number' => $this->string(20),
            'email' => $this->string(50),

            'passport_number' => $this->string(20),
            'passport_expiration' => $this->date(),

            'country' => $this->string(100),
            'state' => $this->string(100),
            'permanent_address' => $this->text(),
            'post_code' => $this->string(10),

            'mailing_country' => $this->string(100),
            'mailing_state' => $this->string(100),
            'mailing_permanent_address' => $this->text(),
            'mailing_post_code' => $this->string(10),

            'emergency_name' => $this->string(100),
            'emergency_relationship' => $this->string(20),
            'emergency_mobile_number' => $this->string(20),
            'emergency_email' => $this->string(50),
            'emergency_country' => $this->string(100),
            'emergency_state' => $this->string(100),
            'emergency_postcode' => $this->string(100),
            'emergency_address' => $this->text(),

            'academic_education_lvl' => $this->string(20),
            'academic_kulliyyah' =>$this->string(100),
            'academic_current_semester' => $this->string(10),
            'academic_current_year' => $this->string(7),
            'academic_program_name' => $this->string(100),
            'academic_cgpa' => $this->string(10),
            'research' => $this->text(),

            'english_proficiency' => $this->string(50),
            'english_result' => $this->double(),
            'third_language' => $this->string(50),

            'financial_funded_accept' =>$this->string(4),
            'sponsorship_name' => $this->string(50),
            'sponsorship_funding' => $this->double(),

            'mobility_type' => $this->string(15),
            'mobility_program' => $this->string(50),
            'mobility_from' => $this->date(),
            'mobility_until' => $this->date(),
            'host_university_name' =>$this->string(100),
            'host_university_country' => $this->string(100),
            'credit_transform_availability' => $this->string(5),

            'host_university_pic_name' => $this->string(100),
            'host_university_pic_mobile_number' => $this->string(20),
            'host_university_pic_email' => $this->string(50),
            'host_university_pic_position' => $this->string(50),
            'host_university_pic_country' =>$this->string(100),
            'host_university_pic_postcode' => $this->string(10),
            'host_university_pic_address' => $this->text(),

            'host_scholarship' => $this->string(5),
            'host_scholarship_amount' => $this->string(10),

            'f_offer_letter' => $this->string(),
            'f_letter_indemnity' => $this->string(),
            'f_flight_ticket' => $this->string(),
            'f_travel_insurance' => $this->string(),
            'f_academic_transcript' => $this->string(),
            'f_travel_insurance_cover_note' => $this->string(),
            'f_program_brochure' => $this->string(),
            'f_latest_payslip' => $this->string(),
            'f_other_latest_payslip' => $this->string(),
            'f_proof_sponsorship' => $this->string(),
            'f_proof_sponsorship_cover' => $this->string(),
            'f_files' => $this->string(),

            'f_certificate_attendance' => $this->string(),
            'f_academic_transcript_host_university' => $this->string(),
            'f_mobility_report' => $this->string(),

            'dean_id' => $this->integer(),
            'hod_id' => $this->integer(),

            'agreement_accept' => $this->boolean(),
            'token' => $this->text(),
            'temp' => $this->text(),
            'reason' => $this->text(),

            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),


        ]);
        $this->addForeignKey(
            'fk-dean_id',
            '{{outbound}}',
            'dean_id',
            '{{pic}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-hod_id',
            '{{outbound}}',
            'hod_id',
            '{{pic}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%outbound}}');
    }
}
