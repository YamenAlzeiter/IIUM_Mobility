<?php

namespace common\helpers;

use Yii;
use yii\bootstrap5\Html;
use yii\helpers\Url;

class builders
{
    public function tableProbChanger($status, $viewer)
    {
        switch ($viewer) {
            case 'inbound'         :
                return in_array($status, [10, 15, 16, 35, 55, 75]);
            case 'outbound'     :
                return in_array($status, [10, 11, 12, 31, 32, 51, 71]);
            default: return null;
        }
    }

    public function actionBuilder($model, $type, $modal_id = "#modal")
    {
        $icon = [
            'view' => 'text-primary ti-eye              ',
            'delete' => 'text-danger ti-trash          ',
            'update' => 'text-primary ti-edit-circle   ',
//            'action' => 'text-primary ti-user-circle   ',
//            'log' => 'text-warning ti-file-description ',
        ];

        $title = "<p class='title_tool_tip'>$type</p>";
        return Html::a(
            '<i class="ti fs-7 ' . $icon[$type] . '" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-html="true" title="' . $title . '"></i>',
            Url::to([$type, 'id' => $model->id]),
            [
                'class' => 'btn-action text-decoration-none',
            ]
        );
    }
    public function actionBuilderModal($model, $type, $modal_id = "#modal")
    {
        $icon = [
            'action' => 'text-success ti-checks',
            'log' => 'text-warning ti-file-description',
            'update' => 'text-dark ti-pencil',
            'delete' => 'text-danger ti-trash',
            'view' => 'text-primary ti-eye',
        ];

        $title = "<p class='title_tool_tip'>$type</p>";

        if ($type === 'delete') {
            return Html::a(
                '<i class="ti fs-7 ' . $icon[$type] . '" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-html="true" title="' . $title . '"></i>',
                'javascript:void(0);',
                [
                    'class' => 'btn-action text-decoration-none',
                    'onclick' => "
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to delete this person in charge?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '" . Url::to(['delete', 'id' => $model->id]) . "',
                        type: 'POST',
                        data: {
                            _csrf: '" . Yii::$app->request->csrfToken . "' // Ensure CSRF token is included
                        },
                        success: function () {
                            Swal.fire(
                                'Deleted!',
                                'The person in charge has been deleted.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        }
                    });
                }
            });
        ",
                ]
            );}

        // For other types
        return Html::a(
            '<i class="ti fs-7 ' . $icon[$type] . '" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-html="true" title="' . $title . '"></i>',
            'javascript:void(0);',
            [
                'class' => 'btn-action text-decoration-none',
                'value' => Url::to([$type, 'id' => $model->id]),
                'onclick' => "$('#modal').modal('show').find('#modalContent').load($(this).attr('value'), function() {
                $('#modalContent').append('');
                $('#modal').find('.modal-title').html('<h1 class=\"mb-0\">". addslashes($title) ."</h1>');
            });",
            ]
        );
    }



}

?>