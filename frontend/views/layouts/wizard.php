<?php

/** @var \yii\web\View $this */

/** @var string $content */

use common\components\WizardWidget;
use frontend\assets\wizard;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use yii\bootstrap5\Offcanvas;



wizard::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang = "<?= Yii::$app->language ?>" class = "h-100" >

    <head>
        <meta charset = "<?= Yii::$app->charset ?>">

        <script src = "https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src = "https://code.jquery.com/jquery-3.6.4.min.js"></script>

        <link rel="shortcut icon" type="image/png" href="https://style.iium.edu.my/images/iium/iium-logo.png">

        <link href="https://style.iium.edu.my/css/iium.css" rel="stylesheet">

        <meta name = "viewport" content = "width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>

    <?php $this->beginBody() ?>


    <?php
        if(Yii::$app->user->can('inbound')){
            $terms = "<ul><li>I hereby declare that all the information provided in this application form is true, accurate, and complete in every detail. I acknowledge that the International Islamic University Malaysia (IIUM) reserves the right to amend or revoke any decision regarding my admission or enrolment based on incorrect or incomplete information provided by me.</li><li>I am also aware that my personal details are protected under the Personal Data Protection Act 2010 (PDPA) and will be handled in accordance with the law's provisions. I understand the conditions related to my application and admission, and I agree to pay all applicable fees for which I am responsible. By signing this declaration, I confirm my acceptance of these terms and conditions.</li></ul>";
            $steps = [
                ['number' => 1, 'label' => 'Personal Information'],
                ['number' => 2, 'label' => 'Emergency Contact'],
                ['number' => 3, 'label' => 'Academic Background'],
                ['number' => 4, 'label' => 'Proposed Study at IIUM'],
                ['number' => 5, 'label' => 'Accommodation & Financial'],
                ['number' => 6, 'label' => 'Approval From Home University'],
                ['number' => 7, 'label' => 'Application Checklist'],
            ];
        }else if(Yii::$app->user->can('outbound')){
            $terms = "<ul><li>I hereby declare that all the information provided in this application form is true, accurate, and complete in every detail. I acknowledge that the International Islamic University Malaysia (IIUM) reserves the right to amend or revoke any decision regarding my admission or enrolment based on incorrect or incomplete information provided by me.</li><li>I am also aware that my personal details are protected under the Personal Data Protection Act 2010 (PDPA) and will be handled in accordance with the law's provisions. I understand the conditions related to my application and admission, and I agree to pay all applicable IIUM fees for which I am responsible, including but not limited to those listed in my financial statement. By signing this declaration, I confirm my acceptance of these terms and conditions.</li></ul>";
            $steps = [
                ['number' => 1, 'label' => 'Personal Information'],
                ['number' => 2, 'label' => 'Emergency Contact'],
                ['number' => 3, 'label' => 'Academic Background'],
                ['number' => 4, 'label' => 'Host University Details'],
                ['number' => 5, 'label' => 'Mobility Program Details'],
                ['number' => 6, 'label' => 'Approval From Home University'],
            ];
        }

        echo WizardWidget::widget([
            'steps' => $steps,
            'content' => $content, // This is the content you want to display within the wizard form
        ]);
    ?>


    <?php Modal::begin([
        'title' => '',
        'id' => 'modal',
        'size' => 'modal-lg',
        'bodyOptions' => ['class' =>'modal-inner-padding-body mt-0'],
        'headerOptions' => ['class' => 'modal-inner-padding justify-content-between'],
        'centerVertical' => true,
        'scrollable' => true,
        'footer' =>  '&nbsp;',
    ]);

    echo "<div id='modalContent'>
            $terms
            </div>";

    Modal::end();

    Offcanvas::begin([
        'title' => '', 'placement' => 'end', 'bodyOptions' => ['class' => 'modal-inner-padding-body mt-0'],
        'headerOptions' => ['class' => 'modal-inner-padding justify-content-between flex-row-reverse'], 'options' => [
            'id' => 'myOffcanvas',
        ], 'backdrop' => true
    ]);

    echo "<div id='offcanvas-body'></div>";

    Offcanvas::end();
    ?>

    <?php $this->endBody() ?>


    </body>
    </html>
<?php $this->endPage();?>