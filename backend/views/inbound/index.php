<?php

use common\helpers\builders;
use common\models\Inbound;
use yii\bootstrap5\Modal;
use yii\grid\CheckboxColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\web\JsExpression;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var common\models\search\InboundSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Inbounds';
$this->params['breadcrumbs'][] = $this->title;

$yearsStart = Inbound::find()
    ->select(['EXTRACT(YEAR FROM propose_duration_start) AS year'])
    ->distinct()
    ->column();

$yearsEnd = Inbound::find()
    ->select(['EXTRACT(YEAR FROM propose_duration_end) AS year'])
    ->distinct()
    ->column();

// Combine and filter out NULL values
$years = array_filter(array_unique(array_merge($yearsStart, $yearsEnd)));
?>
<?php Pjax::begin(); ?>
    <div class="container-md my-3 p-4 rounded-3 bg-white shadow">

        <div class="row justify-content-between">
            <div class="col-md-8">
                <?php echo $this->render('_search', ['model' => $searchModel]); ?>
            </div>
            <div class="col-md-4 align-self-end mb-3">
                <div class="d-flex justify-content-end gap-2">
                    <?php
                    if (Yii::$app->user->can('admin')) {
                        echo '<div class="bulk-delete-container d-inline-flex align-items-center gap-2">'
                            . Html::button('<i class="ti ti-trash fs-7"></i>', ['id' => 'bulk-delete', 'class' => 'btn btn-danger']) .
                            '</div>';
                    }
                    ?>
                    <button class="btn-submit dropdown-toggle fs-4" type="button" id="dropdownMenuButton1"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ti ti-file-spreadsheet"></i> Download Excel
                    </button>
                    <ul class="dropdown-menu dropdown-menu-width" aria-labelledby="dropdownMenuButton1">
                        <?php foreach ($years as $option): ?>
                            <li>
                                <?= Html::a(
                                    'Year ' . $option,
                                    Url::to(['export-excel', 'year' => $option]),
                                    ['class' => 'dropdown-item', 'data-pjax' => '0']
                                ) ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

    <hr>
    <div class="table-responsive">


        <?= GridView::widget([
            'id' => 'inbound-grid',
            'dataProvider' => $dataProvider,
            'tableOptions' => ['class' => 'table table-borderless table-striped table-header-flex text-nowrap rounded-3 overflow-hidden'],
            'rowOptions' => function ($model) {
                $build = new builders();
                return $build->tableProbChanger($model->status, 'outbound') ? ['class' => 'need-action fw-bolder'] : [];
            },
            'columns' => array_merge(
                Yii::$app->user->can('admin') ? [['class' => CheckboxColumn::className()]] : [],
                [
                    'id',
                    'status',
                    'name',
                    'citizenship',
                    [
                        'class' => ActionColumn::className(),
                        'template' => '{view} {action} {log}',
                        'contentOptions' => ['class' => 'text-end'],
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                $build = new builders();
                                return $build->actionBuilder($model, 'view');
                            },
                            'action' => function ($url, $model, $key) {
                                $build = new builders();
                                if ($build->tableProbChanger($model->status, 'inbound')) {
                                    return $build->actionBuilderModal($model, 'action');
                                }
                                return ''; // Return an empty string if the condition is not met
                            },
                            'log' => function ($url, $model, $key) {
                                $build = new builders();
                                return $build->actionBuilderModal($model, 'log');
                            },
                        ],
                    ],
                ]
            ),
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

<?php modal::begin(['title' => '', 'id' => 'modal-activity', 'size' => 'modal-lg', 'bodyOptions' => ['class' => 'modal-inner-padding-body mt-0'], 'headerOptions' => ['class' => 'modal-inner-padding justify-content-between'], 'centerVertical' => true, 'scrollable' => true,]);

echo "<div id='modalContent'></div>";

modal::end();
?>

<?php
$url = Url::to(['bulk-delete']);

$js = <<<JS
$(document).ready(function() {
    function toggleBulkDeleteButton() {
        var keys = $('#inbound-grid').yiiGridView('getSelectedRows');
        if (keys.length > 0) {
            $('.bulk-delete-container').removeClass('d-none');
        } else {
            $('.bulk-delete-container').addClass('d-none');
        }
    }

    // Initial check to hide/show button on page load
    toggleBulkDeleteButton();

    // Trigger the toggle function on selection change
    $('#inbound-grid').on('change', 'input[name="selection[]"]', function() {
        toggleBulkDeleteButton();
    });

    //sweet alert ...
    $('#bulk-delete').on('click', function(e) {
        e.preventDefault();
        var keys = $('#inbound-grid').yiiGridView('getSelectedRows');
        if (keys.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Agreemtns selected',
                text: 'Please select at least one Agreemtn to delete.'
            });
            return;
        }
        Swal.fire({
            title: 'Are you sure?',
              text: "All data and associated files will be permanently deleted from the server. This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '{$url}',
                    data: {ids: keys},
                    success: function(data) {
                        if (data.success) {
                            Swal.fire(
                                'Deleted!',
                                'Your selected Agreements have been deleted.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                data.message,
                                'error'
                            );
                        }
                    }
                });
            }
        });
    });
});
JS;

$this->registerJs(new JsExpression($js));
?>
