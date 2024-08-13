<?php

use common\helpers\StatusPillMaker;
use common\helpers\viewRenderer;
use common\models\Country;
use yii\bootstrap5\Modal;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Inbound $model */


$view = new ViewRenderer();
$pill = new StatusPillMaker();
$this->title = 'Approval: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Inbound', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
    <div class="application-header row">

        <h2 class="col-lg-12 text-color-dark user-header"><?= Html::encode($model->name) ?></h2>

        <div class="row align-items-center mb-2">
            <div class="col-lg-10 d-flex gap-2">
                <?= $pill->pillBuilder($model->status) ?>
                <p class="pill pill-draft mb-0">
                    <?= Html::encode($model->citizenship) ?>
                </p>
            </div>
            <div class="col-lg-2 text-end p-0">
                <?=
                Html::a('Approval', 'javascript:void(0);', [
                    'class' => 'btn btn-dark fs-5 fw-bolder showModalButton',
                    'value' => Url::to(['workflowi/update', 'id' => $model->id, 'token' => $model->token]),
                    'onclick' => "$('#modal-activity').modal('show').find('#modalContent').load($(this).attr('value'), function() {
                            $('#modal-activity').find('.modal-title').html('<h1 class=\"mb-0\">Approval</h1>');
                        });" ]);?>
            </div>
        </div>
    </div>


    <div class="row g-2">
        <div class="col-md-12 col-lg-8 fade-in">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="d-flex text-color-dark fw-bolder align-items-center gap-2"><i class="ti ti-user-circle fw-bolder fs-9"></i> User Details</h2>
                    <hr>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <?= $view->renderer($model->gender, 'Gender') ?>
                            <?= $view->renderer($model->relation_ship, 'Marital Status') ?>
                            <?= $view->renderer($model->religion, 'Religion') ?>
                            <?= $view->renderer($model->mazhab, 'Mazhab') ?>
                            <?= $view->renderer($model->passport_expiration, 'Passport Expiration') ?>
                            <?= $view->renderer($model->mobile_number, 'Mobile Number') ?>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <?= $view->renderer($model->post_code, 'Postcode') ?>
                            <?= $view->renderer($model->country, 'Country') ?>
                            <?= $view->renderer($model->country_of_origin, 'Country of Origin') ?>
                            <?= $view->renderer($model->country_of_residence, 'Country of Residence') ?>
                            <?= $view->renderer($model->birth_date, 'Date of Birth') ?>
                            <?= $view->renderer($model->passport_number, 'Passport Number') ?>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <?= $view->renderer($model->email, 'Email Address', true) ?>
                            <?= $view->renderer($model->permanent_address, 'Address') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-lg-4 fade-in">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="d-flex text-color-dark fw-bolder align-items-center gap-2"><i class="ti ti-user fw-bolder fs-9"></i> Emergency Content</h2>
                    <hr>
                    <?= $view->renderer($model->emergency_name, 'Name') ?>
                    <?= $view->renderer($model->emergency_relationship, 'Relationship') ?>
                    <?= $view->renderer($model->emergency_mobile_number, 'Phone Number') ?>
                    <?= $view->renderer($model->emergency_email, 'Email', true) ?>
                    <?= $view->renderer($model->emergency_country, 'Country') ?>
                    <?= $view->renderer($model->emergency_postcode, 'Post Code') ?>
                    <?= $view->renderer($model->emergency_address, 'Address') ?>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-lg-4 fade-in">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="d-flex text-color-dark fw-bolder align-items-center gap-2"><i class="ti ti-user-check fw-bolder fs-9"></i> Host Details</h2>
                    <hr>
                    <?= $view->renderer($model->home_university_pic_name, 'Name') ?>
                    <?= $view->renderer($model->home_university_pic_position, 'Position') ?>
                    <?= $view->renderer($model->home_university_pic_email, 'Email', true) ?>
                    <?= $view->renderer($model->home_university_pic_mobile_number, 'Phone Number') ?>
                    <?= $view->renderer($model->home_university_approval_date, 'Approval Date') ?>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-lg-8 fade-in">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="d-flex text-color-dark fw-bolder align-items-center gap-2"><i class="ti ti-school fw-bolder fs-9"></i> Academic Background</h2>
                    <hr>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <?= $view->renderer($model->academic_home_university, 'Home University') ?>
                            <?= $view->renderer($model->academic_education_lvl, 'Level of Education') ?>
                            <?= $view->renderer($model->academic_program_name, 'Programme') ?>
                            <?= $view->renderer($model->academic_faculty_name, 'Name of Faculty') ?>
                            <?= $view->renderer($model->academic_result, 'Current Result') ?>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <?= $view->renderer($model->academic_semester, 'Current Semester') ?>
                            <?= $view->renderer($model->academic_year, 'Current Year') ?>
                            <?= $view->renderer($model->memorandum_of_agreement, 'University have MOU/MOA with IIUM') ?>
                        </div>
                        <div class="col-lg-12">
                            <?= $view->renderer($model->academic_research_title, 'Research Title') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-7 fade-in">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="d-flex text-color-dark fw-bolder align-items-center gap-2"><i class="ti ti-school-bell fw-bolder fs-9"></i> Proposal Program</h2>
                    <hr>
                    <?= $view->renderer($model->propose_program_type, 'Program Type') ?>
                    <?= $view->renderer($model->propose_mobility_type, 'Mobility Type') ?>
                    <?= $view->renderer($model->propose_kulliyyah_applied, 'Kulliyyah Applied') ?>
                    <?= $view->renderer($model->propose_transform_credit_hours, 'Credit Hours') ?>
                    <?= $view->renderer($model->propose_duration_start, 'Duration Start') ?>
                    <?= $view->renderer($model->propose_duration_end, 'Duration End') ?>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-lg-5 fade-in">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="d-flex text-color-dark fw-bolder align-items-center gap-2"><i class="ti ti-moneybag fw-bolder fs-9"></i> Financial</h2>
                    <hr>
                    <?= $view->renderer($model->financial_accommodation_in_campus, 'In Campus Accommodation') ?>
                    <?= $view->renderer($model->campus_location, 'Location Name') ?>
                    <?= $view->renderer($model->room_type, 'Room Type') ?>
                    <?= $view->renderer($model->financial_funding, 'Funding') ?>
                    <?= $view->renderer($model->sponsor_name, 'Sponsor Name') ?>
                    <?= $view->renderer($model->sponsor_amount, 'Amount') ?>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-lg-10 fade-in">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="d-flex text-color-dark fw-bolder align-items-center gap-2"><i class="ti ti-book fw-bolder fs-9"></i> Courses</h2>
                    <hr>
                    <div class="table-responsive">
                        <?= GridView::widget([
                            'dataProvider' => $hostDataProvider,
                            'columns' => [
                                'course_id',
                                'course_name',
                                'course_credit_hours',
                            ],
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-lg-2 fade-in">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="d-flex text-color-dark fw-bolder align-items-center gap-2"><i class="ti ti-file fw-bolder fs-9"></i> Files</h2>
                    <hr>
                    <?= $view->downloadLinkBuilder($model->f_language_english_certificate, 'English Certificate', $model->id) ?>
                    <?= $view->downloadLinkBuilder($model->f_passport, 'Passport Information Page', $model->id) ?>
                    <?= $view->downloadLinkBuilder($model->f_latest_passport_photo, 'Passport Photo', $model->id) ?>
                    <?= $view->downloadLinkBuilder($model->f_latest_academic_transcript, 'Full Academic Transcript', $model->id) ?>
                    <?= $view->downloadLinkBuilder($model->f_sponsorship_letter, 'Official Letter of Sponsorship ', $model->id) ?>
                    <?= $view->downloadLinkBuilder($model->f_recommendation_letter, 'Recommendation Letter', $model->id) ?>
                    <?= $view->downloadLinkBuilder($model->f_academic_study_plan, 'Study Plan', $model->id) ?>
                    <?= $view->downloadLinkBuilder($model->f_confirmation_letter, 'Confirmation Letter', $model->id) ?>
                    <?= $view->downloadLinkBuilder($model->f_offer_letter, 'Offer Letter', $model->id) ?>
                    <?= $view->downloadLinkBuilder($model->f_proof_of_payment, 'Proof of Payment', $model->id) ?>
                </div>
            </div>
        </div>
    </div>

<?php modal::begin(['title' => '', 'id' => 'modal-activity', 'size' => 'modal-lg', 'bodyOptions' => ['class' => 'modal-inner-padding-body mt-0'], 'headerOptions' => ['class' => 'modal-inner-padding justify-content-between'], 'centerVertical' => true, 'scrollable' => true,]);

echo "<div id='modalContent'></div>";

modal::end();
?>

    <script>
        $(document).ready(function() {
            $('.fade-in').each(function(i) {
                $(this).css('animation-delay', (i * 0.2) + 's');
                $(this).addClass('animated'); // Ensure this class is applied to trigger the animation
            });
        });

    </script>

<?php  if (Yii::$app->session->hasFlash('sweetAlertError')) {
    $this->registerJs("
Swal.fire({
icon: 'error',
title: 'Oops...',
text: 'Your application is currently being processed.',
});
");
}
?>