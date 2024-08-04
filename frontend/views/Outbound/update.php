<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Outbound $model */
/** @var common\models\LocalUniversityCources $modelsLocalCourses*/
/** @var common\models\HostUniversityCources $modelsHostCourses*/

$this->title = 'Update outbound: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Outbounds', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>


    <?= $this->render('_form', [
        'model' => $model,
    'modelsLocalCourses' => $modelsLocalCourses,
    'modelsHostCourses' => $modelsHostCourses,
    ]) ?>

