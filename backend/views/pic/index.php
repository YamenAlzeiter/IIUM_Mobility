<?php

use common\helpers\builders;
use common\models\Kcdio;
use common\models\Pic;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var common\models\search\PicSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Person in Charge';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pic-index">

    <?php Pjax::begin(); ?>
    <div class="container-md my-3 p-4 rounded-3 bg-white shadow">
        <div class="row justify-content-between">
            <div class="col-md-8">
                <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
            </div>
            <div class="col-md-4 text-end align-self-end mb-4">
                <?= Html::a(
                    '<i class="ti fs-7 ti-plus"></i> Add Person in Charge',
                    'javascript:void(0);',
                    [
                        'class' => 'btn-submit fs-4 text-decoration-none',
                        'value' => Url::to('create'),
                        'onclick' => "$('#modal').modal('show').find('#modalContent').load($(this).attr('value'), function() {
            $('#modalContent').append('');
            $('#modal').find('.modal-title').html('<h1 class=\"mb-0\">Create</h1>');
        });",
                    ]
                ); ?>
            </div>
        </div>
        <hr>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table  table-borderless table-striped table-header-flex text-nowrap rounded-3 overflow-hidden'],
        'columns' => [
            'name',
            'email:email',
            [
                'attribute' => 'kcdio_id',
                'label' => 'K / C / D / I / O',
                'value' => function ($model) {
                    $kcdio = Kcdio::find()->where(['id' => $model->kcdio_id])->one();
                    return $kcdio ? $kcdio->tag : null;
                },
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {update} {delete}',
                'contentOptions' => ['class' => 'text-end'],
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        $build = new builders();
                        return $build->actionBuilderModal($model, 'view');
                    },
                    'update' => function ($url, $model, $key) {
                        $build = new builders();
                            return $build->actionBuilderModal($model, 'update');
                    },
                    'delete' => function ($url, $model, $key) {
                        $build = new builders();
                        return $build->actionBuilderModal($model, 'delete');
                    },
                ],
            ],
        ],
        'pager' => [
            'class' => yii\bootstrap5\LinkPager::className(),
            'listOptions' => ['class' => 'pagination justify-content-center gap-2 borderless'],
            'activePageCssClass' => ['class' => 'link-white active'],
        ],
        'layout' => "{items}\n{summary}\n{pager}",
    ]);
    ?>

    <?php Pjax::end(); ?>
    </div>

</div>
<?php Modal::begin([
    'title' => '',
    'id' => 'modal-activity',
    'size' => 'modal-lg',
    'bodyOptions' => ['class' => 'modal-inner-padding-body mt-0'],
    'headerOptions' => ['class' => 'modal-inner-padding justify-content-between'],
    'centerVertical' => true,
    'scrollable' => true,
]);

echo "<div id='modalContent'></div>";

Modal::end();
?>