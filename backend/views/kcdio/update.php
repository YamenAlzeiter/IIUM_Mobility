<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Kcdio $model */

$this->title = 'Update Kcdio: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Kcdios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>


