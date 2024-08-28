<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\SignupForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<!--<div class="site-signup">-->
<!--    <h1>--><?php //= Html::encode($this->title) ?><!--</h1>-->
<!---->
<!--    <p>Please fill out the following fields to signup:</p>-->
<!---->
<!--    <div class="row">-->
<!--        <div class="col-lg-5">-->
<!--            --><?php //$form = ActiveForm::begin(['id' => 'form-signup']); ?>
<!---->
<!--                --><?php //= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
<!---->
<!--                --><?php //= $form->field($model, 'email') ?>
<!---->
<!--                --><?php //= $form->field($model, 'password')->passwordInput() ?>
<!---->
<!--            --><?php //= $form->field($model, 'type')->dropDownList(['inbound' => 'inbound', 'outbound' => 'outbound'],['prompt' => 'select one']) ?>
<!--            --><?php //= $form->field($model, 'matric_number') ?>
<!---->
<!--                <div class="form-group">-->
<!--                    --><?php //= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
<!--                </div>-->
<!---->
<!--            --><?php //ActiveForm::end(); ?>
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

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
                                        <h4 class="text-center">Sign up</h4>
                                    </div>
                                </div>
                            </div>
                            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
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
                                        <?= $form->field($model, 'email', [
                                            'template' => "{input}\n{label}\n{error}",
                                            'options' => ['class' => 'form-floating'],
                                        ])->textInput([
                                            'class' => 'form-control',
                                            'placeholder' => 'Username',
                                            'autofocus' => true,
                                        ])->label('Email', ['class' => 'form-label']) ?>
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
                                    <div class="form-floating mb-3">
                                        <?= $form->field($model, 'type', [
                                            'template' => "{input}\n{label}\n{error}",
                                            'options' => ['class' => 'form-floating'],
                                        ])->dropDownList(
                                            ['inbound' => 'inbound', 'outbound' => 'outbound'],
                                            ['class' => 'form-select', 'prompt' => 'Select one', 'id' => 'type-select']
                                        )->label('Type', ['class' => 'form-label']) ?>
                                    </div>
                                </div>
                                <div class="col-12" id="matric-number-container" style="display: none;">
                                    <div class="form-floating mb-3">
                                        <?= $form->field($model, 'matric_number', [
                                            'template' => "{input}\n{label}\n{error}",
                                            'options' => ['class' => 'form-floating'],
                                        ])->textInput([
                                            'class' => 'form-control',
                                            'placeholder' => 'Matric Number',
                                            'autofocus' => true,
                                        ])->label('Matric Number', ['class' => 'form-label']) ?>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="d-grid">
                                        <?= Html::submitButton('Submit', ['class' => 'btn btn-dark btn-lg', 'name' => 'login-button']) ?>
                                    </div>
                                </div>
                            </div>
                            <?php ActiveForm::end(); ?>
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-center mt-5">

                                        <?= \yii\helpers\Html::a('Log in', ['site/login'], [
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
<?php
$js = <<<JS
    // Function to show/hide the Matric Number field based on the selected type
    function toggleMatricNumberField() {
        var type = document.getElementById('type-select').value;
        var matricNumberContainer = document.getElementById('matric-number-container');
        
        if (type === 'outbound') {
            matricNumberContainer.style.display = 'block';
        } else {
            matricNumberContainer.style.display = 'none';
        }
    }
    
    // Trigger the toggle function when the page loads
    document.addEventListener('DOMContentLoaded', function() {
        toggleMatricNumberField(); // Ensure correct state on page load
    });
    
    // Trigger the toggle function whenever the Type dropdown value changes
    document.getElementById('type-select').addEventListener('change', toggleMatricNumberField);
JS;
$this->registerJs($js);
?>

