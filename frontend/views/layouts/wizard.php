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
        <script src = "https://cdn.jsdelivr.net/npm/apexcharts"></script>



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
        'size' => 'modal-xl',
        'bodyOptions' => ['class' =>'modal-inner-padding-body mt-0'],
        'headerOptions' => ['class' => 'modal-inner-padding justify-content-between'],
        'centerVertical' => true,
        'scrollable' => true,
        'footer' =>  '&nbsp;',
    ]);

    echo "<div id='modalContent'></div>";

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