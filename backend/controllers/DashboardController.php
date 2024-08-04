<?php
namespace backend\controllers;

use common\helpers\Variables;
use common\models\Outbound;
use common\models\search\InboundSearch;
use common\models\search\OutboundSearch;
use Yii;
use yii\web\Controller;

class DashboardController extends Controller
{
    public function actionIdashboard($year = null)
    {
        // Get the current year if no year is provided
        if ($year === null) {
            $year = date('Y');
        }

        // Get country count data
        $inboundSearch = new InboundSearch();
        $countryData = $inboundSearch->getCountryCount($year);

        // Extract categories and series data for the bar chart
        $categories = array_map(function($item) {
            return $item['name'];
        }, $countryData);

        $seriesData = array_map(function($item) {
            return $item['data'][0][1]; // Extract count value
        }, $countryData);

        $series = [
            [
                'name' => 'Country Count',
                'data' => $seriesData,
            ]
        ];

        // Get monthly record count data for the line chart
        $monthlyData = $inboundSearch->getMonthlyRecordCount($year);

        // Initialize array for all months
        $months = [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
        ];

        // Initialize the series data with zero counts for all months
        $monthSeriesData = array_fill(1, 12, 0);

        // Populate the series data with actual counts from $monthlyData
        foreach ($monthlyData as $data) {
            $monthSeriesData[$data['month']] = $data['count'];
        }

        // Prepare categories (month names) and series data for the line chart
        $monthCategories = array_values($months);
        $monthSeries = [
            [
                'name' => 'Records Created',
                'data' => array_values($monthSeriesData),
            ]
        ];

        // Get status count data for the pie chart
        $statusData = $inboundSearch->getStatusCount($year);

        // Prepare series data for the pie chart
        $statusSeriesData = [];
        $statusCategories = [];

        foreach ($statusData as $data) {
            if ($data['status'] == Variables::application_accepted_inbound) {
                $statusCategories[] = 'Approved';
                $statusSeriesData[] = $data['count'];
            } elseif ($data['status'] == 2) {
                $statusCategories[] = 'Rejected';
                $statusSeriesData[] = $data['count'];
            }
        }


        $statusSeries = $statusSeriesData;

        // Pass data to the view
        return $this->render('idashboard', [
            'categories' => $categories,
            'series' => $series,
            'monthCategories' => $monthCategories,
            'monthSeries' => $monthSeries,
            'statusCategories' => $statusCategories,
            'statusSeries' => $statusSeries,
        ]);
    }

    public function actionOdashboard($year = null)
    {
        // Get the current year if no year is provided
        if ($year === null) {
            $year = date('Y');
        }

        // Get country count data
        $inboundSearch = new OutboundSearch();
        $countryData = $inboundSearch->getCountryCount($year);

        // Extract categories and series data for the bar chart
        $categories = array_map(function($item) {
            return $item['name'];
        }, $countryData);

        $seriesData = array_map(function($item) {
            return $item['data'][0][1]; // Extract count value
        }, $countryData);

        $series = [
            [
                'name' => 'Country Count',
                'data' => $seriesData,
            ]
        ];

        // Get monthly record count data for the line chart
        $monthlyData = $inboundSearch->getMonthlyRecordCount($year);

        // Initialize array for all months
        $months = [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
        ];

        // Initialize the series data with zero counts for all months
        $monthSeriesData = array_fill(1, 12, 0);

        // Populate the series data with actual counts from $monthlyData
        foreach ($monthlyData as $data) {
            $monthSeriesData[$data['month']] = $data['count'];
        }

        // Prepare categories (month names) and series data for the line chart
        $monthCategories = array_values($months);
        $monthSeries = [
            [
                'name' => 'Records Created',
                'data' => array_values($monthSeriesData),
            ]
        ];

        // Get status count data for the pie chart
        $statusData = $inboundSearch->getStatusCount($year);

        // Prepare series data for the pie chart
        $statusSeriesData = [];
        $statusCategories = [];

        foreach ($statusData as $data) {
            if ($data['status'] == Variables::application_accepted_inbound) {
                $statusCategories[] = 'Approved';
                $statusSeriesData[] = $data['count'];
            } elseif ($data['status'] == 2) {
                $statusCategories[] = 'Rejected';
                $statusSeriesData[] = $data['count'];
            }
        }


        $statusSeries = $statusSeriesData;

        // Pass data to the view
        return $this->render('odashboard', [
            'categories' => $categories,
            'series' => $series,
            'monthCategories' => $monthCategories,
            'monthSeries' => $monthSeries,
            'statusCategories' => $statusCategories,
            'statusSeries' => $statusSeries,
        ]);
    }




}
