<?php

use common\helpers\addInboundCourses;
use common\models\Country;
use common\models\State;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\Outbound $model */
/** @var common\models\HostUniversityCources $modelsHostCourses*/
/** @var common\models\LocalUniversityCources $modelsLocalCourses*/
/** @var yii\widgets\ActiveForm $form */

$templateRadio = '{label}{input}{error}';
$templateFileInput = '<div class="col-md align-items-center"><div class="col-md-md-2 col-md-form-label">{label}</div>
                        <div class="col-md-md">{input}{error}</div></div>';

$addCourses = new addInboundCourses()
?>


<!--<div class="form-group">-->
<!--    --><?php //= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
<!--</div>-->

<?php $form = ActiveForm::begin(['enableClientValidation' => false, 'id' => 'create-form']); ?>
<div class="form-step active">
    <h2><i class="ti ti-user fw-bold"></i>Personal Information</h2>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'matric_card')->textInput(['maxlength' => true, 'placeholder'=> ''])?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder'=> ''])?>
        </div>
        <div class ="col-lg-4">
            <?= $form->field($model, 'citizenship')
                ->dropDownList(ArrayHelper::map(Country::find()->all(), 'nationality', 'nationality'),
                    ['prompt' => 'Select Nationality'])?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'gender',)->dropDownList(['Male' => 'Male', 'Female' => 'Female'], ['prompt' => 'Select Gender']) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'birth_date')->textInput(['type' => 'date'] )?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => ''])?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'mobile_number')->textInput(['maxlength' => true, 'placeholder' => ''])?>
        </div>
        <div class = "col-lg-6">
            <?= $form->field($model, 'passport_number')->textInput(['maxlength' => true, 'placeholder' => ''])?>
        </div>
        <div class = "col-lg-6">
            <?= $form->field($model, 'passport_expiration')->textInput(['type' => 'date'])?>
        </div>

        <div class = "col-lg-5">
            <?= $form->field($model, 'country')->dropDownList(
                ArrayHelper::map(Country::find()->all(), 'id', 'name'),
                [
                    'prompt' => 'Select Country',
                    'onchange' => '
                $.get("' . Url::toRoute('outbound/get-states') . '", { country: $(this).val() })
                    .done(function(data) {
                        $("select#state-id").html("");
                        $.each(data, function(key, value) {
                            $("select#state-id").append($("<option></option>").attr("value", key).text(value));
                        });
                    });
            ',
                ]
            ); ?>
        </div>
        <div class = "col-lg-5">
            <?= $form->field($model, 'state')->dropDownList(ArrayHelper::map(State::find()->all(), 'name', 'name'),
                ['prompt' => 'Select Country', 'id' => 'state-id'])?>
        </div>
        <div class = "col-lg-2">
            <?= $form->field($model, 'post_code')->textInput(['maxlength' => true, 'placeholder' => ''])?>
        </div>
        <div class = "col-lg-12">
            <?= $form->field($model, 'permanent_address')->textarea(['maxlength' => true, 'placeholder' => ''])?>
        </div>
        <div class = "col-lg-5">
            <?= $form->field($model, 'mailing_country')->dropDownList(
                    ArrayHelper::map(Country::find()->all(), 'id', 'name'),
                    [
                        'prompt' => 'Select Country',
                        'onchange' => '
                $.get("' . Url::toRoute('outbound/get-states') . '", { country: $(this).val() })
                    .done(function(data) {
                        $("select#mailing-state-id").html("");
                        $.each(data, function(key, value) {
                            $("select#mailing-state-id").append($("<option></option>").attr("value", key).text(value));
                        });
                    });
            ',
                    ]
                ); ?>
        </div>
        <div class = "col-lg-5">
            <?= $form->field($model, 'mailing_state')
                ->dropDownList(ArrayHelper::map(State::find()->all(), 'name', 'name'),
                    ['prompt' => 'Select Country', 'id' => 'mailing-state-id'])?>
        </div>
        <div class = "col-lg-2">
            <?= $form->field($model, 'mailing_post_code')->textInput(['maxlength' => true, 'placeholder' => ''])?>
        </div>
        <div class = "col-lg-12">
            <?= $form->field($model, 'mailing_permanent_address')->textarea(['maxlength' => true, 'placeholder' => ''])?>
        </div>

    </div>
</div>
<div class="form-step">
    <h2><i class="ti ti-phone-plus fw-bold"></i>Emergency Contact Information</h2>
    <div class="row">
        <div class = "col-lg-6">
            <?= $form->field($model, 'emergency_name')->textInput(['maxlength' => true, 'placeholder' => ''])?>
        </div>
        <div class = "col-lg-6">
            <?= $form->field($model, 'emergency_relationship')
                ->dropDownList([
                    'Father' => 'Father',
                    'Mother' => 'Mother',
                    'Sibling' => 'Sibling',
                    'blood relative' =>'blood relative',
                    'Friend' => 'Friend',
                    'Husband' => 'Husband',
                    'Wife' => 'Wife',
                ], ['prompt' => 'Select One']) ?>
        </div>
        <div class = "col-lg-6">
            <?= $form->field($model, 'emergency_mobile_number')->textInput(['maxlength' => true, 'placeholder' => ''])?>
        </div>
        <div class = "col-lg-6">
            <?= $form->field($model, 'emergency_email')->textInput(['maxlength' => true, 'placeholder' => ''])?>
        </div>
        <div class = "col-lg-5">
            <?= $form->field($model, 'emergency_country')
                ->dropDownList(
                    ArrayHelper::map(Country::find()->all(), 'id', 'name'),
                    [
                        'prompt' => 'Select Country',
                        'onchange' => '
                $.get("' . Url::toRoute('outbound/get-states') . '", { country: $(this).val() })
                    .done(function(data) {
                        $("select#emergency-state-id").html("");
                        $.each(data, function(key, value) {
                            $("select#emergency-state-id").append($("<option></option>").attr("value", key).text(value));
                        });
                    });
            ',
                    ]
                ); ?>
        </div>
        <div class = "col-lg-5">
            <?= $form->field($model, 'emergency_state')
                ->dropDownList(ArrayHelper::map(State::find()->all(), 'name', 'name'),
                    ['prompt' => 'Select Country', 'id' => 'emergency-state-id'])?>
        </div>
        <div class = "col-lg-2">
            <?= $form->field($model, 'emergency_postcode')->textInput(['maxlength' => true, 'placeholder' => ''])?>
        </div>
        <div class = "col-lg-12">
            <?= $form->field($model, 'emergency_address')->textarea(['maxlength' => true, 'placeholder' => ''])?>
        </div>
    </div>
</div>
<div class="form-step">
    <h2><i class="ti ti-school fw-bold"></i>Academic Information</h2>
    <div class="row">
        <div class = "col-lg-6">
            <?= $form->field($model, 'academic_education_lvl')
                ->dropDownList([
                    'Undergraduate' => 'Undergraduate',
                    'Postgraduate' => 'Postgraduate',],
                    ['prompt' => 'Select Level of Education', 'id' => 'education-lvl']) ?>
        </div>
        <div class = "col-lg-6">
            <?= $form->field($model, 'academic_kulliyyah')->textInput(['maxlength' => true, 'placeholder' => ''])?>
        </div>
        <div class = "col-lg-4">
            <?= $form->field($model, 'academic_program_name')->textInput(['maxlength' => true, 'placeholder' => ''])?>
        </div>
        <div class = "col-lg-2">
            <?= $form->field($model, 'academic_cgpa')->textInput(['maxlength' => true, 'placeholder' => ''])?>
        </div>
        <div class = "col-lg-3">
            <?= $form->field($model, 'academic_current_semester')
                ->dropDownList(array_combine(range(1, 10),
                    array_map(function ($i) {
                        return "Semester  $i";
                    }, range(1, 10))),
                    ['prompt' => 'Select Semester']) ?>
        </div>
        <div class = "col-lg-3">
            <?= $form->field($model, 'academic_current_year')
                ->dropDownList(array_combine(range(1, 6),
                    array_map(function ($i) {
                        return "Year  $i";
                    }, range(1, 6))),
                    ['prompt' => 'Select Year']) ?>
        </div>

        <h2 class="mt-2"><i class="ti ti-language fw-bold"></i>English Proficiency</h2>
        <div class = "col-lg-5">
            <?= $form->field($model, 'english_proficiency')
                ->dropDownList([
                    'Malaysia University English Test' => 'Malaysia University English Test',
                    'TOFEL' => 'TOFEL',
                    'IELTS' => 'IELTS',
                    'Other' => 'Other'
                ], ['prompt' => 'Select Test', 'id' => 'english-test']) ?>
        </div>
        <div class = "col-lg-2 mt-1">
            <?= $form->field($model, 'third_language')->textInput(['maxlength' => true, 'placeholder' => 'Other', 'disabled' => true])->label(' ')?>
        </div>
        <div class = "col-lg-5">
            <?= $form->field($model, 'english_result')->textInput(['maxlength' => true, 'placeholder' => ''])?>
        </div>
        <h2 class="mt-2"><i class="ti ti-zoom-money fw-bold"></i> Funding</h2>
        <div class="col-lg-12">
            <?= $form->field($model, 'financial_funded_accept')->dropDownList([
                'Yes' => 'Yes',
                'No' => 'No'
            ], ['prompt' => 'Select One', 'id' => 'funding']) ?>
        </div>
        <div id="fund-container" class="d-none gap-2">
            <div class="col-lg-6">
                <?= $form->field($model, 'sponsorship_name')->textInput(['maxlength' => true, 'placeholder' => ''])?>
            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'sponsorship_funding')->textInput(['maxlength' => true, 'placeholder' => ''])?>
            </div>
        </div>

        <div class="col-lg-10"><h2 class="mt-2"><i class="ti ti-book-2 fw-bold"></i> IIUM Courses </h2></div>
        <div id="add-course-button" class="col-lg-2 text-end align-self-center"><button type="button" class="wizard-btn-add" id="add-local-course-button"><i class="ti ti-plus fs-7"></i></button></div>
        <div id="local-course-container" class="col-lg-12">
            <?php  if(!empty($modelsLocalCourses)){
                foreach ($modelsLocalCourses as $index => $modelLocalCourse){
                    $addCourses->initCourses($form, $modelLocalCourse, $index, 'local');
                }
            } ?>
        </div>
        <div id="research-container" class="d-none">
            <div class = "col-lg-12">
                <?= $form->field($model, 'research')->textarea(['maxlength' => true, 'placeholder' => ''])?>
            </div>
        </div>
    </div>
</div>
<div class="form-step">
    <h2><i class="ti ti-moneybag fw-bold"></i>Host University Details</h2>
    <div class="row">
        <div class = "col-lg-12">
            <?= $form->field($model, 'host_university_name')->textInput(['maxlength' => true, 'placeholder' => '']) ?>
        </div>
        <div class = "col-lg-6">
            <?= $form->field($model, 'host_university_country')->dropDownList(ArrayHelper::map(Country::find()->all(), 'name', 'name'),
                ['prompt' => 'Select Country'])?>
        </div>
        <div class = "col-lg-6">
            <?= $form->field($model, 'credit_transform_availability')->dropDownList([
                'Yes' => 'Yes',
                'No' => 'No'
            ], ['prompt' => 'Select One']) ?>
        </div>
        <h2 class="mt-2"><i class="ti ti-user-circle fw-bold"></i> Person in Charge Contact Details</h2>
        <div class = "col-lg-6">
            <?= $form->field($model, 'host_university_pic_name')->textInput(['maxlength' => true, 'placeholder' => '']) ?>
        </div>
        <div class = "col-lg-6">
            <?= $form->field($model, 'host_university_pic_position')->textInput(['maxlength' => true, 'placeholder' => '']) ?>
        </div>
        <div class = "col-lg-6">
            <?= $form->field($model, 'host_university_pic_mobile_number')->textInput(['maxlength' => true, 'placeholder' => '']) ?>
        </div>
        <div class = "col-lg-6">
            <?= $form->field($model, 'host_university_pic_email')->textInput(['maxlength' => true, 'placeholder' => '']) ?>
        </div>
        <div class = "col-lg-6">
            <?= $form->field($model, 'host_university_pic_country') ->dropDownList(ArrayHelper::map(Country::find()->all(), 'name', 'name'),
                ['prompt' => 'Select Country'])?>
        </div>
        <div class = "col-lg-6">
            <?= $form->field($model, 'host_university_pic_postcode')->textInput(['maxlength' => true, 'placeholder' => '']) ?>
        </div>
        <div class = "col-lg-12">
            <?= $form->field($model, 'host_university_pic_address')->textarea(['placeholder' => '']) ?>
        </div>
        <div class = "col-lg-6">
            <?= $form->field($model, 'host_scholarship')->dropDownList([
                'Yes' => 'Yes',
                'No' => 'No'
            ], ['prompt' => 'Select One', 'id' => 'scholarship']) ?>
        </div>
        <div class = "col-lg-6">
            <?= $form->field($model, 'host_scholarship_amount')->textInput(['maxlength' => true, 'placeholder' => '', 'disabled' => true]) ?>
        </div>
        <div class="col-lg-10"><h2 class="mt-2"><i class="ti ti-book-2 fw-bold"></i> Host University Courses </h2></div>
        <div class="col-lg-2 text-end align-self-center"><button type="button" class="wizard-btn-add" id="add-host-course-button"><i class="ti ti-plus fs-7"></i></button></div>
        <div id="host-course-container" class="col-lg-12" >
            <?php  if(! empty($modelsHostCourses)){
                foreach ($modelsHostCourses as $index => $modelHostCourse){
                    $addCourses->initCourses($form, $modelHostCourse, $index, 'host');
                }
            } ?>
        </div>
    </div>
</div>
<div class="form-step">
    <h2><i class="ti ti-school fw-bold"></i> Mobility Program Details</h2>
    <div class="row">
        <div class = "col-lg-3">
            <?= $form->field($model, 'mobility_type')
                ->dropDownList([
                    'Physical' => 'Physical',
                    'Virtual' => 'Virtual'
                ], ['prompt' => 'Select Mobility Type']) ?>
        </div>
        <div class = "col-lg-3">
            <?= $form->field($model, 'mobility_program')
                ->dropDownList([
                    "Exchange Program (1 or 2 semesters)" => "Exchange Program (1 or 2 semesters)",
                    "Erasmus+ Exchange Program" => "Erasmus+ Exchange Program",
                    "Mevlana Exchange Program" => "Mevlana Exchange Program",
                    "Global UGRAD Program" => "Global UGRAD Program",
                    "Research Program" => "Research Program",
                    "Summer Program" => "Summer Program",
                    "Industrial Training/Internship" => "Industrial Training/Internship",
                    "Educational Visit" => "Educational Visit",
                    "Other" => "Other"
                ], ['prompt' => 'Select One', 'id' => 'mobility-program']) ?>
        </div>
        <div class = "col-lg-6 mt-1">
            <?= $form->field($model, 'mobility_program_other')->textInput(['maxlength' => true, 'placeholder' => 'Other', 'disabled' => true])->label('')?>
        </div>
        <div class = "col-lg-6">
            <?= $form->field($model, 'mobility_from')->textInput(['type' => 'date', 'placeholder' => ''])?>
        </div>
        <div class = "col-lg-6">
            <?= $form->field($model, 'mobility_until')->textInput(['type' => 'date', 'placeholder' => ''])?>
        </div>
    </div>
</div>
<div class="form-step step__last">
    <h2><i class="ti ti-file fw-bold"></i>Files & Agreement</h2>
    <div class="row">
        <div class = "col-lg-6"> <?= $form->field($model, 'f_offer_letter_file', ['template' => $templateFileInput])->fileInput()?></div>
        <div class = "col-lg-6"> <?= $form->field($model, 'f_academic_transcript_file', ['template' => $templateFileInput])->fileInput()?></div>
        <div class = "col-lg-6"> <?= $form->field($model, 'f_program_brochure_file', ['template' => $templateFileInput])->fileInput()?></div>
        <div class = "col-lg-6"> <?= $form->field($model, 'f_latest_payslip_file', ['template' => $templateFileInput])->fileInput()?></div>
        <div class="col-lg-12">

            <?= $form->field($model, 'agreement_accept')->checkbox([
                'label' => false,
                'template' => "{input} <label>I agree on the 
                        <button type=\"button\" class=\"link btn btn-light text-decoration-underline\" 
                            data-bs-toggle=\"modal\" 
                            data-bs-target=\"#termsModal\"
                            onclick=\"$('#modal').modal('show').find('#modalContent'); $('#modal').find('.modal-title').html('Terms And Conditions');\">
                            Terms and Conditions
                        </button>
                    </label>\n{error}",
                'encode' => false,
                'class' => 'checkbox'
            ])->label(false); ?>

        </div>
    </div>
</div>
<div class="wizard-btn-group">
    <div class="controllers">
        <button type="button" class="btn-prev" disabled>Back</button>
        <button type="button" class="btn-next">Next</button>
    </div>
    <div class="submitters">
        <?= Html::submitButton('Save', ['class' => 'btn-save', 'name' => 'saving', 'value' => 'validate']) ?>
        <?= Html::submitButton('Submit', ['class' => 'btn-submit', 'name' => 'creating', 'value' => 'validate']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>


<script>
    $(document).ready(function() {
        $('#add-local-course-button').on('click', function() {
            var courseIndex = $('#local-course-container .local-course-row').length;
            if (courseIndex < 7) {
                var newRow = `<?php $addCourses->addCourses($form, $modelLocalCourse, '[courseIndex]', 'local');?>`;
                newRow = newRow.replace(/\[courseIndex\]/g, courseIndex);
                $('#local-course-container').append(newRow);
                $('#local-course-container').find('.course-row:last input[type="text"]').val('');
            } else {
                Swal.fire({
                    title: "Oops...!",
                    text: "You Can't Add More than 7 Courses.",
                    icon: "error",
                });
            }
        });

        $('#add-host-course-button').on('click', function() {
            var courseIndex = $('#host-course-container .host-course-row').length;
            if (courseIndex < 7) {
                var newRow = `<?php $addCourses->addCourses($form, $modelHostCourse, '[courseIndex]', 'host');?>`;
                newRow = newRow.replace(/\[courseIndex\]/g, courseIndex);
                $('#host-course-container').append(newRow);
                $('#host-course-container').find('.course-row:last input[type="text"]').val('');
            } else {
                Swal.fire({
                    title: "Oops...!",
                    text: "You Can't Add More than 7 Courses.",
                    icon: "error",
                });
            }
        });

        $(document).on('click', '.remove-course-button', function() {
            var type = $(this).data('type');
            var index = $(this).data('index');
            $('#' + type + '-course-row-' + index).remove();
        });
    });



    document.addEventListener('DOMContentLoaded', function () {
        // Initialize elements based on server-side state or defaults
        initializeFormState();

        // Event listeners for dynamic form interactions
        setupEventListeners();

        // Function to initialize form elements based on server-side state
        function initializeFormState() {
            const educationLvl = document.getElementById('education-lvl');
            const researchContainer = document.getElementById('research-container');

            // Check initial state of accommodation option
            if (educationLvl.value === 'Postgraduate') {
                researchContainer.classList.remove('d-none');
            } else {
                researchContainer.classList.add('d-none');
            }

        }

        // Function to setup event listeners for dynamic form interactions
        function setupEventListeners() {
            const educationLvl = document.getElementById('education-lvl');
            const english = document.getElementById('english-test');
            const program = document.getElementById('mobility-program');
            const funding = document.getElementById('funding');
            const scholarship = document.getElementById('scholarship');

            // Event listener for accommodation option change
            educationLvl.addEventListener('change', function () {

                const researchContainer = document.getElementById('research-container');

                if (this.value === 'Postgraduate') {
                    researchContainer.classList.remove('d-none');
                } else {
                    researchContainer.classList.add('d-none');
                    clearInputs(researchContainer);
                }
            });

            // Event listener for funding option change
            english.addEventListener('change', function (){
                handleEnglishChange(this.value);
            })
            program.addEventListener('change', function (){
                handleProgramChange(this.value);
            })
            funding.addEventListener('change', function (){
                handleFundingChange(this.value)
            })
            scholarship.addEventListener('change', function (){
                handleScholarshipChange(this.value);
            })
        }


        // Function to handle changes in funding options
        function handleScholarshipChange(value) {
            const amount = document.getElementById('outbound-host_scholarship_amount');

            if (value === 'Yes') {
                amount.disabled = false;
            } else {
                amount.disabled = true;
                clearInputs(amount);

            }
        }
        function handleFundingChange(value) {
            const funding = document.getElementById('fund-container');
            const sponsorName = document.getElementById('outbound-sponsorship_name');
            const fund = document.getElementById('outbound-sponsorship_funding');


            if (value === 'Yes') {
                funding.classList.remove('d-none');
                funding.classList.add('d-flex');
            } else {
                funding.classList.remove('d-flex');
                funding.classList.add('d-none');
                clearInputs(sponsorName);
                clearInputs(fund);
            }
        }
        function handleEnglishChange(value) {
            const englishOther = document.getElementById('outbound-third_language');


            if (value === 'Other') {
                englishOther.disabled = false;
            }else {
                englishOther.disabled = true;
                clearInputById('outbound-third_language');
            }
        }
        function handleProgramChange(value) {
            const programOther = document.getElementById('outbound-mobility_program_other');


            if (value === 'Other') {
                programOther.disabled = false;
            }else {
                programOther.disabled = true;
                clearInputById('outbound-mobility_program_other');
            }
        }

        // Function to clear inputs within a container
        function clearInputs(container) {
            const inputsToClear = container.querySelectorAll('input, select, textarea');
            inputsToClear.forEach(input => {
                input.value = '';
            });
        }
        function clearInputById(inputId) {
            const inputToClear = document.getElementById(inputId);
            if (inputToClear) {
                inputToClear.value = '';
            }
        }
    });


</script>


