<?php

/** @var yii\web\View $this */
/** @var string $content */

use frontend\assets\landing;
use yii\helpers\Html;

landing::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <link rel="shortcut icon" type="image/png" href="https://style.iium.edu.my/images/iium/iium-logo.png">
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<?= $content ?>
<div class="footer" id="footer">
    <div class="logo">
        <?= Html::a(Html::img(Yii::getAlias('@web') . '/iiumLogo.svg', ['class' => 'logoface']), 'index', ['class' => 'logo']) ?>
        <a href="/site" target="_blank"><h2 class="sitename reversed">Memorandum Program</h2></a>
    </div>

    <div class="footer-cols">
        <div class="footer-col">
            <h4 class="fw-bolder">
                Contact Us:
            </h4>
            <p>
                <span class="fw-bolder">Office of International Affairs (IO)</span><br>
                <span>International Islamic University Malaysia <br> 50728 Kuala Lumpur, Malaysia</span><br>
                <span class="fw-bolder">Phone:</span> (+603)6421 6421 <br>
                <span class="fw-bolder">Email:</span> io@iium.edu.my
            </p>
        </div>
        <div class="footer-col">
            <a href="/site/index" class="menu-item active">Home</a>
            <a href="/site/faq" class="menu-item">FAQ</a>
            <a href="#contact" class="menu-item">Contact</a>
            <a href="/site/login" class="menu-item">Sign In</a>
        </div>
        <div class="footer-col">
<!--            <a href="/site/index" class="menu-item active"><i class="ti ti-brand-facebook"></i></a>-->
<!--            <a href="/site/faq" class="menu-item"><i class="ti ti-brand-x"></i></a>-->
<!--            <a href="#contact" class="menu-item"><i class="ti ti-brand-instagram"></i></a>-->
<!--            <a href="/site/login" class="menu-item"><i class="ti ti-brand-youtube"></i></a>-->
        </div>

    </div>
    <p class="sub">&copy; 2024 IIUM. All rights reserved.</p>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
