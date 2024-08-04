<?php

namespace common\helpers;

class Variables
{

//outbound status
    const application_init = 10;
    const redirected_to_hod = 1;
    const application_rejected = 2;
    const application_not_complete = 3;
    const application_resubmitted = 4;
    const application_accepted_hod = 11;
    const application_rejected_hod = 12;
    const application_resubmitted_to_hod = 13;
    const redirected_to_dean = 21;
    const application_accepted_dean = 31;
    const application_rejected_dean = 32;
    const redirected_to_student_UPLOAD_files = 41;
    const application_files_uploaded = 51;
    const application_accepted = 61;
    const application_files_not_complete = 63;
    const application_reminder_sent = 71;
    const application_files_uploaded_final = 81;
    const application_complete_outbound = 85;

//inbound status
    const application_redirected_kcdio_inbound = 5;
    const application_rejected_inbound = 6;
    const application_not_complete_inbound = 7;
    const application_resubmitted_inbound = 8;
    const application_accepted_kcdio_inbound = 15;
    const application_rejected_kcdio_inbound = 16;
    const application_resubmitted_to_kcdio_inbound = 17;
    const application_redirected_amad_inbound = 25;
    const application_got_offer_letter_inbound = 35;
    const application_redirected_upload_inbound = 45;
    const application_files_uploaded_inbound = 55;
    const application_accepted_inbound = 65;
    const application_files_not_complete_inbound = 67;
    const application_complete_inbound = 85;





//    Email Templates
    const newApplication = 14;
    const incompleteApplicationInBound = 1;
    const rejectedApplicationInBound = 2;
    const requestDeanSignatureInBound = 3;
    const requestOfferLetterInBound = 4;
    const requestUploadProofOfPayment = 5;
    const uploadedFilesNotComplete = 6;
    const applicationActive = 7;
    const incompleteApplicationOutBound = 8;
    const rejectedApplicationOutBound = 9;
    const requestHodSignatureOutBound = 10;
    const requestDeanSignatureOutBound = 11;
    const requestUploadDocsOutBound = 12;
    const requestUploadTripImages = 13;



    public static $ioEmail = 'support@example.com';
}
