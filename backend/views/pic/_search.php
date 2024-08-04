<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\search\PicSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="pic-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'full_search', ['options' => ['mb-0']])->textInput([
        'class' => 'form-control', // Add class for styling
        'placeholder' => 'Search', // Placeholder text
        'onchange' => '$(this).closest("form").submit();', // Submit form on change
    ])->label(false) ?>

    <?php ActiveForm::end(); ?>

</div>
