<?php

use common\helpers\builders;
use common\models\Faq;
use yii\grid\CheckboxColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\web\JsExpression;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var common\models\search\FaqSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'FAQ';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(['id' => 'faq-grid-pjax']); ?>
<div class="container-md my-3 p-4 rounded-3 bg-white shadow">
    <div class="row justify-content-between">
        <div class="col-md-8">
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
        <div class="col-md-4 align-self-end mb-3">
            <div class="d-flex justify-content-end gap-2">
                <?= Html::a(
                    '<i class="ti fs-7 ti-plus"></i> Add New FAQ',
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
                <div class="bulk-delete-container d-none d-inline-flex align-items-center gap-2">'
                        <?= Html::button('<i class="ti ti-trash fs-7"></i>', ['id' => 'bulk-delete', 'class' => 'btn btn-danger', 'data-pjax' => '0']) ?>
                </div>
            </div>
        </div>
    </div>

    <hr>
    <div class="table-responsive">

        <?= GridView::widget([
            'id' => 'inbound-grid',
            'dataProvider' => $dataProvider,
            'tableOptions' => ['class' => 'table table-borderless table-striped table-header-flex text-nowrap rounded-3 overflow-hidden '],
            'columns' => array_merge(
                Yii::$app->user->can('admin') ? [['class' => CheckboxColumn::className()]] : [],
                [
                    'question',
                    'type',
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

    <?php
    $url = Url::to(['bulk-delete']);
    $js = <<<JS
function initializeBulkDelete() {
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
    $(document).on('change', '#inbound-grid input[name="selection[]"]', function() {
        toggleBulkDeleteButton();
    });

    // Handle PJAX complete event
    $(document).on('pjax:success', function() {
        toggleBulkDeleteButton();
    });

    // SweetAlert for bulk delete
    $('#bulk-delete').on('click', function(e) {
        e.preventDefault();
        var keys = $('#inbound-grid').yiiGridView('getSelectedRows');
        if (keys.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No items selected',
                text: 'Please select at least one item to delete.'
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
                    data: { ids: keys },
                    success: function(data) {
                        if (data.success) {
                            Swal.fire(
                                'Deleted!',
                                'Your selected items have been deleted.',
                                'success'
                            ).then(() => {
                                $.pjax.reload({container: '#faq-grid-pjax'}); // Reload PJAX content
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
}

// Initialize the script on page load
$(document).ready(function() {
    initializeBulkDelete();
});

// Re-initialize the script on PJAX success
$(document).on('pjax:success', function() {
    initializeBulkDelete();
});
JS;

    $this->registerJs(new JsExpression($js));
    ?>
