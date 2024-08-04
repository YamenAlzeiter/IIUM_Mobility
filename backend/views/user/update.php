<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$this->title = 'Update';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($user, 'username')->textInput(['readonly' => true]) ?>
        <?= $form->field($user, 'email')->textInput(['readonly' => true]) ?>

        <?= $form->field($user, 'type')->dropDownList([
            'staff' => 'Staff',
            'admin' => 'Admin',
        ], ['prompt' => 'Select Role']) ?>

        <div class="form-group text-end">
            <?= Html::submitButton('Save', ['class' => 'btn-submit']) ?>
        </div>

        <?php ActiveForm::end(); ?>

