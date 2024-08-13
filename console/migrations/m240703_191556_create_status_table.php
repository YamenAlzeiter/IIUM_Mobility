<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%status}}`.
 */
class m240703_191556_create_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%status}}', [
            'id' => $this->primaryKey(),
            'status' => $this->integer(3),
            'tag' => $this->string(20),
            'description' => $this->string(522),
            'type' => $this->string()
        ]);
        $this->insert('{{%status}}', ['status' => 10, 'tag' => 'Init-01', 'description' => 'Applicant Submitted his Application to International Office', 'type' => 'I/O']);

        $this->insert('{{%status}}', ['status' => 1, 'tag' => 'IP-HOD', 'description' => 'Application Submitted to HOD for reviewal', 'type' => 'O']);
        $this->insert('{{%status}}', ['status' => 2, 'tag' => 'Rej-IO', 'description' => 'Applicant Rejected by IO', 'type' => 'O']);
        $this->insert('{{%status}}', ['status' => 3, 'tag' => 'Inc-Applicant', 'description' => 'Applicant is not Complete Returned Back to Applicant to Complete Missing Information', 'type' => 'O']);
        $this->insert('{{%status}}', ['status' => 4, 'tag' => 'App_Resub', 'description' => 'Applicant Resubmitted to IO', 'type' => 'O']);
        $this->insert('{{%status}}', ['status' => 11, 'tag' => 'IP-IO', 'description' => 'Application is Approved by HOD and Returned Back to International Office', 'type' => 'O']);
        $this->insert('{{%status}}', ['status' => 12, 'tag' => 'Rej-HOD', 'description' => 'Application is Rejected by HOD and Returned Back to International Office', 'type' => 'O']);
        $this->insert('{{%status}}', ['status' => 13, 'tag' => 'IO-Resub', 'description' => 'International Office Resubmit Application to HOD for Further Consideration', 'type' => 'O']);
        $this->insert('{{%status}}', ['status' => 21, 'tag' => 'IP-Dean', 'description' => 'Application Submitted to Selected Dean for Reviewal', 'type' => 'O']);
        $this->insert('{{%status}}', ['status' => 31, 'tag' => 'IP-IO', 'description' => 'Application Approved by Selected Dean and Returned Back to International Office', 'type' => 'O']);
        $this->insert('{{%status}}', ['status' => 32, 'tag' => 'Rej-Dean', 'description' => 'Application Rejected by Selected Dean', 'type' => 'O']);
        $this->insert('{{%status}}', ['status' => 41, 'tag' => 'IP-Applicant', 'description' => 'Application Returned to Applicant to Upload Required Files', 'type' => 'O']);
        $this->insert('{{%status}}', ['status' => 51, 'tag' => 'IP-IO', 'description' => 'Applicant Uploaded Required Files and Submitted to International Office for Revival', 'type' => 'O']);
        $this->insert('{{%status}}', ['status' => 61, 'tag' => 'Active', 'description' => 'Application Approved by IO and is Now Active', 'type' => 'O']);
        $this->insert('{{%status}}', ['status' => 63, 'tag' => 'Inc-Applicant', 'description' => 'Applicant is not Complete Returned Back to Applicant to Complete Missing Files', 'type' => 'O']);
        $this->insert('{{%status}}', ['status' => 71, 'tag' => 'Reminded', 'description' => 'Applicant Received Reminder to Upload....', 'type' => 'O']);
        $this->insert('{{%status}}', ['status' => 81, 'tag' => 'post_file_uploaded', 'description' => 'Mobility....', 'type' => 'O']);
        $this->insert('{{%status}}', ['status' => 91, 'tag' => 'Complete', 'description' => 'Mobility....', 'type' => 'O']);

        $this->insert('{{%status}}', ['status' => 5, 'tag' => 'IP-KCDIO', 'description' => 'Application Submitted to KCDIO for Reviewal', 'type' => 'I']);
        $this->insert('{{%status}}', ['status' => 6, 'tag' => 'Rej-IO', 'description' => 'Applicant Rejected by IO', 'type' => 'I']);
        $this->insert('{{%status}}', ['status' => 7, 'tag' => 'Inc-Applicant', 'description' => 'Applicant is not Complete Returned Back to Applicant to Complete Missing Information', 'type' => 'I']);
        $this->insert('{{%status}}', ['status' => 8, 'tag' => 'App_Resub', 'description' => 'Applicant Resubmitted to IO', 'type' => 'I']);
        $this->insert('{{%status}}', ['status' => 10, 'tag' => 'Init-01', 'description' => 'Applicant Submitted his Application to International Office', 'type' => 'I/O']);
        $this->insert('{{%status}}', ['status' => 15, 'tag' => 'IP-IO', 'description' => 'Application is Approved by Selected KCDIO Person in Charge and Returned Back to Internation Office', 'type' => 'I']);
        $this->insert('{{%status}}', ['status' => 16, 'tag' => 'Rej-KCDIO', 'description' => 'Application is Rejected by HOD and Returned Back To International Office', 'type' => 'I']);
        $this->insert('{{%status}}', ['status' => 17, 'tag' => 'IO-Resub', 'description' => 'International Office Resubmit Application to Selected KCDIO for Further Consideration', 'type' => 'I']);
        $this->insert('{{%status}}', ['status' => 25, 'tag' => 'IP-AMAD/CPS', 'description' => 'Application Submitted to either AMAD or CPS for Issuing Offer Letter', 'type' => 'I']);
        $this->insert('{{%status}}', ['status' => 35, 'tag' => 'Issued-OfferLetter', 'description' => 'Offer Letter has been Issued and Application Returned Back to International Office', 'type' => 'I']);
        $this->insert('{{%status}}', ['status' => 45, 'tag' => 'IP-Applicant', 'description' => 'Application Returned to Applicant to Upload Required Files', 'type' => 'I']);
        $this->insert('{{%status}}', ['status' => 55, 'tag' => 'IP-IO', 'description' => 'Applicant Uploaded Required Files and Submitted to International Office for Revival', 'type' => 'I']);
        $this->insert('{{%status}}', ['status' => 65, 'tag' => 'Active', 'description' => 'Applicant', 'type' => 'I']);
        $this->insert('{{%status}}', ['status' => 67, 'tag' => 'Inc-Applicant', 'description' => 'Applicant is not Complete Returned Back to Applicant to Complete Missing Information', 'type' => 'I']);
        $this->insert('{{%status}}', ['status' => 95, 'tag' => 'Complete', 'description' => 'Mobility....', 'type' => 'I']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%status}}');
    }
}
