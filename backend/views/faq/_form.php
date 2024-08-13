<?php

use Itstructure\CKEditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Faq $model */
/** @var yii\widgets\ActiveForm $form */
?>



<?php
$form = ActiveForm::begin([
    'id' => 'your-form-id', // Give your form a unique ID
    'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
    'validateOnSubmit' => true,

]);
?>


    <div class="mb-2">
        <?= $form->field($model, 'type')->radioList(
            ['I' => 'Inbound', 'O' => 'Outbound'],
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
        )->label(false);
        ?>
        <?= $form->field($model, 'question')->textInput(['rows' => 6]) ?>
        <?php
        echo $form->field($model, 'answer')
            ->widget(
                CKEditor::className(),
                [
                    'preset' => 'custom',
                    'options' => ['id' => 'email_template'],
                    'clientOptions' => [
                        'extraPlugins' => 'insertId',

                        'toolbarGroups' => [
                            [
                                'name' => 'undo'
                            ],
                            [
                                'name' => 'basicstyles',
                                'groups' => ['basicstyles', 'cleanup']
                            ],
                            [
                                'name' => 'colors'
                            ],
                            [
                                'name' => 'links',
                                'groups' => ['links', 'insert']
                            ],
                            [
                                'name' => 'others',
                                'groups' => ['others', 'about']
                            ],
                        ],




                    ]
                ]
            );
        ?>

    </div>


    <div class="form-group text-end">
        <?= Html::submitButton('Save', ['class' => 'btn-submit']) ?>
    </div>

    <?php ActiveForm::end(); ?>
