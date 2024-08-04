<?php

/** @var \yii\web\View $this */

/** @var string $content */

use backend\assets\AppAsset;
use common\components\SidebarV2;
use common\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use yii\bootstrap5\Offcanvas;



AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang = "<?= Yii::$app->language ?>" class = "h-100" >

    <head>
        <meta charset = "<?= Yii::$app->charset ?>">

        <script src = "https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src = "https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


        <link rel="shortcut icon" type="image/png" href="https://style.iium.edu.my/images/iium/iium-logo.png">

        <link href="https://style.iium.edu.my/css/iium.css" rel="stylesheet">

        <meta name = "viewport" content = "width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body id="body-pd">

    <?php $this->beginBody() ?>
    <div class="background-image"></div>
    <!-- Preloader start -->
    <div id="preloader">
        <div class="lds-ripple">
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- Preloader end -->
    <header class="header" id="header">
        <?php if (!Yii::$app->user->isGuest): ?>
            <div class="header__toggle">
                <i class='ti ti-menu fs-7' id="header-toggle"></i>
            </div>
        <?php else:?>
            <div class="ms-auto">
                <ul class="list-unstyled mb-0">
                    <li class="d-inline-block">
                        <a href="/site/login" class="text-decoration-none text-white fs-6 ">Login</a>
                    </li>
                </ul>
            </div>
        <?php endif; ?>
    </header>

    <?php if(!Yii::$app->user->isGuest){
        $menuItems = [
            // Settings item to be placed at the top
            [
                'icon' => 'ti ti-layout-dashboard fs-7',
                'optionTitle' => 'Dashboard',
                'items' => [
                    ['url' => 'dashboard/idashboard', 'optionTitle' => 'Inbound'],
                    ['url' => 'dashboard/odashboard', 'optionTitle' => 'Outbound'],
                ]
            ],
            ['url' => 'inbound/index', 'icon' => 'ti ti-arrows-exchange fs-7', 'optionTitle' => 'Inbound'],
            ['url' => 'outbound/index', 'icon' => 'ti ti-outbound fs-7', 'optionTitle' => 'Outbound'],
            ['url' => 'pic/index', 'icon' => 'ti ti-user fs-7', 'optionTitle' => 'Person in Charge'],
            ['url' => 'kcdio/index', 'icon' => 'ti ti-building fs-7', 'optionTitle' => 'K/C/D/I/O'],
        ];
        if(Yii::$app->user->can('admin')){
            $menuItems[] = ['url' => 'user/index', 'icon' => 'ti ti-user-circle fs-7', 'optionTitle' => 'Users'];
            $menuItems[] = ['url' => 'email-template/index', 'icon' => 'ti ti-mail fs-7', 'optionTitle' => 'Email Templates'];
            $menuItems[] = ['url' => 'status/index', 'icon' => 'ti ti-status-change fs-7', 'optionTitle' => 'Status'];
        }


        echo SidebarV2::widget([
            'items' => $menuItems,
        ]);
    }
    ?>
    <main role="main" class="mt-4">
        <div class="container">
            <?= Alert::widget() ?>
            <!--            <div class="container-md my-3 p-4 rounded-3 bg-white shadow">-->
            <?= $content ?>
            <!--            </div>-->
        </div>
    </main>

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