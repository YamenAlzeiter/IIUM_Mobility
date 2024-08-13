
<?php use common\helpers\Variables;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

/** @var common\models\Outbound $model */


$templateFileInput = '<div class="col-md align-items-center"><div class="col-md-md-2 col-md-form-label">{label}</div>
                        <div class="col-md-md">{input}{error}</div></div>';


$form = ActiveForm::begin([
    'id' => 'upload-form',
    'options' => ['enctype' => 'multipart/form-data'],
    'enableClientValidation' => false,
    'enableAjaxValidation' => true,
]);

?>
            <?php if (in_array($model->status, [Variables::redirected_to_student_UPLOAD_files, Variables::application_files_not_complete])):?>
            <?= $form->field($model, 'f_proof_sponsorship_file', ['template' => $templateFileInput])->fileInput()?>
            <?= $form->field($model, 'f_proof_sponsorship_cover_file', ['template' => $templateFileInput])->fileInput()?>
            <?= $form->field($model, 'f_letter_indemnity_file', ['template' => $templateFileInput])->fileInput()?>
            <?= $form->field($model, 'f_flight_ticket_file', ['template' => $templateFileInput])->fileInput()?>
            <?= $form->field($model, 'f_travel_insurance_file')?>
            <?php elseif ($model->status == Variables::application_reminder_sent):?>
            <?= $form->field($model, 'f_certificate_attendance_file', ['template' => $templateFileInput])->fileInput()?>
            <?= $form->field($model, 'f_academic_transcript_host_university_file', ['template' => $templateFileInput])->fileInput()?>
            <?= $form->field($model, 'f_mobility_report_file', ['template' => $templateFileInput])->fileInput()?>
            <?= $form->field($model, 'f_files_file[]')->fileInput(['multiple' => true]) ?>
            <?php endif;?>

<div class = "form-group mt-2">
    <div class = "form-group">

        <?= Html::submitButton('Submit', ['class' => 'btn-submit', 'name' => 'uploader', 'value' => 'uploader']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>