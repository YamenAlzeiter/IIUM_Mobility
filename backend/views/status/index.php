<?php

use common\helpers\builders;
use common\models\Status;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Status';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-md my-3 p-4 rounded-3 bg-white shadow">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-borderless table-striped table-header-flex text-nowrap rounded-3 overflow-hidden'],
        'columns' => [
            'tag',
            'description',
            [
                'attribute' => 'Type',
                'format' => 'raw',
                'value' => function ($model) {
                    // You can replace this logic with your actual conditions and rendering logic
                    if ($model->type == 'I') {
                        return 'Inbound';
                    } elseif ($model->type == 'O') {
                        return 'Outbound';
                    } else {
                        return 'Inbound/Outbound';
                    }
                },
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{update}',
                'contentOptions' => ['class' => 'text-end'],
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        $build = new builders();
                        return $build->actionBuilderModal($model, 'update');
                    },
                ],
            ],
            // Single column with conditional rendering

        ],
        'pager' => [
            'class' => LinkPager::className(),
            'listOptions' => ['class' => 'pagination justify-content-center gap-2 borderless'],
            'activePageCssClass' => 'link-white active',
        ],
        'layout' => "{items}\n{summary}\n{pager}",
    ]);
    ?>
</div>