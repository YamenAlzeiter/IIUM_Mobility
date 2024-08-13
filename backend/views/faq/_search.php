<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\search\FaqSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<?php $form = ActiveForm::begin([
    'action' => ['index'], 'method' => 'get', 'options' => ['data-pjax' => 1, ['class' => 'row gap-2']]
]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'search', ['options' => ['mb-0']])->textInput([
                'class' => 'form-control', // Add class for styling
                'placeholder' => 'Search', // Placeholder text
                'onchange' => '$(this).closest("form").submit();', // Submit form on change
            ])->label(false) ?>
        </div>
    </div>




    <?php ActiveForm::end(); ?>


