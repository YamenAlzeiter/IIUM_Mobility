<?php

use common\helpers\Variables;
use Itstructure\CKEditor\CKEditor;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Inbound $model */
/** @var yii\widgets\ActiveForm $form */



$approveMap = [
    Variables::application_redirected_kcdio_inbound      => Variables::application_accepted_kcdio_inbound,
    Variables::application_resubmitted_to_kcdio_inbound  => Variables::application_accepted_kcdio_inbound,
    Variables::application_redirected_amad_inbound       => Variables::application_got_offer_letter_inbound,

];

$rejectMap = [
    Variables::application_redirected_kcdio_inbound      => Variables::application_rejected_kcdio_inbound,
    Variables::application_resubmitted_to_kcdio_inbound  => Variables::application_rejected_kcdio_inbound,
];
$options = [];

if (isset($approveMap[$model->status])) {
    $options[$approveMap[$model->status]] = 'Approved';
}

if (isset($rejectMap[$model->status])) {
    $options[$rejectMap[$model->status]] = 'Rejected';
}

$agreementKCDIO = 'I hereby declare that the research area of specialization stated above is: ';
$offerLetter = 'Please Upload the Applicant: ' .$model->name. ' Offer Letter'

?>


<?php $form = ActiveForm::begin([
    'id' => 'create-form',
    'options' => ['enctype' => 'multipart/form-data']
]); ?>

        <p class="mb-0 fw-bold fs-5 "><?= $model->status == Variables::application_redirected_kcdio_inbound ? $agreementKCDIO : $offerLetter?></p>

        <?php if(in_array($model->status, [Variables::application_redirected_kcdio_inbound, Variables::application_resubmitted_to_kcdio_inbound])):?>
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
        <?php elseif ($model->status == Variables::application_redirected_amad_inbound): ?>
            <?= $form->field($model, 'status')->hiddenInput(['value' => Variables::application_got_offer_letter_inbound])->label(false); ?>

            <?= $form->field($model, 'f_offer_letter_file')->fileInput()->label('Offer Letter File'); ?>
        <?php endif; ?>


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
        $("#16").on("change", function () {
            if (this.checked) {
                $(".not-complete").removeClass('d-none');
                $(".redirected").addClass('d-none');
                clearInputs('.redirected');
                setRequiredInputs('.redirected', false);
            }
        });

        $("#15").on("change", function () {
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
