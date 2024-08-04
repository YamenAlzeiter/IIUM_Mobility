<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Inbound $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Inbounds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="inbound-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'status',
            'name',
            'gender',
            'relation_ship',
            'birth_date',
            'mobile_number',
            'email:email',
            'passport_number',
            'passport_expiration',
            'religion',
            'mazhab',
            'citizenship',
            'country',
            'country_of_origin',
            'country_of_residence',
            'permanent_address:ntext',
            'post_code',
            'emergency_name',
            'emergency_relationship',
            'emergency_mobile_number',
            'emergency_email:email',
            'emergency_address:ntext',
            'emergency_postcode',
            'emergency_country',
            'academic_home_university',
            'academic_education_lvl',
            'academic_program_name',
            'academic_semester',
            'academic_year',
            'academic_faculty_name',
            'academic_result',
            'academic_research_title:ntext',
            'memorandum_of_agreement',
            'language_is_native_english:boolean',
            'language_english_test_name',
            'propose_program_type',
            'propose_mobility_type',
            'propose_kulliyyah_applied',
            'propose_duration_start',
            'propose_duration_end',
            'propose_study_duration',
            'propose_transform_credit_hours',
            'financial_accommodation_in_campus',
            'campus_location:ntext',
            'financial_funding',
            'sponsor_name',
            'sponsor_amount',
            'room_type',
            'home_university_pic_name',
            'home_university_pic_email:email',
            'home_university_pic_mobile_number',
            'home_university_pic_position',
            'home_university_approval_date',
            'f_language_english_certificate:ntext',
            'f_recommendation_letter:ntext',
            'f_passport:ntext',
            'f_latest_passport_photo:ntext',
            'f_latest_academic_transcript:ntext',
            'f_confirmation_letter:ntext',
            'f_sponsorship_letter:ntext',
            'f_offer_letter:ntext',
            'f_proof_of_payment:ntext',
            'kulliyyah_id',
            'cps_id',
            'agreement:boolean',
            'token:ntext',
            'temp:ntext',
            'updated_at',
            'created_at',
        ],
    ]) ?>

</div>
