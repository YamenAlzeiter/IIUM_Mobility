<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Inbound $model */
/** @var common\models\InboundHostUniversityCourses $modelsCourses*/

$this->title = 'Update Inbound: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Inbounds', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsCourses' => $modelsCourses,
    ]) ?>


