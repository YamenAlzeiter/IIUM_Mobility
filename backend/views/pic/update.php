<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Pic $model */

$this->title = 'Update Pic: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Pics', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
