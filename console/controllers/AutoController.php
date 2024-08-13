<?php

namespace console\controllers;


use common\models\Inbound;
use Carbon\Carbon;
use common\helpers\Variables;
use common\models\EmailTemplates;
use common\models\Outbound;
use Yii;
use yii\console\Controller;

class AutoController extends Controller
{
    public function actionSendEmailReminders()
    {
        $mailer = Yii::$app->mailer;
        $emailTemplate = EmailTemplates::findOne(Variables::requestUploadTripImages);
        // Fetch records where the mobility_until date is two weeks from now

        $twoWeeksFromNow = Carbon::now()->addWeeks(2)->startOfDay()->format('Y-m-d');
        $users = Outbound::find()
            ->where(['<=', 'mobility_until', $twoWeeksFromNow])
            ->all();

        foreach ($users as $user) {
            $recipientEmail = $user->email;
            echo $user->email;
            if ($user->status === Variables::application_accepted) {
                $body = $emailTemplate->body;

                $body = str_replace('{recipientName}', $user->name, $body);

                Yii::$app->mailer->compose(['html' => '@backend/views/email/emailTemplate.php'],
                    ['subject' => $emailTemplate->subject, 'body' => $body])->
                setFrom(["noreply@example.com" => "My Application"])->setTo($recipientEmail)->setSubject($emailTemplate->subject)->send();

                $user->status = Variables::application_reminder_sent;
                $user->save();
            }
        }
    }
    public function actionCheckMobilityStatus()
    {
        $currentDate = Carbon::now()->startOfDay()->format('Y-m-d');
        $outboundModel = Outbound::find()
            ->where(['or',
                ['status' => Variables::application_accepted],
                ['status' => Variables::application_files_uploaded_final],
                ['status' => Variables::application_reminder_sent]
            ])
            ->all();
        $inboundModel = Inbound::find()->where(['status' => Variables::application_accepted_inbound])->all();

        foreach ($outboundModel as $outbound){
            if (strtotime($outbound->mobility_until) < strtotime($currentDate)) {
                echo 'im here';
                $outbound->status = Variables::application_complete_outbound;
                $outbound->save();
            }
        }
        foreach ($inboundModel as $inbound){
            if (strtotime($outbound->propose_duration_end) < strtotime($currentDate)) {
                 $inbound->status = Variables::application_complete_inbound;
                 $inbound->save();
            }
        }
    }
}
