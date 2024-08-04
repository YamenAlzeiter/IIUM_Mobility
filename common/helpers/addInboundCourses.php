<?php
namespace common\helpers;

class addInboundCourses
{
    public function addCourses($form, $model, $courseIndex, $courseType)
    {?>
        <div id="<?= $courseType ?>-course-row-<?= $courseIndex ?>">

            <div class="row course-row <?= $courseType ?>-course-row">
                <div class="col-lg-3">
                    <?= $form->field($model, "[$courseIndex]course_id")->textInput(['id' => "$courseType-course-id-$courseIndex"]) ?>
                </div>
                <div class="col-lg-6">
                    <?= $form->field($model, "[$courseIndex]course_name")->textInput(['id' => "$courseType-course-name-$courseIndex"]) ?>
                </div>
                <div class="col-lg-2">
                    <?= $form->field($model, "[$courseIndex]course_credit_hours")->textInput(['id' => "$courseType-course-credit-hours-$courseIndex"]) ?>
                </div>
                <div class="col-lg-1 align-self-end mb-3">
                    <button type="button" class="wizard-btn-remove remove-course-button" data-type="<?= $courseType ?>" data-index="<?= $courseIndex ?>"><i class="ti ti-x fs-4"></i></button>
                </div>
            </div>
        </div>
    <?php }

    public function initCourses($form, $model, $index, $courseType)
    {?>
        <div id="<?= $courseType ?>-course-row-<?= $index ?>">

            <div class="row course-row <?= $courseType ?>-course-row p-0">
                <div class="col-lg-3">
                    <?= $form->field($model, "[$index]course_id")->textInput(['id' => "$courseType-course-id-$index"]) ?>
                </div>
                <div class="col-lg-6">
                    <?= $form->field($model, "[$index]course_name")->textInput(['id' => "$courseType-course-name-$index"]) ?>
                </div>
                <div class="col-lg-2">
                    <?= $form->field($model, "[$index]course_credit_hours")->textInput(['id' => "$courseType-course-credit-hours-$index"]) ?>
                </div>
                <div class="col-lg-1 align-self-end mb-3">
                    <button type="button" class="wizard-btn-remove remove-course-button" data-type="<?= $courseType ?>" data-index="<?= $index ?>"><i class="ti ti-x fs-4"></i></button>
                </div>
            </div>
        </div>
    <?php }
}
?>
