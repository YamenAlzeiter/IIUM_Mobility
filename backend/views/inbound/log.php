<?php
use common\helpers\builders;
use common\helpers\StatusPillMaker;
use yii\grid\GridView;
use yii\web\JqueryAsset;
use yii\widgets\Pjax;?>

    <div class="table-responsive">
        <?php Pjax::begin(['options' => ['id' => 'log']]); ?>
        <?= GridView::widget([
            'id' => 'custom-gridview-id',
            'options' => ['id' => 'log'],
            'dataProvider' => $logsDataProvider,
            'tableOptions' => [
                'class' => 'table table-borderless table-striped table-header-flex text-nowrap rounded-3 overflow-hidden align-middle'
            ],
            // Show the current page and total pages
            'columns' => [
                [
                    'attribute' => 'created_at', 'label' => 'Date', 'format' => ['date', 'php:d/M/y'],
                    'enableSorting' => false,
                ], [
                    'label' => 'Current Status', 'format' => 'raw', 'value' => function ($model) {
                        $statusHelper = new StatusPillMaker();
                        return $statusHelper->pillBuilder($model->new_status);
                    }, 'contentOptions' => ['class' => 'col-1 text-start'],
                ],
                [
                    'attribute' => 'created_by',
                    'label' => 'By',
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'message',
                    'format' => 'raw',
                    'enableSorting' => false,
                    'value' => function ($model) {
                        if ($model->message == "") {
                            // If $model->message is empty, return a disabled icon or any alternative content
                            return '<i class="ti ti-message-circle fs-7 disabled-icon text-gray"></i>';
                        } else {
                            $title = "<p class='title_tool_tip'>$model->message</p>";
                            return '<i class="cursor-pointer ti ti-message-circle fs-7 fw-semibold text-dark" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-html="true" title="'.$title.'"></i>';
                        }
                    },
                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
<?php
$this->registerJsFile('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js',
    ['depends' => [JqueryAsset::class]]);
$this->registerJs(<<<JS
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
JS
);
?>