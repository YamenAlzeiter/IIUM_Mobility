<?php

use common\models\User;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User';
$this->params['breadcrumbs'][] = $this->title;
?>



<div class="container-md my-3 p-4 rounded-3 bg-white shadow">
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'tableOptions' => ['class' => 'table  table-borderless table-striped table-header-flex text-nowrap rounded-3 overflow-hidden'],
    'columns' => [

        'username',
        'email',
        'created_at:datetime',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{approve} {reject} {update}',
            'buttons' => [
                'approve' => function ($url, $model, $key) {
                    if ($model->status == User::STATUS_INACTIVE) {
                        return Html::a('<i class="ti ti-check fs-7 text-success fw-bolder"></i>', '#', [
                            'class' => 'btn-action approve-btn',
                            'data-id' => $model->id,
                            'title' => 'Approve',
                        ]);
                    }
                    return '';
                },
                'reject' => function ($url, $model, $key) {
                    if ($model->status == User::STATUS_INACTIVE) {
                        return Html::a('<i class="ti ti-x fs-7 text-danger fw-bolder"></i>', '#', [
                            'class' => 'btn-action reject-btn',
                            'data-id' => $model->id,
                            'title' => 'Reject',
                        ]);
                    }
                    return '';
                },
                'update' => function ($url, $model, $key) {
                    if ($model->status == User::STATUS_ACTIVE && $model->type !== 'admin') {
                        return Html::a(
                            '<i class="ti fs-7 text-primary ti-pencil" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-html="true" title="Update"></i>',
                            'javascript:void(0);',
                            [
                                'class' => 'btn-action',
                                'value' => Url::to(['update', 'id' => $model->id]),
                                'onclick' => "$('#modal').modal('show').find('#modalContent').load($(this).attr('value'), function() {
                                    $('#modalContent').append('');
                                    $('#modal').find('.modal-title').html('<h1 class=\"mb-0\">Update User</h1>');
                                });",
                            ]
                        );
                    }
                    return '';
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
]); ?>

</div>

<?php
$this->registerJsFile('https://cdn.jsdelivr.net/npm/sweetalert2@10', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs(<<<JS
$('.approve-btn').on('click', function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    Swal.fire({
        title: 'Are you sure?',
        text: 'You are about to approve this user.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, approve it!',
    }).then((result) => {
        if (result.isConfirmed) {
            $.post({
                url: 'approve',
                data: {id: id},
                success: function(response) {
                    Swal.fire('Approved!', 'User has been approved.', 'success')
                    .then(() => {
                        location.reload();
                    });
                }
            });
        }
    });
});

$('.reject-btn').on('click', function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    Swal.fire({
        title: 'Are you sure?',
        text: 'You are about to reject this user.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, reject it!',
    }).then((result) => {
        if (result.isConfirmed) {
            $.post({
                url: 'reject',
                data: {id: id},
                success: function(response) {
                    Swal.fire('Rejected!', 'User has been rejected.', 'success')
                    .then(() => {
                        location.reload();
                    });
                }
            });
        }
    });
});
JS
);
?>
