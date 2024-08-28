<?php

use common\helpers\StatusPillMaker;
use common\helpers\Variables;
use common\helpers\ViewRenderer;
use common\models\Country;
use common\models\Outbound;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;


/** @var yii\web\View $this */
/** @var common\models\Outbound $model */
/** @var common\models\InboundHostUniversityCourses $dataProvider */

$this->title = 'Inbound Profile';
$this->params['breadcrumbs'][] = $this->title;
$pill = new StatusPillMaker();
$view = new ViewRenderer();


?>

<?php if ($model === null): ?>
    <div class="text-center">
        <p>You do not have any records yet.</p>
        <?= Html::a('Create New Record', ['create'], ['class' => 'btn-submit']) ?>
    </div>
<?php else: ?>
    <div class="application-header row">

        <h2 class="col-lg-12 text-color-dark user-header"><?= Html::encode($model->name) ?></h2>

        <div class="row align-items-center mb-2">
            <div class="col-lg-10 d-flex gap-2">
                <?= $pill->pillBuilder($model->status) ?>
                <p class="pill pill-draft mb-0">
                    <?= Html::encode($model->citizenship) ?>
                </p>
            </div>
            <div class="col-lg-2 text-end">

                <?php if ($model->status === null || $model->status === 3) : ?>
                    <?= Html::a(
                        '<i class="ti ti-refresh"></i> Update your Info',
                        ['update', 'id' => $model->id],
                        [
                            'class' => 'btn-submit fw-bolder mb-0',
                            'title' => 'Update your Info', // Tooltip for the link
                        ]
                    ); ?>

                <?php endif; ?>
                <?php if (in_array($model->status, [Variables::redirected_to_student_UPLOAD_files, Variables::application_files_not_complete, Variables::application_reminder_sent])) : ?>

                     <?= Html::button('<i class="ti ti-plus fs-5" ></i> Upload Files',
                            [
                                'value' => Url::to(['upload', 'id' => $model->id]),
                                'class' => 'btn-submit w-100',
                                'id' => 'modalButton',
                                'onclick' => "$('#modal').modal('show').find('#modalContent').load($(this).attr('value')); $('#modal').find('.modal-title').html('<h1>New Agreement Record</h1>');",
                            ]); ?>

                <?php endif; ?>

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
                <?= $view->renderer($model->host_university_country , 'Country') ?>
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
                            <?= $view->downloadLinkBuilder($model->f_offer_letter, 'Offer Letter', $model->id) ?>
                            <?= $view->downloadLinkBuilder($model->f_academic_transcript, 'Academic Transcript', $model->id) ?>
                            <?= $view->downloadLinkBuilder($model->f_program_brochure, 'Program Brochure', $model->id) ?>
                            <?= $view->downloadLinkBuilder($model->f_latest_payslip, 'Latest Payslip', $model->id) ?>
                            <?= $view->downloadLinkBuilder($model->f_other_latest_payslip, 'Other Latest Payslip', $model->id) ?>
                            <?= $view->downloadLinkBuilder($model->f_mobility_report, 'Mobility Report', $model->id) ?>
                        </div>
                        <div class = "col-md-12 col-lg-6">
                            <?= $view->downloadLinkBuilder($model->f_proof_sponsorship, 'Proof Sponsorship', $model->id) ?>
                            <?= $view->downloadLinkBuilder($model->f_proof_sponsorship_cover, 'Sponsorship Cover', $model->id) ?>
                            <?= $view->downloadLinkBuilder($model->f_letter_indemnity, 'Letter Indemnity', $model->id) ?>
                            <?= $view->downloadLinkBuilder($model->f_certificate_attendance, 'Certificate Attendance', $model->id) ?>
                            <?= $view->downloadLinkBuilder($model->f_academic_transcript_host_university, 'Transcript Host University', $model->id) ?>
                            <?= $view->downloadLinkBuilder($model->f_flight_ticket, 'Flight Ticket', $model->id) ?>
                            <?= $view->downloadLinkBuilder($model->f_travel_insurance, 'Flight Ticket', $model->id) ?>
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

    <div class="col-md-12 col-lg-12 fade-in">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="d-flex text-color-dark fw-bolder align-items-center gap-2">
                    <i class="ti ti-book fw-bolder fs-9"></i> Gallery
                </h2>
                <hr>

                <!-- Images Row -->
                <?php
                // Check if there are image files
                $hasImages = false;
                foreach ($files as $file) {
                    if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif'])) {
                        $hasImages = true;
                        break;
                    }
                }
                ?>

                <?php if ($hasImages): ?>
                    <h4 class="d-flex text-color-dark fw-bolder align-items-center gap-2">
                        <i class="ti ti-photo fw-bolder fs-9"></i> Images
                    </h4>
                    <div class="row mb-7">
                        <?php foreach ($files as $file): ?>
                            <?php
                            $fileUrl = Yii::$app->urlManager->createUrl(['outbound/serve-file', 'filename' => $file]);
                            $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
                            if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])):
                                $title = pathinfo($file, PATHINFO_FILENAME); // Title based on file name
                                ?>
                                <div class="col-auto">
                                    <?= Html::a(
                                        Html::img($fileUrl, ['class' => 'img-thumbnail', 'width' => '150', 'height' => '150']),
                                        $fileUrl,
                                        ['rel' => 'fancybox', 'data-fancybox' => 'gallery-images', 'title' => $title]
                                    ) ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Videos Row -->
                <?php
                // Check if there are video files
                $hasVideos = false;
                foreach ($files as $file) {
                    if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['mp4', 'avi'])) {
                        $hasVideos = true;
                        break;
                    }
                }
                ?>

                <?php if ($hasVideos): ?>
                    <h4 class="d-flex text-color-dark fw-bolder align-items-center gap-2">
                        <i class="ti ti-video fw-bolder fs-9"></i> Videos
                    </h4>
                    <div class="row">
                        <?php foreach ($files as $file): ?>
                            <?php
                            $fileUrl = Yii::$app->urlManager->createUrl(['outbound/serve-file', 'filename' => $file]);
                            $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
                            if (in_array($fileExtension, ['mp4', 'avi'])):
                                $title = pathinfo($file, PATHINFO_FILENAME); // Title based on file name
                                ?>
                                <div class="col-md-3">
                                    <?= Html::a(
                                        '<video class="video-thumbnail" controls><source src="' . $fileUrl . '" type="video/mp4"></video>',
                                        $fileUrl,
                                        ['rel' => 'fancybox', 'data-fancybox' => 'gallery-videos', 'title' => $title]
                                    ) ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif;?>


    <?php
    // Initialize FancyBox with separate groups for images and videos
    echo \newerton\fancybox\FancyBox::widget([
        'target' => 'a[rel=fancybox]',
        'helpers' => true,
        'mouse' => true,
        'config' => [
            'maxWidth' => '90%',
            'maxHeight' => '90%',
            'playSpeed' => 7000,
            'padding' => 0,
            'fitToView' => false,
            'width' => '70%',
            'height' => '70%',
            'autoSize' => false,
            'closeClick' => false,
            'openEffect' => 'elastic',
            'closeEffect' => 'elastic',
            'prevEffect' => 'elastic',
            'nextEffect' => 'elastic',
            'closeBtn' => false,
            'openOpacity' => true,
            'helpers' => [
                'title' => ['type' => 'float'],
                'buttons' => [],
                'thumbs' => ['width' => 68, 'height' => 50],
                'overlay' => [
                    'css' => [
                        'background' => 'rgba(0, 0, 0, 0.8)'
                    ]
                ]
            ]
        ]
    ]);
    ?>



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