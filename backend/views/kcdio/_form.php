<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Kcdio $model */
/** @var yii\widgets\ActiveForm $form */
?>


    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kcdio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tag')->textInput(['maxlength' => true]) ?>

    <div class="form-group text-end">
        <?= Html::submitButton('Save', ['class' => 'btn-submit']) ?>
    </div>

    <?php ActiveForm::end(); ?>

