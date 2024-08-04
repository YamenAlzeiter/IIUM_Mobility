<?php

namespace common\helpers;

use common\models\Status;

class StatusPillMaker
{
    public function pillBuilder($status, $options = "")
    {

        $pill = $this->statusBadgeClass($status);
        $tag = $this->statusTag($status);
        $description = $this->statusDescription($status);

        $title = "$description";
        return <<<HTML
                    <div class='$pill  $options'>
                           <p class="m-0 fs-4">$tag</p>
                        <i class='cursor-pointer ti ti-info-circle fs-6'
                           data-bs-toggle='tooltip'
                           data-bs-placement='bottom'
                           data-bs-html='true'
                           title="$title"></i>
                    </div>
                HTML;
    }
    public function statusTag($status)
    {
        if ($status != null || $status != "") {
            $tag = Status::find()->where(['status' => $status])->one();
            return $tag->tag;
        } else {
            return " Eroor";
        }

    }

    public function statusDescription($status)
    {
        if ($status != null || $status != "") {
            $description = Status::find()->where(['status' => $status])->one();
            return $description->description;
        } else {
            return 'No Status Found';
        }
    }

    public function getStatusClasses($status, $attribute)
    {
        $classes = [
            1  =>  ['badge' => 'pill-warning'],
            5  =>  ['badge' => 'pill-warning'],
            11 =>  ['badge' => 'pill-warning'],
            15 =>  ['badge' => 'pill-warning'],
            21 =>  ['badge' => 'pill-warning'],
            25 =>  ['badge' => 'pill-warning'],
            31 =>  ['badge' => 'pill-warning'],
            35 =>  ['badge' => 'pill-warning'],
            41 =>  ['badge' => 'pill-warning'],
            45 =>  ['badge' => 'pill-warning'],
            51 =>  ['badge' => 'pill-warning'],
            55 =>  ['badge' => 'pill-warning'],
            61 =>  ['badge' => 'pill-warning'],
            65 =>  ['badge' => 'pill-warning'],
            71 =>  ['badge' => 'pill-warning'],
            10 =>  ['badge' => 'pill-warning'],
            //reSubmitted
             4 =>  ['badge' => 'pill-sendBack'],
             8 =>  ['badge' => 'pill-sendBack'],
            13 =>  ['badge' => 'pill-sendBack'],
            17 =>  ['badge' => 'pill-sendBack'],
            //rejection
             2 =>  ['badge' => 'pill-alert'],
             6 =>  ['badge' => 'pill-alert'],
            12 =>  ['badge' => 'pill-alert'],
            16 =>  ['badge' => 'pill-alert'],
            32 =>  ['badge' => 'pill-alert'],
            //not complete
             3 =>  ['badge' => 'pill-sendBack'],
             7 =>  ['badge' => 'pill-sendBack'],
            63 =>  ['badge' => 'pill-sendBack'],
            67 =>  ['badge' => 'pill-sendBack'],
            //success
            81 =>  ['badge' => 'pill-upcoming'],
            85 =>  ['badge' => 'pill-upcoming'],
        ];

        $default = ['badge' => 'pill-alert'];

        if (isset($classes[$status])) {
            return $classes[$status][$attribute];
        }

        return $default[$attribute];
    }

    public function statusBadgeClass($status)
    {
        return 'pill d-flex align-content-center justify-content-between align-items-center gap-2 mb-0 ' . $this->getStatusClasses($status, 'badge');
    }
}
