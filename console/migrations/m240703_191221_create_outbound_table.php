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
            'status' => $this->integer(),

            'matric_card' => $this->char(15),
            'name'  => $this->string(),
            'citizenship' => $this->string(),
            'gender' => $this->string(),
            'birth_date' => $this->date(),
            'mobile_number' => $this->string(),
            'email' => $this->string(),

            'passport_number' => $this->string(),
            'passport_expiration' => $this->date(),

            'country' => $this->string(),
            'state' => $this->string(),
            'permanent_address' => $this->text(),
            'post_code' => $this->string(),

            'mailing_country' => $this->string(),
            'mailing_state' => $this->string(),
            'mailing_permanent_address' => $this->text(),
            'mailing_post_code' => $this->string(),

            'emergency_name' => $this->string(),
            'emergency_relationship' => $this->string(),
            'emergency_mobile_number' => $this->string(),
            'emergency_email' => $this->string(),
            'emergency_country' => $this->string(),
            'emergency_state' => $this->string(),
            'emergency_postcode' => $this->string(),
            'emergency_address' => $this->text(),

            'academic_education_lvl' => $this->string(),
            'academic_kulliyyah' =>$this->string(),
            'academic_current_semester' => $this->string(),
            'academic_current_year' => $this->string(),
            'academic_program_name' => $this->string(),
            'academic_cgpa' => $this->string(),
            'research' => $this->text(),

            'english_proficiency' => $this->string(),
            'english_result' => $this->double(),
            'third_language' => $this->string(),

            'financial_funded_accept' =>$this->string(),
            'sponsorship_name' => $this->string(),
            'sponsorship_funding' => $this->double(),

            'mobility_type' => $this->string(),
            'mobility_program' => $this->string(),
            'mobility_from' => $this->date(),
            'mobility_until' => $this->date(),
            'host_university_name' =>$this->string(),
            'host_university_country' => $this->string(),
            'credit_transform_availability' => $this->string(),

            'host_university_pic_name' => $this->string(),
            'host_university_pic_mobile_number' => $this->string(),
            'host_university_pic_email' => $this->string(),
            'host_university_pic_position' => $this->string(),
            'host_university_pic_country' =>$this->string(),
            'host_university_pic_postcode' => $this->string(),
            'host_university_pic_address' => $this->text(),

            'host_scholarship' => $this->string(),
            'host_scholarship_amount' => $this->string(),

            'f_academic_transcript' => $this->string(),
            'f_program_brochure' => $this->string(),
            'f_latest_payslip' => $this->string(),
            'f_other_latest_payslip' => $this->string(),
            'f_proof_sponsorship' => $this->string(),
            'f_proof_sponsorship_cover' => $this->string(),
            'f_letter_indemnity' => $this->string(),
            'f_flight_ticket' => $this->string(),
            'f_offer_letter' => $this->string(),
            'f_files' => $this->string(),

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

        $this->execute("
    CREATE OR REPLACE FUNCTION inbound_outbound.outbound_log_function()
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
               IF (OLD.status = 3 AND NEW.status = 4) THEN 
                   resubmitted := TRUE;
               ELSIF (OLD.status = 12 AND NEW.status = 13) THEN 
                   resubmitted := TRUE;
               END IF;

               IF (TG_OP = 'INSERT' AND NEW.status = 10) THEN 
                   inserted := TRUE;
               END IF;

               -- Determine if a log message is needed
               IF resubmitted OR TG_OP = 'INSERT' OR 
                  NEW.status IN (1, 2, 12, 32)
               THEN 
                   -- Build the log message
                   log_message := CASE 
                       WHEN inserted THEN 'New Application Submitted' 
                       WHEN resubmitted THEN 'Application Resubmitted'
                       ELSE reason 
                   END;

                   -- Insert into log table 
                   INSERT INTO inbound_outbound.outbound_log (outbound_id, old_status, new_status, message, created_by)
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
    DROP TRIGGER IF EXISTS outboundlog ON inbound_outbound.outbound;
");

// Create the new trigger
        $this->execute("
    CREATE TRIGGER outboundlog
    AFTER INSERT OR UPDATE ON inbound_outbound.outbound
    FOR EACH ROW 
    EXECUTE FUNCTION inbound_outbound.outbound_log_function();
");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%outbound}}');
    }
}
