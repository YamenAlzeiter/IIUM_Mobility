<?php
use onmotion\apexcharts\ApexchartsWidget;

$this->title = 'Outbound Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row g-2">
    <div class="col-md-12 col-lg-12 fade-in">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="d-flex text-color-dark fw-bolder align-items-center gap-2"> Country</h2>
                <hr>
                <?php
                echo ApexchartsWidget::widget([
                    'type' => 'bar',
                    'height' => '400',
                    'chartOptions' => [
                        'chart' => [
                            'toolbar' => [
                                'show' => true,
                                'autoSelected' => 'zoom',
                            ],
                        ],
                        'xaxis' => [
                            'categories' => $categories,
                        ],
                        'plotOptions' => [
                            'bar' => [
                                'horizontal' => false,
                                'endingShape' => 'rounded',
                            ],
                        ],
                        'dataLabels' => [
                            'enabled' => false,
                        ],
                        'stroke' => [
                            'show' => true,
                            'colors' => ['transparent'],
                        ],
                        'colors' => ['#00928f'],
                        'legend' => [
                            'verticalAlign' => 'bottom',
                            'horizontalAlign' => 'left',
                        ],
                    ],
                    'series' => $series,
                ]);

                // Render the line chart for monthly record counts

                ?>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-lg-8 fade-in">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="d-flex text-color-dark fw-bolder align-items-center gap-2"> Monthly Inbound Application</h2>
                <hr>
                <?php
                echo ApexchartsWidget::widget([
                    'type' => 'line',
                    'height' => '400',
                    'chartOptions' => [
                        'chart' => [
                            'toolbar' => [
                                'show' => true,
                                'autoSelected' => 'zoom',
                            ],
                        ],
                        'xaxis' => [
                            'categories' => $monthCategories, // Month names as categories
                        ],
                        'dataLabels' => [
                            'enabled' => true,
                        ],
                        'stroke' => [
                            'curve' => 'straight', // Set the curve to 'straight' for hard edges
                        ],
                        'colors' => ['#00928f'], // Set the color of the line
                        'legend' => [
                            'verticalAlign' => 'bottom',
                            'horizontalAlign' => 'left',
                        ],
                    ],
                    'series' => $monthSeries,
                ]);


                ?>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-4 fade-in">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="d-flex text-color-dark fw-bolder align-items-center gap-2">Approved & Rejected</h2>
                <hr>
                <?php
                echo ApexchartsWidget::widget([
                    'type' => 'pie',
                    'height' => '400',
                    'chartOptions' => [
                        'chart' => [
                            'toolbar' => [
                                'show' => true,
                            ],
                        ],
                        'labels' => $statusCategories, // Status labels
                        'colors' => ['#00928f', '#ff0000'], // Colors for each segment
                        'legend' => [
                            'position' => 'bottom',
                        ],
                    ],
                    'series' => $statusSeries, // Pie chart data
                ]);
                ?>
            </div>
        </div>
    </div>

</div>

