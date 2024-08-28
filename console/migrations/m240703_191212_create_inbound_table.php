<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%inbound}}`.
 */
class m240703_191212_create_inbound_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%inbound}}', [
            'id' => $this->primaryKey(),
            'status' => $this->integer(2),

            'name' => $this->string(100),
            'gender' => $this->string(7),
            'relation_ship' => $this->string(30),
            'birth_date' => $this->date(),
            'mobile_number' => $this->string(20),
            'email' => $this->string(50),

            'passport_number' => $this->string(20),
            'passport_expiration' => $this->date(),

            'religion' => $this->string(20),
            'mazhab' => $this->string(20),

            'citizenship' => $this->string(50),
            'country' => $this->string(100),
            'country_of_origin' => $this->string(100),
            'country_of_residence' => $this->string(100),
            'permanent_address' => $this->text(),
            'post_code' => $this->string(10),

            'emergency_name' => $this->string(100),
            'emergency_relationship' => $this->string(30),
            'emergency_mobile_number' => $this->string(20),
            'emergency_email' => $this->string(50),
            'emergency_address' => $this->text(),
            'emergency_postcode' => $this->string(10),
            'emergency_country' => $this->string(100),

            'academic_home_university' => $this->string(100),
            'academic_education_lvl' => $this->string(100),
            'academic_program_name' => $this->string(100),
            'academic_semester' => $this->string(10),
            'academic_year' => $this->string(10),
            'academic_faculty_name' => $this->string(100),
            'academic_result' => $this->string(10),
            'academic_research_title' => $this->text(),

            'memorandum_of_agreement' => $this->string(5),

            'language_is_native_english' => $this->string(5),
            'language_english_test_name' => $this->string(),

            'propose_program_type' => $this->string(50),
            'propose_mobility_type' => $this->string(50),
            'propose_kulliyyah_applied' => $this->string(20),
            'propose_duration_start' => $this->date(),
            'propose_duration_end' => $this->date(),
            'propose_study_duration' => $this->string(),
            'propose_transform_credit_hours' => $this->string(5),

            'financial_accommodation_in_campus' => $this->string(5),
            'campus_location' => $this->text(),
            'financial_funding' => $this->string(50),
            'sponsor_name' => $this->string(100),
            'sponsor_amount' => $this->double(),
            'room_type' => $this->string(50),

            'home_university_pic_name' => $this->string(100),
            'home_university_pic_email' => $this->string(50),
            'home_university_pic_mobile_number' => $this->string(20),
            'home_university_pic_position' => $this->string(50),
            'home_university_approval_date' => $this->date(),

            'f_language_english_certificate' => $this->string(),
            'f_recommendation_letter' => $this->string(),
            'f_passport' => $this->string(),
            'f_latest_passport_photo' => $this->string(),
            'f_latest_academic_transcript' => $this->string(),
            'f_confirmation_letter' => $this->string(),
            'f_sponsorship_letter' => $this->string(),
            'f_offer_letter' => $this->string(),
            'f_proof_of_payment' => $this->string(),
            'f_academic_study_plan' => $this->string(),
            'kulliyyah_id' => $this->integer(3),
            'cps_id' => $this->integer(3),

            'agreement' => $this->boolean(),
            'token' => $this->text(),
            'temp' => $this->text(),
            'reason' => $this->text(),

            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),

        ]);
        $this->addForeignKey(
            'fk-kulliyyah_id',
            '{{inbound}}',
            'kulliyyah_id',
            '{{pic}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-scp_id',
            '{{inbound}}',
            'cps_id',
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
        $this->dropTable('{{%inbound}}');
    }
}
