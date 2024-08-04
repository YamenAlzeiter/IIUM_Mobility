<?php

namespace common\helpers;


use Yii;
use yii\bootstrap5\Html;

class viewRenderer
{

//a thing i might comeback to idk
//$sectionAdditionalDetails = [['attribute' => $model->grant_fund, 'title' => 'Fund'],
//['attribute' => $model->member, 'title' => 'Number of Members'],
//['attribute' => $model->proposal, 'title' => 'Proposal'],
//['attribute' => $model->project_title, 'title' => 'Project Title'],
//['attribute' => $model->ssm, 'title' => 'SSM'],
//['attribute' => $model->company_profile, 'title' => 'Company Profile'],
//['attribute' => $model->mcom_date, 'title' => 'MCOM Date'],
//['attribute' => $model->sign_date, 'title' => 'Sign Date'],
//['attribute' => $model->end_date, 'title' => 'Expiry Date'],];
//$sectionPersonInChargeDetails = [['attribute' => $model->pi_name, 'title' => 'Name'],
//['attribute' => $model->pi_kulliyyah, 'title' => 'Kulliyyah'],
//['attribute' => $model->pi_phone_number, 'title' => 'Phone Number'],
//['attribute' => $model->pi_email, 'title' => 'Email Address'],];
//$sectionCollaboratorDetails = [['attribute' => $model->col_name, 'title' => 'Name'],
//['attribute' => $model->col_phone_number, 'title' => 'Phone Number'],
//['attribute' => $model->col_collaborators_name, 'title' => 'Collaborators Name'],
//['attribute' => $model->col_address, 'title' => 'Address'],
//['attribute' => $model->col_organization, 'title' => 'Organization'],
//['attribute' => $model->col_email, 'title' => 'Email Address'],
//['attribute' => $model->col_wire_up, 'title' => 'Wire Up'],]

    public function renderer($attribute, $title, $isEmail = false)
    {
        if ($attribute != '') {
            if (!$isEmail) {
                return '<p class="fw-bolder mb-2 text-color-dark fs-4">'.$title.': <span class="fw-lighter">'.$attribute.'</span></p>';
            } else {
                return '<p class="fw-bolder mb-2 text-color-dark fs-4">'.$title.': <a href=" mailto: '.$attribute.'" class="fw-normal">'.$attribute.'</a></p>';
            }
        } else {
            return null;
        }
    }

    public function downloadLinkBuilder($attribute, $name, $id)
    {
        $link = Html::tag('p', Html::a($name, ['downloader', 'filePath' => $attribute, 'id' => $id], [
            'class' => 'text-decoration-none fw-bolder text-color-dark download-link',
            'data-file-path' => $attribute,
        ]));
        return $attribute !== null ? $link : null;
    }

    public function downloadLinkBuilderToken($attribute, $name)
    {
        $id = Yii::$app->params['currentId'];
        $token = Yii::$app->params['currentToken'];

        $link = Html::tag('p', Html::a($name, ['downloader', 'id' => $id, 'token' => $token, 'filePath' => $attribute], [
            'class' => 'text-decoration-none fw-bolder text-color-dark download-link',
            'data-file-path' => $attribute,
        ]));
        return $attribute !== null ? $link : null;
    }

    function renderActionButton($title, $buttonLabel, $url, $haveActivity = false, $options = [])
    {
        // Default button options
        $buttonOptions = [
            'class' => 'btn-action', 'id' => 'modelButton', 'onclick' => "
            $('#modal-activity').modal('show').find('#modalContent').load($(this).attr('value'), function() {
                // Append the HTML snippet to the modal content
                $('#modalContent').append('');
                
                // Set the modal title
                $('#modal-activity').find('.modal-title').html('<h1 class=\"mb-0\">$title</h1>');
            });
        ",
        ];

        // Merge custom options with default options
        $buttonOptions = array_merge($buttonOptions, $options);

        // Render the button only if there's activity
        if ($haveActivity) {
            echo Html::button($buttonLabel, array_merge($buttonOptions, ['value' => $url]));
        }
    }
}