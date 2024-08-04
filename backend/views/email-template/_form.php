<?php

use Itstructure\CKEditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\EmailTemplates $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="email-templates-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

    <div class="mb-2">
<!--        --><?php //= $form->field($model, 'body')->widget(
//            CKEditor::className(),
//            [
//                'preset' => 'basic',
//                'options' => ['id' => 'email_template'],
//                'clientOptions' => [
//                    'extraPlugins' => 'insertId', // Register the custom plugin
//                    'toolbar' => [
//                        ['name' => 'clipboard', 'items' => ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']],
//                        ['name' => 'insert', 'items' => ['InsertUser', 'InsertReason', 'InsertLink']],
//                    ],
//                    'filebrowserWindowHeight' => '2000',
//                ],
//            ]
//        )->label(false) ?>
        <?php
        echo $form->field($model, 'body')
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

</div>
