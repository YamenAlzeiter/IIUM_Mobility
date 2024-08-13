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
        $this->execute("
    CREATE OR REPLACE FUNCTION inbound_outbound.inbound_log_function()
    RETURNS TRIGGER AS $$
    BEGIN
       -- Access changed attributes using special variables
       IF (TG_OP = 'INSERT' AND NEW.status = 10) OR 
          (TG_OP = 'UPDATE' AND OLD.status IS DISTINCT FROM NEW.status)
       THEN
           DECLARE
               old_status INTEGER := CASE WHEN TG_OP = 'UPDATE' THEN OLD.status ELSE 0 END;
               new_status INTEGER := NEW.status;
               reason TEXT := NEW.reason;
               creator TEXT := NEW.temp;
               log_message TEXT;
               resubmitted BOOLEAN := FALSE;
               inserted BOOLEAN := FALSE;

           BEGIN 
               -- Determine boolean flags based on conditions
               IF (OLD.status = 7 AND NEW.status = 8) THEN 
                   resubmitted := TRUE;
               ELSIF (OLD.status = 16 AND NEW.status = 17) THEN 
                   resubmitted := TRUE;
               END IF;

               IF (TG_OP = 'INSERT' AND NEW.status = 10) THEN 
                   inserted := TRUE;
               END IF;

               -- Determine if a log message is needed
               IF resubmitted OR TG_OP = 'INSERT' OR 
                  NEW.status IN (5, 6, 16, 36)
               THEN 
                   -- Build the log message
                   log_message := CASE 
                       WHEN inserted THEN 'New Application Submitted' 
                       WHEN resubmitted THEN 'Application Resubmitted'
                       ELSE reason 
                   END;

                   -- Insert into log table 
                   INSERT INTO inbound_outbound.inbound_log (inbound_id, old_status, new_status, message, created_by)
                   VALUES (NEW.id, old_status, new_status, log_message, creator);
               END IF;
           END;
       END IF;

       RETURN NEW; 
    END;
    $$ LANGUAGE plpgsql;
");
// Drop existing trigger if necessary
        $this->execute("
    DROP TRIGGER IF EXISTS inboundlog ON inbound_outbound.inbound;
");

// Create the new trigger
        $this->execute("
    CREATE TRIGGER inboundlog
    AFTER INSERT OR UPDATE ON inbound_outbound.inbound
    FOR EACH ROW 
    EXECUTE FUNCTION inbound_outbound.inbound_log_function();
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%inbound}}');
    }
}
