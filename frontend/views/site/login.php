<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row justify-content-center w-100">
    <div class="col-12 col-xxl-12 p-0">
        <div class="card border-light-subtle shadow-sm">
            <div class="row g-0">
                <div class="col-12 col-md-8">
                    <?php echo \yii\helpers\Html::img(Yii::getAlias('@web') . '/login-bg.jpg', [
                        'class' => 'img-fluid rounded-start w-100 h-100 object-fit-cover'
                    ]) ?>

                </div>
                <div class="col-12 col-md-4 d-flex align-items-center justify-content-center">
                    <div class="col-12 col-lg-11 col-xl-10">
                        <div class="card-body p-3 p-md-4 p-xl-5">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-5">
                                        <div class="text-center mb-4">
                                            <a href="/site">
                                                <?php echo \yii\helpers\Html::img(Yii::getAlias('@web') . '/iiumLogo.svg', [
                                                    'class' => 'ti ti-letter-t fs-7 nav__logo-icon',
                                                    'height' => '57',
                                                    'width' => '175'
                                                ]) ?>
                                            </a>
                                        </div>
                                        <h4 class="text-center">Login</h4>
                                    </div>
                                </div>
                            </div>
                            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                                <div class="row gy-3 overflow-hidden">
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <?= $form->field($model, 'username', [
                                                'template' => "{input}\n{label}\n{error}",
                                                'options' => ['class' => 'form-floating'],
                                            ])->textInput([
                                                'class' => 'form-control',
                                                'placeholder' => 'Username',
                                                'autofocus' => true,
                                            ])->label('Username', ['class' => 'form-label']) ?>
                                        </div>

                                    </div>

                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <?= $form->field($model, 'password', [
                                                'template' => "{input}\n{label}\n{error}",
                                                'options' => ['class' => 'form-floating'],
                                            ])->passwordInput([
                                                'class' => 'form-control',
                                                'placeholder' => 'Password',
                                            ])->label('Password', ['class' => 'form-label']) ?>
                                        </div>

                                    </div>
                                    <div class="col-12">
                                        <?= $form->field($model, 'rememberMe')->checkbox() ?>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-grid">
                                            <?= Html::submitButton('Login', ['class' => 'btn btn-dark btn-lg', 'name' => 'login-button']) ?>
                                        </div>
                                    </div>
                                </div>
                            <?php ActiveForm::end(); ?>
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-center mt-5">

                                        <?= \yii\helpers\Html::a('Create new account', ['site/signup'], [
                                            'class' => 'link-secondary text-decoration-none'
                                        ]) ?>
                                        <?= \yii\helpers\Html::a('Forgot password', ['site/request-password-reset'], [
                                            'class' => 'link-secondary text-decoration-none'
                                        ]) ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
