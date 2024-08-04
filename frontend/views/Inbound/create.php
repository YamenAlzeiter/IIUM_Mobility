<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Inbound $model */
/** @var common\models\InboundHostUniversityCourses $modelsCourses*/

$this->title = 'Create Inbound';
$this->params['breadcrumbs'][] = ['label' => 'Inbounds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>




    <?= $this->render('_form', [
        'model' => $model,
        'modelsCourses' => $modelsCourses,
    ]) ?>


