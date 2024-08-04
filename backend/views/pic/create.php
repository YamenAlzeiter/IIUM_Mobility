<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Pic $model */

$this->title = 'Create Pic';
$this->params['breadcrumbs'][] = ['label' => 'Pics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

