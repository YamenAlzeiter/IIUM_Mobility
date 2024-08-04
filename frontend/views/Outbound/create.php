<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Outbound $model */
/** @var common\models\LocalUniversityCources $modelsLocalCourses*/
/** @var common\models\HostUniversityCources $modelsHostCourses*/


$this->title = 'Create outbound';
$this->params['breadcrumbs'][] = ['label' => 'Outbounds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsLocalCourses' => $modelsLocalCourses,
        'modelsHostCourses' => $modelsHostCourses,
    ]) ?>


