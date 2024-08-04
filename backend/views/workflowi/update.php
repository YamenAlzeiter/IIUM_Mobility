<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Outbound $model */

$this->title = 'Approval: ' . $model->name;

?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

