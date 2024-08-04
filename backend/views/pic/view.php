<?php

use common\helpers\viewRenderer;
use common\models\Kcdio;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Pic $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Pics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$view = new ViewRenderer();
?>

        <?= $view->renderer(Kcdio::findOne($model->kcdio_id)->tag ?? false, 'KCDIO') ?>
        <?= $view->renderer($model->name, 'Name') ?>
        <?= $view->renderer($model->email, 'Email', true) ?>
        <?php if ($model->name_cc_x && $model->email_cc_x !== null): ?>
            <h4>Additional Person in Charge</h4>
            <?= $view->renderer($model->name_cc_x, 'Name') ?>
            <?= $view->renderer($model->email_cc_x, 'Email', true) ?>
        <?php endif;?>
        <?php if ($model->name_cc_x && $model->email_cc_x !== null): ?>
            <h4>Additional Person in Charge</h4>
            <?= $view->renderer($model->name_cc_xx, 'Name') ?>
            <?= $view->renderer($model->email_cc_xx, 'Email', true) ?>
        <?php endif;?>
