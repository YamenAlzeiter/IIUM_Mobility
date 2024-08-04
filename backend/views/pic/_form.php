<?php

use common\models\Kcdio;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Pic $model */
/** @var yii\widgets\ActiveForm $form */
?>



    <?php
    $form = ActiveForm::begin([
        'id' => 'your-form-id', // Give your form a unique ID
        'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
        'validateOnSubmit' => true,

    ]);
    ?>

    <div class="row">
        <div class="col-md-12 col-lg-12 mb-2"><?= $form->field($model, 'kcdio_id')->dropDownList(ArrayHelper::map(Kcdio::find()->all(), 'id', 'kcdio'), ['prompt' => 'Select KCDIO']) ?></div>
        <div class = "col-md-12 col-lg-6 mb-2"><?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?></div>
        <div class = "col-md-12 col-lg-6 mb-2"><?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?></div>
        <div class = "col-md-12 col-lg-6 mb-2"><?= $form->field($model, 'name_cc_x')->textInput(['maxlength' => true]) ?></div>
        <div class = "col-md-12 col-lg-6 mb-2"><?= $form->field($model, 'email_cc_x')->textInput(['maxlength' => true]) ?></div>
        <div class = "col-md-12 col-lg-6 mb-2"><?= $form->field($model, 'name_cc_xx')->textInput(['maxlength' => true]) ?></div>
        <div class = "col-md-12 col-lg-6 mb-2"><?= $form->field($model, 'email_cc_xx')->textInput(['maxlength' => true]) ?></div>
    </div>

    <div class="form-group text-end">
        <?= Html::submitButton('Save', ['class' => 'btn-submit']) ?>
    </div>

    <?php ActiveForm::end(); ?>

