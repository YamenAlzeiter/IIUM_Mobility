<?php

use common\helpers\builders;
use common\models\EmailTemplates;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Email Templates';
$this->params['breadcrumbs'][] = $this->title;
?>

<!--    <p>-->
<!--        --><?php //= Html::a('Create Email Templates', ['create'], ['class' => 'btn btn-success']) ?>
<!--    </p>-->


<div class="row">
    <?php foreach ($dataProvider->models as $model): ?>
        <div class="col-md-3 box-col">
            <a href="javascript:void(0);" value="<?= Url::to(['update', 'id' => $model->id]) ?>"
               onclick="$('#modal').modal('show').find('#modalContent').load($(this).attr('value'), function() {
               $('#modalContent').append('');

                                                                       });">
            <div class="box-container">
                <h3 class="card-title"><?=($model->subject) ?></h3>
            </div>
            </a>
        </div>
    <?php endforeach; ?>

</div>





