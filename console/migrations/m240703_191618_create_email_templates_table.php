<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%email_templates}}`.
 */
class m240703_191618_create_email_templates_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%email_templates}}', [
            'id' => $this->primaryKey(),
            'subject' => $this->string(225),
            'body' => $this->text(),
        ]);
        $this->insert('{{%email_templates}}', ['id' => 1 ,
            'subject'
            => 'Incomplete Application Received - Action Required',
            'body'
            => '<p>Dear {user},</p>

                <p>Thank you for your interest in our student exchange program and for initiating the application process. We have received your application; however, it appears that some essential information or documents are missing.</p>
                
                <p>{reason}</p>
                
                <p>To ensure your application can be properly reviewed, we kindly ask you to review the application requirements outlined in our guidelines and provide the missing information/documents as soon as possible.</p>
                
                <p>If you have encountered any difficulties or require clarification regarding the application process, please do not hesitate to reach out to our team for assistance.</p>
                
                <p>We appreciate your attention to this matter and look forward to receiving the complete application.</p>
                
                <p>Best regards,</p>
                
                <p>Office of International Affairs</p>
                
                <p>International Islamic University Malaysia</p>
                '
        ]);
        $this->insert('{{%email_templates}}', ['id' => 2 ,
            'subject'
            => 'Student Exchange Application Decision',
            'body'
            => '<p>Dear {user},</p>
                
                <p>&nbsp;</p>
                
                <p>Thank you for your interest in our student exchange program and for submitting your application. After careful consideration, we regret to inform you that your application has not been selected for participation at this time.</p>
                
                <p>Due to</p>
                
                <p>{reason}</p>
                
                <p>We appreciate your interest and encourage you to consider reapplying in the future or exploring other opportunities for international experiences.</p>
                
                <p>&nbsp;</p>
                
                <p>Best regards,</p>
                
                <p>Office of International Affairs</p>
                
                <p>International Islamic University Malaysia</p>
            '
        ]);
        $this->insert('{{%email_templates}}', ['id' => 3 ,
            'subject'
            => 'Request for Dean Signature - Inbound Student Exchange Application',
            'body'
            => '<p>Dear {user},</p>
                <p>&nbsp;
                <p>I hope this email finds you well.</p>
                </p>
                
                <p>We are currently in the process of reviewing applications for our inbound student exchange program. As part of our approval process, we require the signature of the Dean on each application to proceed.</p>
                
                <p>Could we kindly request your signature on the attached document pertaining to {applicant} Your endorsement is crucial in facilitating the successful participation of our students in this enriching exchange experience.</p>
                
                <p>Your prompt attention to this matter would be greatly appreciated. Should you have any questions or need further information, please do not hesitate to contact us.</p>
                
                <a class="btn btn-email-link" href="{link}">Click Here!</a>
                
                <p>Thank you for your support in advancing our international education initiatives.</p>
                
                <p>Best regards,</p>
                
                <p>Office of International Affairs</p>
                
                <p>International Islamic University Malaysia</p>
            '
        ]);
        $this->insert('{{%email_templates}}', ['id' => 4 ,
            'subject'
            => 'Issuance of Offer Letter - Inbound Student Exchange Program',
            'body'
            => '
                <p>Dear {user},</p>
                
                <p>I trust this email finds you well.</p>
                
                <p>I am writing to inform you that {applicant}, a successful applicant for our inbound student exchange program, has been approved for participation. We kindly request your assistance in issuing the official offer letter to facilitate their enrolment in {sem} {year}.</p>
                
                <p>Please find attached the necessary documentation for processing the offer letter. If there are any specific requirements or additional information needed from our end, please do not hesitate to inform us, and we will promptly provide the necessary assistance.</p>
                
                <p>Your cooperation in expediting this process is greatly appreciated, as it will enable our students to proceed with their preparations for the upcoming exchange period.</p>
                
                <a class="btn btn-email-link" href="{link}">Click Here!</a>
                
                <p>Thank you for your continued support in fostering international collaborations and educational opportunities.</p>
                
                <p>Best regards,</p>
                
                <p>Office of International Affairs</p>
                
                <p>International Islamic University Malaysia</p>

            '
        ]);
        $this->insert('{{%email_templates}}', ['id' => 5 ,
            'subject'
            => 'Request for Submission: Proof of Payment for Exchange Program',
            'body'
            => '<p>Dear {applicant},</p>

                <p>&nbsp;
                <p>Thank you for your interest in participating in our exchange program.</p>
                </p>
                
                <p>We kindly remind you that submission of proof of payment is a crucial step to finalize your enrolment. If you have already made the payment, please provide us with the relevant documentation as soon as possible.</p>
                
                <p>Your cooperation in this matter is greatly appreciated, as it helps us ensure a smooth and efficient process for all participants.</p>
                
                <p>Should you have any questions or require further assistance, please do not hesitate to contact us.</p>
                
                <p>Best regards,</p>
                
                <p>Office of International Affairs</p>
                
                <p>International Islamic University Malaysia</p>
                '
        ]);
        $this->insert('{{%email_templates}}', ['id' => 6 ,
            'subject'
            => 'Action Required: Resubmit Proof of Payment for Exchange Program',
            'body'
            => '<p>Dear {applicant},</p>

                <p>&nbsp;
                <p>We hope this message finds you well.</p>
                </p>
                
                <p>We regret to inform you that the proof of payment you submitted for the exchange program has been deemed invalid. To proceed with your enrolment, we kindly request that you resubmit valid proof of payment as soon as possible.</p>
                
                <p>Please double-check the accuracy and clarity of the uploaded document before submission. If you encounter any difficulties or have any questions regarding the resubmission process, please don&#39;t hesitate to reach out to our support team for assistance.</p>
                
                <p>Thank you for your cooperation in resolving this matter promptly. We appreciate your understanding and look forward to receiving your valid proof of payment.</p>
                
                <p>Best regards,</p>
                
                <p>Office of International Affairs</p>
                
                <p>International Islamic University Malaysia</p>
                '
        ]);
        $this->insert('{{%email_templates}}', ['id' => 7 ,
            'subject'
            => 'Congrats your application is now active',
            'body'
            => '<p>&nbsp;</p>

                <p>Dear &nbsp;{user}&nbsp;,</p>
                
                <p>Congratulations</p>
                '
        ]);
        $this->insert('{{%email_templates}}', ['id' => 8 ,
            'subject'
            => ' Incomplete outbound Student Exchange Application - Action Required',
            'body'
            => '
            <p>Dear {applicant},</p>
            
            <p>Thank you for your interest in our outbound student exchange program.</p>
            
            <p>We have received your application; however, it appears that some essential information or documents are missing. To proceed with the review process, we kindly request that you review the application requirements outlined in our guidelines and provide the missing information/documents at your earliest convenience.</p>
            
            <p>Completing your application is crucial to ensure your eligibility for participation in the exchange program. Please note that failure to provide the required information may result in delays or disqualification from the program.</p>
            
            <p>If you have encountered any difficulties or require clarification regarding the application process, please do not hesitate to reach out to our team for assistance.</p>
            
            <p>We appreciate your attention to this matter and look forward to receiving the complete application.</p>
            
            <p>Best regards,</p>
            
            <p>Office of International Affairs</p>
            
            <p>International Islamic University Malaysia</p>
            '
        ]);
        $this->insert('{{%email_templates}}', ['id' => 9 ,
            'subject'
            => 'outbound Student Exchange Application Status Update',
            'body'
            => '
                <p>Dear {applicant},</p>
                
                <p>Thank you for your interest in our outbound student exchange program and for submitting your application.</p>
                
                <p>After careful review and consideration, we regret to inform you that your application has not been selected for participation in the program at this time. We understand that this news may be disappointing, and we want to express our appreciation for your efforts in applying.</p>
                
                <p>Please know that the selection process was highly competitive, and unfortunately, we were unable to accommodate all applicants. We encourage you to explore alternative opportunities for international experiences and to continue pursuing your academic and personal goals.</p>
                
                <p>We appreciate your interest in our program and wish you all the best in your future endeavors.</p>
                
                <p>Best regards,</p>
                
                <p>Office of International Affairs</p>
                
                <p>International Islamic University Malaysia</p>
                '
        ]);
        $this->insert('{{%email_templates}}', ['id' => 10,
            'subject'
            => 'Request for Signature: Approval for Transfer Credit Matters - outbound Application',
            'body'
            => '<p>Dear {user},</p>

                <p>I trust this email finds you well.</p>
                
                <p>We are currently processing outbound student exchange applications, and as part of the approval process for transfer credit matters, we require the signature of the Head of Department on each application.</p>
                
                <p>Could we kindly request your signature on the attached document pertaining to {applicant} application? Your endorsement is crucial in facilitating the successful participation of our students in this enriching exchange program.</p>
                
                <p>Your prompt attention to this matter would be greatly appreciated. Should you have any questions or require further information, please do not hesitate to contact us.</p>
                
                <p>Thank you for your support in advancing our students&#39; international academic experiences.</p>
                 
                 <a class="btn btn-email-link" href="{link}">Click Here!</a>
                                 
                <p>Best regards,</p>
                
                <p>Office of International Affairs</p>
                
                <p>International Islamic University Malaysia</p>
                
                <p>&nbsp;</p>
                '
        ]);
        $this->insert('{{%email_templates}}', ['id' => 11,
            'subject'
            => 'Request for Dean Signature: outbound Student Exchange Program Approval',
            'body'
            => '
                <p>Dear {user},</p>
                
                <p>I hope this message finds you well.</p>
                
                <p>We are currently in the process of reviewing outbound student exchange applications from your faculty. As part of the approval process, we require the signature of the Dean on each application.</p>
                
                <p>Could we kindly request your signature on the attached document pertaining to {applicant} outbound application? Your endorsement is pivotal in facilitating the successful participation of our students in this valuable exchange experience.</p>
                
                <p>Your timely attention to this matter would be greatly appreciated. If you have any questions or need further information, please feel free to contact us.</p>
                
                <p>Thank you for your support in providing our students with opportunities for enriching educational experiences.</p>
                
                 <a class="btn btn-email-link" href="{link}">Click Here!</a>
                
                <p>Best regards,</p>
                
                <p>Office of International Affairs</p>
                
                <p>International Islamic University Malaysia</p>
                '
        ]);
        $this->insert('{{%email_templates}}', ['id' => 12,
            'subject'
            => 'Reminder: Upload Required Documents Before Departure',
            'body'
            => '
                <p>Dear {applicant},</p>
                
                <p>I hope this message finds you well.</p>
                
                <p>As you prepare for your departure from Malaysia, we kindly remind you to ensure that all necessary documents related to your exchange program are uploaded to our system before your departure date.</p>
                
                <p>These documents may include but are not limited to:</p>
                
                <p>A copy of passport front page</p>
                
                <p>A copy of visa approval (if any)</p>
                
                <p>Flight itinerary</p>
                
                <p>Letter of indemnity</p>
                
                <p>Insurance cover note and information</p>
                
                <p>Any other relevant documentation</p>
                
                <p>Ensuring that we have all required documentation on file before your departure will help facilitate a smooth transition and ensure that you have access to necessary resources while abroad.</p>
                
                <p>If you have already uploaded these documents, we thank you for your cooperation. Otherwise, please log in to our system and complete this step as soon as possible.</p>
                
                <p>Should you have any questions or encounter any difficulties, please do not hesitate to reach out to our support team for assistance.</p>
                
                <p>Safe travels, and we look forward to your participation in the exchange program.</p>
                
                <p>Best regards,</p>
                
                <p>Office of International Affairs</p>
                
                <p>International Islamic University Malaysia</p>
                '
        ]);
        $this->insert('{{%email_templates}}', ['id' => 13,
            'subject'
            => 'Reminder: Upload Documents Upon Return from outbound Exchange Program',
            'body'
            => '<p>Dear {applicant},</p>

                <p>&nbsp;
                <p>Welcome back to Malaysia!</p>
                </p>
                
                <p>We hope you had a rewarding experience during your outbound student exchange program. As you settle back into your routine, we kindly remind you to upload any necessary documents related to your exchange program participation.</p>
                
                <p>These documents may include but are not limited to:</p>
                
                <p>Mobility report</p>
                
                <p>Academic transcripts from the host institution</p>
                
                <p>Completion certificates from the host institution</p>
                
                <p>Five (5) photos</p>
                
                <p>Short video &ndash; 1 minute duration in landscape mode</p>
                
                <p>Any other relevant documentation provided by the host institution or program coordinators</p>
                
                <p>Ensuring that we have all required documents on file is essential for processing transfer credits and updating your academic records accurately.</p>
                
                <p>Please log in to our system and complete this step as soon as possible. If you have any questions or encounter any difficulties, please do not hesitate to reach out to our support team for assistance.</p>
                
                <p>Thank you for your cooperation, and we look forward to hearing about your exchange experience.</p>
                
                <p>Best regards,</p>
                
                <p>Office of International Affairs</p>
                
                <p>International Islamic University Malaysia</p>
                '
        ]);
        $this->insert('{{%email_templates}}', ['id' => 14,
            'subject'
            => 'New Application Submitted',
            'body'
            => 'edit this'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%email_templates}}');
    }
}
