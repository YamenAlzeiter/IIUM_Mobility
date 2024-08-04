
<?php use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

/** @var common\models\Inbound $model */


$templateFileInput = '<div class="col-md align-items-center"><div class="col-md-md-2 col-md-form-label">{label}</div>
                        <div class="col-md-md">{input}{error}</div></div>';


$form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data',  'id' => 'update-form'],
]); ?>

            <?= $form->field($model, 'f_proof_of_payment_file', ['template' => $templateFileInput])->fileInput()?>

<div class = "form-group mt-2">
    <div class = "form-group">

        <?= Html::submitButton('Submit', ['class' => 'btn-submit', 'name' => 'uploader', 'value' => 'uploader']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>