<?php

use common\helpers\Variables;
use common\models\Kcdio;
use Itstructure\CKEditor\CKEditor;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/** @var common\models\Outbound $model */


$approveMap = [
    Variables::application_init             => Variables::redirected_to_hod,
    Variables::application_resubmitted      => Variables::redirected_to_hod,
    Variables::application_accepted_hod     => Variables::redirected_to_dean,
    Variables::application_accepted_dean    => Variables::redirected_to_student_UPLOAD_files,
    Variables::application_files_uploaded   => Variables::application_accepted
];

$rejectMap = [
    Variables::application_init             => Variables::application_rejected,
    Variables::application_rejected_hod     => Variables::application_rejected,
    Variables::application_rejected_dean    => Variables::application_rejected,
];

$notCompleteMap = [
    Variables::application_init             => Variables::application_not_complete,
    Variables::application_files_uploaded   => Variables::application_files_not_complete,
];

$reconsiderMap = [
    Variables::application_rejected_hod     => Variables::application_resubmitted_to_hod,
];

//options controller
$options = [];
if(!in_array($model->status, [Variables::application_rejected_hod, Variables::application_rejected_dean])){
    $options[$approveMap[$model->status]] = 'Approved';
}
if (!in_array($model->status, [Variables::application_accepted_dean, Variables::application_accepted_hod, Variables::application_files_uploaded])) {
    $options[$rejectMap[$model->status]] = 'Rejected';
}
if($model->status == Variables::application_rejected_hod){
    $options[$reconsiderMap[$model->status]] = 'Reconsider';
}
if(in_array($model->status, [Variables::application_init, Variables::application_files_uploaded])){
    $options[$notCompleteMap[$model->status]] = 'Not Complete';
}

//dynamic attribute changer

$attribute =  in_array($model->status, [Variables::application_init, Variables::application_resubmitted]) ? 'hod_id' : 'dean_id';

?>





<?php $form = ActiveForm::begin([
    'id' => 'create-form',
    'enableClientValidation' => true, // Enable client-side validation
]); ?>

    <?php $form->field($model, 'status')->radioList([], ['class' => 'gap-2 row'])->label(false);?>
<?= $form->field($model, 'status')->radioList(
    $options,
    [
        'item' => function($index, $label, $name, $checked, $value) {
            return '
            <label class="plan ' . strtolower($value) . '-plan" for="' . $value . '">
            
                <input type="radio" id="' . $value . '" name="' . $name . '" value="' . $value . '" ' . ($checked ? 'checked' : '') . ' />
                <div class="plan-content">
                    <div class="plan-details">
                        <span>' . $label . '</span>
                    </div>
                </div>
                <p class="invalid-feedback mb-0"></p>
            </label>
            ';
        },
        'class' => 'plans',
        'errorOptions' => ['class' => 'invalid-feedback'],
    ]
)->label(false); ?>

<?php if(in_array($model->status, [Variables::application_init, Variables::application_resubmitted, Variables::application_accepted_hod])):?>

   <div class="redirected d-none">
       <?= $form->field($model, 'pic_id')->dropDownList(ArrayHelper::map(Kcdio::find()->all(), 'id', 'kcdio'), [
           'prompt' => 'Select KCDIO',
           'onchange' => '
        $.get("' . Url::toRoute('outbound/get-pic') . '", { id: $(this).val() })
            .done(function(data) {
                var attribute = "' . $attribute . '";
                var selectElement = $("select#outbound-" + attribute);
                selectElement.html("");
                selectElement.append($("<option></option>").attr("value", "").text("Select PIC"));
                $.each(data, function(key, value) {
                    selectElement.append($("<option></option>").attr("value", key).text(value));
                });
            });
    '
       ])->label(false) ?>

       <?= $form->field($model, $attribute)->dropDownList([], ['prompt' => 'Select PIC'])->label(false)?>
   </div>

<?php endif;?>

    <div class="not-complete mb-4 d-none">
        <?= $form->field($model, 'reason')->widget(CKEditor::className(), [
            'preset' => 'basic',
            'clientOptions' => [
                'on' => [
                    'instanceReady' => new \yii\web\JsExpression('function(evt) {
                this.setData("");
            }')
                ]
            ]
        ])->label(false) ?>
    </div>

<?php ?>

<div class="text-end">
    <?= Html::submitButton('Submit', ['class' => 'btn-submit mb-4']) ?>
</div>


<?php ActiveForm::end(); ?>

<script>
    $(document).ready(function() {
        $("#2, #3, #13, #63").on("change", function () {
            if (this.checked) {
                $(".not-complete").removeClass('d-none');
                $(".redirected").addClass('d-none');
                clearInputs('.redirected');
                setRequiredInputs('.redirected', false);
            }
        });

        $("#1, #21, #41, #61").on("change", function () {
            if (this.checked) {
                $(".not-complete").addClass('d-none');
                $(".redirected").removeClass('d-none');
                clearInputs('.not-complete');
                setRequiredInputs('.redirected', true);
            }
        });

        function clearInputs(containerSelector) {
            const container = document.querySelector(containerSelector);
            if (container) {
                const inputsToClear = container.querySelectorAll('input, select, textarea');
                inputsToClear.forEach(input => {
                    if (input.type === 'checkbox' || input.type === 'radio') {
                        input.checked = false;
                    } else {
                        input.value = '';
                    }
                });
            }
        }

        function setRequiredInputs(containerSelector, required) {
            const container = document.querySelector(containerSelector);
            if (container) {
                const inputsToRequired = container.querySelectorAll('input, select, textarea');
                inputsToRequired.forEach(input => {
                    if (required) {
                        input.setAttribute('required', 'required');
                    } else {
                        input.removeAttribute('required');
                    }
                });
            }
        }
    });


</script>
