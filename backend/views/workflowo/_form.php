<?php

use common\helpers\Variables;
use Itstructure\CKEditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Outbound $model */
/** @var yii\widgets\ActiveForm $form */



$approveMap = [
    Variables::redirected_to_hod                     => Variables::application_accepted_hod,
    Variables::application_resubmitted_to_hod        => Variables::application_accepted_hod,
    Variables::redirected_to_dean                    => Variables::application_accepted_dean,

];

$rejectMap = [
    Variables::redirected_to_hod                     => Variables::application_rejected_hod,
    Variables::application_resubmitted_to_hod        => Variables::application_rejected_hod,
    Variables::redirected_to_dean                    => Variables::application_rejected_dean,
];
$options = [$approveMap[$model->status] => 'Approved'];
$options[$rejectMap[$model->status]] = 'Rejected';

$agreementHod = 'I hereby declare that the research area of specialization stated above is: ';
$agreementDean = 'I hereby confirm that this student has gone through the rightful university selection procedures and recommend that the student is qualified to participate in the student exchange program stated in the application.'

?>


    <?php $form = ActiveForm::begin(); ?>

        <p class="mb-0 fw-bold fs-5 "><?= in_array($model->status, [Variables::redirected_to_hod, Variables::application_resubmitted_to_hod]) ? $agreementHod : $agreementDean?></p>

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
<div class="text-end">
    <?= Html::submitButton('Submit', ['class' => 'btn-submit mb-4']) ?>
</div>

    <?php ActiveForm::end(); ?>


<script>
    $(document).ready(function() {
        $("#12, #32").on("change", function () {
            if (this.checked) {
                $(".not-complete").removeClass('d-none');
                $(".redirected").addClass('d-none');
                clearInputs('.redirected');
                setRequiredInputs('.redirected', false);
            }
        });

        $("#11, #31").on("change", function () {
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
    });


</script>
