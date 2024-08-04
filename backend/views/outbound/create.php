<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Outbound $model */

$this->title = 'Create outbound';
$this->params['breadcrumbs'][] = ['label' => 'Outbounds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="outbound-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
