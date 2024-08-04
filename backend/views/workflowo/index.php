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
/** @var common\models\Outbound $model */


$view = new ViewRenderer();
$pill = new StatusPillMaker();
$this->title = 'Approval: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Outbounds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
    <div class="application-header row">

        <h2 class="col-lg-12 text-color-dark user-header"><?= Html::encode($model->name) ?></h2>

        <div class="row align-items-center mb-2 ">
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
                    'value' => Url::to(['workflowo/update', 'id' => $model->id, 'token' => $model->token]),
                    'onclick' => "$('#modal-activity').modal('show').find('#modalContent').load($(this).attr('value'), function() {
                            $('#modal-activity').find('.modal-title').html('<h1 class=\"mb-0\">Approval</h1>');
                        });" ]);?>
            </div>

        </div>
    </div>


    <div class="row g-2">
    <div class="col-md-12 col-lg-12 fade-in">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="d-flex text-color-dark fw-bolder align-items-center gap-2"><i class="ti ti-user-circle fw-bolder fs-9"></i> User Details</h2>
                <hr>
                <div class="row">
                    <div class="col-lg-6 col-md-12">

                        <?= $view->renderer($model->matric_card, 'Matric Number') ?>
                        <?= $view->renderer($model->gender, 'Gender') ?>
                        <?= $view->renderer($model->mobile_number, 'Mobile Number') ?>
                        <?= $view->renderer($model->passport_number, 'Passport Number') ?>
                        <?= $view->renderer($model->passport_expiration, 'Passport Expiration') ?>
                        <?= $view->renderer($model->birth_date, 'Date of Birth') ?>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <?= $view->renderer(Country::findOne($model->country)->name ?? false, 'Country') ?>
                        <?= $view->renderer($model->state, 'State') ?>
                        <?= $view->renderer($model->post_code, 'Postcode') ?>
                        <?= $view->renderer(Country::findOne($model->mailing_country)->name ?? false, 'Mailing Country') ?>
                        <?= $view->renderer($model->mailing_state, 'Mailing State') ?>
                        <?= $view->renderer($model->mailing_post_code, 'Mailing Postcode') ?>

                    </div>
                    <div class="col-lg-12 col-md-12">
                        <?= $view->renderer($model->email, 'Email Address', true) ?>
                        <?= $view->renderer($model->permanent_address, 'Address') ?>
                        <?= $view->renderer($model->mailing_post_code, 'Mailing Address') ?>
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
                <?= $view->renderer(($country = Country::findOne($model->emergency_country)) ? $country->name : false, 'Country') ?>
                <?= $view->renderer($model->emergency_state, 'State') ?>
                <?= $view->renderer($model->emergency_postcode, 'Post Code') ?>
                <?= $view->renderer($model->emergency_address, 'Address') ?>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-lg-4 fade-in">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="d-flex text-color-dark fw-bolder align-items-center gap-2"><i class="ti ti-school fw-bolder fs-9"></i> Academic Background</h2>
                <hr>
                <?= $view->renderer($model->academic_education_lvl, 'Level of Education') ?>
                <?= $view->renderer($model->academic_kulliyyah, 'Kulliyyah') ?>
                <?= $view->renderer($model->academic_program_name, 'Program Name') ?>
                <?= $view->renderer($model->academic_current_semester, 'Current Semester') ?>
                <?= $view->renderer($model->academic_current_year, 'Current Year') ?>
                <?= $view->renderer($model->academic_cgpa, 'CGPA') ?>
                <?= $view->renderer($model->research, 'Research') ?>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-4 fade-in">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="d-flex text-color-dark fw-bolder align-items-center gap-2"><i class="ti ti-language fw-bolder fs-9"></i> English Proficiency</h2>
                <hr>
                <?= $view->renderer($model->english_proficiency, 'English Test') ?>
                <?= $view->renderer($model->third_language, 'Third Language') ?>
                <?= $view->renderer($model->english_result, 'Result') ?>
                <h2 class="d-flex text-color-dark fw-bolder align-items-center gap-2"><i class="ti ti-language fw-bolder fs-9"></i> Funding</h2>
                <hr>
                <?= $view->renderer($model->financial_funded_accept, 'Financial Funding') ?>
                <?= $view->renderer($model->sponsorship_name, 'Sponsor Name') ?>
                <?= $view->renderer($model->sponsorship_funding, 'Funding Amount') ?>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-4 fade-in">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="d-flex text-color-dark fw-bolder align-items-center gap-2"><i class="ti ti-refresh-dot fw-bolder fs-9"></i> Mobility Details</h2>
                <hr>
                <?= $view->renderer($model->mobility_type, 'Type of Mobility') ?>
                <?= $view->renderer($model->mobility_program, 'Type of Program') ?>
                <?= $view->renderer($model->credit_transform_availability, 'Credit Transfer Availability') ?>
                <?= $view->renderer($model->host_university_name, 'Host University') ?>
                <?= $view->renderer($model->host_university_country, 'Country') ?>
                <?= $view->renderer($model->mobility_from, 'From') ?>
                <?= $view->renderer($model->mobility_until, 'Until') ?>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-4 fade-in">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="d-flex text-color-dark fw-bolder align-items-center gap-2"><i class="ti ti-user fw-bolder fs-9"></i> Person in Charge Info</h2>
                <hr>
                <?= $view->renderer($model->host_university_pic_name, 'Name') ?>
                <?= $view->renderer($model->host_university_pic_mobile_number, 'Phone Number') ?>
                <?= $view->renderer($model->host_university_pic_email, 'Email') ?>
                <?= $view->renderer($model->host_university_pic_position, 'Position') ?>
                <?= $view->renderer($model->host_university_pic_country, 'Country') ?>
                <?= $view->renderer($model->host_university_pic_postcode, 'Post Code') ?>
                <?= $view->renderer($model->host_university_pic_address, 'Address') ?>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-4 fade-in">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="d-flex text-color-dark fw-bolder align-items-center gap-2"><i class="ti ti-file fw-bolder fs-9"></i> Files</h2>
                <hr>
                <div class = "row">
                    <div class = "col-md-12 col-lg-6">
                        <?= $view->downloadLinkBuilderToken($model->f_offer_letter, 'English Certificate') ?>
                        <?= $view->downloadLinkBuilderToken($model->f_academic_transcript, 'Recommendation Letter') ?>
                        <?= $view->downloadLinkBuilderToken($model->f_program_brochure, 'Passport') ?>
                        <?= $view->downloadLinkBuilderToken($model->f_latest_payslip, 'Passport Photo') ?>
                        <?= $view->downloadLinkBuilderToken($model->f_other_latest_payslip, 'Academic Transcript') ?>
                    </div>
                    <div class = "col-md-12 col-lg-6">
                        <?= $view->downloadLinkBuilderToken($model->f_proof_sponsorship, 'Confirmation Letter') ?>
                        <?= $view->downloadLinkBuilderToken($model->f_proof_sponsorship_cover, 'Sponsorship Letter') ?>
                        <?= $view->downloadLinkBuilderToken($model->f_letter_indemnity, 'Offer Letter') ?>
                        <?= $view->downloadLinkBuilderToken($model->f_flight_ticket, 'Proof of Payment') ?>
                        <?= $view->downloadLinkBuilderToken($model->f_files, 'Proof of Payment') ?>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-6 fade-in">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="d-flex text-color-dark fw-bolder align-items-center gap-2"><i class="ti ti-book fw-bolder fs-9"></i> IIUM Courses</h2>
                <hr>
                <div class="table-responsive">
                    <?= GridView::widget([
                        'dataProvider' => $localDataProvider,
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
    <div class="col-md-12 col-lg-6 fade-in">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="d-flex text-color-dark fw-bolder align-items-center gap-2"><i class="ti ti-book fw-bolder fs-9"></i> Host University Courses</h2>
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