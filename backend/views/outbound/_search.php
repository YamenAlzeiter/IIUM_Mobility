<?php

use common\models\Country;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\search\OutboundSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="outbound-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>


    <?php
    echo $form->field($model, 'applications')->radioList([
        'all' => 'All',
        'new_applications' => 'New Applications',
        'active_applications' => 'Active Applications',
        'expired_applications' => 'Expired Applications'
    ], [
        'class' => 'row',
        'item' => function ($index, $label, $name, $checked, $value) {
            $checkedAttribute = $checked ? 'checked' : ($index === 0 ? 'checked' : ''); // Check the first radio button by default
            $radio = '<input type="radio" class="btn-check" name="'.$name.'" id="'.$name.$index.'" value="'.$value.'" autocomplete="off" '.$checkedAttribute.' onchange="$(this).closest(\'form\').submit();">';
            $label = '<label class="btn-bb btn-dark rounded-3 fs-5 fw-bold font-medium me-2 mb-2 text-nowrap" for="'.$name.$index.'">'.$label.'</label>';
            return '<div class="col-auto">'.$radio.$label.'</div>'; // Use col-auto to fit the size of the content
        }
    ])->label(false);
    ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'full_info', ['options' => ['mb-0']])->textInput([
                'class' => 'form-control', // Add class for styling
                'placeholder' => 'Search', // Placeholder text
                'onchange' => '$(this).closest("form").submit();', // Submit form on change
            ])->label(false) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'citizenship',
                ['options' => ['mb-0']])->dropDownList(ArrayHelper::map(Country::find()->all(), 'nationality', 'nationality'), [
                'class' => 'form-select', 'prompt' => 'Citizenship', // Placeholder text
                'onchange' => '$(this).closest("form").submit();', // Submit form on change
            ])->label(false) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'country',
                ['options' => ['mb-0']])->dropDownList(ArrayHelper::map(Country::find()->all(), 'id', 'name'), [
                'class' => 'form-select', 'prompt' => 'Country', // Placeholder text
                'onchange' => '$(this).closest("form").submit();', // Submit form on change
            ])->label(false) ?>
        </div>
        <div class="col-md-2">
            <?php if (!empty($years) && !in_array(null, $years, true)): ?>
                <?= $form->field($model, 'year', ['options' => ['mb-0']])->dropDownList(array_combine($years, $years), [
                    'class' => 'form-select',
                    'prompt' => 'Year',
                    'onchange' => '$(this).closest("form").submit();',
                ])->label(false) ?>
            <?php endif; ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
