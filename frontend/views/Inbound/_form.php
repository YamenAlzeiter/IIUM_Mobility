<?php

use common\helpers\addInboundCourses;
use common\models\Country;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Inbound $model */
/** @var common\models\InboundHostUniversityCourses $modelsCourses*/
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
                <div class="col-lg-6">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder'=> ''])?>
                </div>
                <div class="col-lg-6">
                    <?= $form->field($model, 'gender',)->dropDownList(['Male' => 'Male', 'Female' => 'Female'], ['prompt' => 'Select Gender']) ?>
                </div>
                <div class="col-lg-6">
                    <?= $form->field($model, 'relation_ship')->dropDownList(['Single' => 'Single', 'Married' => 'Married'], ['Prompt' => 'Select Status']) ?>
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
                <div class = "col-lg-6">
                    <?= $form->field($model, 'religion')->textInput(['maxlength' => true, 'placeholder' => ''])?>
                </div>
                <div class = "col-lg-6">
                    <?= $form->field($model, 'mazhab')->textInput(['maxlength' => true, 'placeholder' => ''])?>
                </div>
                <div class = "col-lg-3">
                    <?= $form->field($model, 'citizenship')
                        ->dropDownList(ArrayHelper::map(Country::find()->all(), 'nationality', 'nationality'),
                            ['prompt' => 'Select Nationality'])?>
                </div>
                <div class = "col-lg-3">
                    <?= $form->field($model, 'country')
                        ->dropDownList(ArrayHelper::map(Country::find()->all(), 'name', 'name'),
                            ['prompt' => 'Select Country'])?>
                </div>
                <div class = "col-lg-3">
                    <?= $form->field($model, 'country_of_origin')
                        ->dropDownList(ArrayHelper::map(Country::find()->all(), 'name', 'name'),
                            ['prompt' => 'Select Country'])?>
                </div>
                <div class = "col-lg-3">
                    <?= $form->field($model, 'country_of_residence')
                        ->dropDownList(ArrayHelper::map(Country::find()->all(), 'name', 'name'),
                            ['prompt' => 'Select Country'])?>
                </div>
                <div class = "col-lg-8">
                    <?= $form->field($model, 'permanent_address')->textarea(['maxlength' => true, 'placeholder' => ''])?>
                </div>
                <div class = "col-lg-4">
                    <?= $form->field($model, 'post_code')->textInput(['maxlength' => true, 'placeholder' => ''])?>
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
        <div class = "col-lg-6">
            <?= $form->field($model, 'emergency_country')
                ->dropDownList(ArrayHelper::map(Country::find()->all(), 'name', 'name'),
                    ['prompt' => 'Select Country'])?>
        </div>
        <div class = "col-lg-6">
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
            <?= $form->field($model, 'academic_home_university')->textInput(['maxlength' => true, 'placeholder' => ''])?>
        </div>
        <div class = "col-lg-6">
            <?= $form->field($model, 'academic_education_lvl')
                ->dropDownList([
                    'Diploma' => 'Diploma',
                    'Degree' => 'Degree',
                    'Master' => 'Master',
                    'PhD' => 'PhD'],
                    ['prompt' => 'Select Level of Education']) ?>
        </div>
        <div class = "col-lg-6">
            <?= $form->field($model, 'academic_program_name')->textInput(['maxlength' => true, 'placeholder' => ''])?>
        </div>
        <div class = "col-lg-6">
            <?= $form->field($model, 'academic_faculty_name')->textInput(['maxlength' => true, 'placeholder' => ''])?>
        </div>
        <div class = "col-lg-3">
            <?= $form->field($model, 'academic_semester')
                ->dropDownList(array_combine(range(1, 10),
                    array_map(function ($i) {
                        return "Semester  $i";
                        }, range(1, 10))),
                    ['prompt' => 'Select Semester']) ?>
        </div>
        <div class = "col-lg-3">
            <?= $form->field($model, 'academic_year')
                ->dropDownList(array_combine(range(1, 6),
                    array_map(function ($i) {
                        return "Year  $i";
                    }, range(1, 6))),
                    ['prompt' => 'Select Year']) ?>
        </div>

        <div class = "col-lg-3">
            <?= $form->field($model, 'academic_result')->textInput(['maxlength' => true, 'placeholder' => ''])?>
        </div>
        <div class = "col-lg-3">
            <?= $form->field($model, 'memorandum_of_agreement')->dropDownList(['Yes' => 'Yes', 'No' => 'NO', 'prompt' => 'Select One' ]) ?>
        </div>
        <div class = "col-lg-12">
            <?= $form->field($model, 'academic_research_title')->textarea(['maxlength' => true, 'placeholder' => ''])?>
        </div>

        <h2 class="mt-2"><i class="ti ti-language fw-bold"></i>English Proficiency</h2>
        <div class = "col-lg-12">
            <?= $form->field($model, 'language_is_native_english')->dropDownList(['Yes' => 'Yes', 'No' => 'NO'], ['id' => 'language', 'prompt' => 'Select One']) ?>
        </div>
            <p class="mb-0 fs-4">please indicate any English Language Proficiency Test you have taken and upload the result</p>
            <div class = "col-lg-6">
                <?= $form->field($model, 'language_english_test_name')
                    ->dropDownList([
                        'TOFEL' => 'TOFEL',
                        'IELTS' => 'IELTS',
                        'Other' => 'Other'
                    ], ['prompt' => 'Select Test', 'id' => 'english-test']) ?>
            </div>
            <div class = "col-lg-6">
                <?= $form->field($model, 'language_english_test_name_other')->textInput(['maxlength' => true, 'placeholder' => 'Other', 'disabled' => true])->label(' ')?>
            </div>
            <div class = "col-lg-6">
                <?= $form->field($model, 'f_language_english_certificate_file', ['template' => $templateFileInput])->fileInput()?>
            </div>
        </div>
</div>
<div class="form-step">
    <h2><i class="ti ti-school fw-bold"></i> title</h2>
    <div class="row">
        <div class = "col-lg-6">
            <?= $form->field($model, 'propose_program_type')
                ->dropDownList([
                    'Exchange Program (1 or 2 semesters)' => 'Exchange Program (1 or 2 semesters)',
                    'Erasmus Exchange Program' => 'Erasmus Exchange Program',
                    'Mevlana Exchange Program' => 'Research Program',
                    'Internship Programme' => 'Internship Programme', 'Summer Program' => 'Summer Program',
                    'Short Visiting Programme' => 'Short Visiting Programme',
                    'University Mobility in Asia and the Pacific (UMAP) Programme' => 'University Mobility in Asia and the Pacific (UMAP) Programme',
                    'Other' => 'Other',
                ], ['prompt' => 'Select Programme', 'id' => 'programme-type']) ?>
        </div>
        <div class = "col-lg-6">
            <?= $form->field($model, 'propose_program_type_other')->textInput(['maxlength' => true, 'placeholder' => 'Other', 'disabled' => true])->label('')?>
        </div>
        <div class = "col-lg-3">
            <?= $form->field($model, 'propose_mobility_type')
                ->dropDownList([
                    'Physical' => 'Physical',
                    'Virtual' => 'Virtual'
                ], ['prompt' => 'Select Mobility Type']) ?>
        </div>
        <div class = "col-lg-3">
            <?= $form->field($model, 'propose_transform_credit_hours')
                ->dropDownList([
                    'Yes' => 'Yes',
                    'No' => 'No'
                ], ['prompt' => 'Select One']) ?>
        </div>
        <div class = "col-lg-6">
            <?= $form->field($model, 'propose_kulliyyah_applied')->textInput(['maxlength' => true, 'placeholder' => ''])?>
        </div>
        <div class = "col-lg-6">
            <?= $form->field($model, 'propose_duration_start')->textInput(['type' => 'date', 'placeholder' => ''])?>
        </div>
        <div class = "col-lg-6">
            <?= $form->field($model, 'propose_duration_end')->textInput(['type' => 'date', 'placeholder' => ''])?>
        </div>


            <div class="col-lg-10"><h2 class="mt-2"><i class="ti ti-book-2 fw-bold"></i> Courses offered by Host University</h2></div>
            <div class="col-lg-2 text-end align-self-center"><button type="button" class="wizard-btn-add" id="add-course-button"><i class="ti ti-plus fs-7"></i></button></div>

        <div id="course-container" class="col-lg-12" >
            <?php  if(! empty($modelsCourses)){
             foreach ($modelsCourses as $index => $modelCourse){
                  $addCourses->initCourses($form, $modelCourse, $index, 'host');
              }
            } ?>
        </div>




    </div>
</div>
<div class="form-step">
    <h2><i class="ti ti-moneybag fw-bold"></i>Financial</h2>
    <div class="row">
        <div class = "col-lg-12">
            <?= $form->field($model, 'financial_accommodation_in_campus')
                ->dropDownList([
                    'Yes' => 'Yes',
                    'No' => 'No'
                ], ['prompt' => 'Select One', 'id' => 'accommodation-option']) ?>
        </div>
        <div id="accommodation" class="d-none row">
            <div class = "col-lg-6">
                <?= $form->field($model, 'campus_location')->dropDownList([
                    "Main Campus, IIUM Gombak" => "Main Campus, IIUM Gombak",
                    "Kuantan Campus, IIUM Kuantan" => "Kuantan Campus, IIUM Kuantan",
                    "Pagoh Campus, IIUM Pagoh" => "Pagoh Campus, IIUM Pagoh",
                ], [
                    'prompt' => 'Select One',
                    'id' => 'campus']) ?>
            </div>
            <div class = "col-lg-6">
                <?= $form->field($model, 'room_type')
                    ->dropDownList([
                        "Single Room(for PG Students) RM360/Month" => "Single Room(for PG Students) RM360/Month",
                        "Quad Room(for UG Students) RM360/Month" => "Quad Room(for UG Students) RM360/Month",
                    ], [
                        'prompt' => 'Select Room Type',
                        'id' => 'room']) ?>
            </div>
        </div>
        <div class = "col-lg">
            <?= $form->field($model, 'financial_funding')
                ->dropDownList([
                    'Self-sponsor' => 'Self-sponsor',
                    'Scholarship' => 'Scholarship',
                    'Other' => 'Other',
                    ], ['prompt' => 'Select Financial Funding', 'id' => 'funding']) ?>
        </div>

            <div id = "funding_other" class = "col-lg-6 d-none">
                <?= $form->field($model, 'financial_funding_other')->textInput(['maxlength' => true, 'placeholder' => ''])?>
            </div>

        <div id = "funding_scholarship" class = "row d-none">
            <div class = "col-lg-6"><?= $form->field($model, 'sponsor_name')->textInput(['maxlength' => true, 'placeholder' => '']) ?></div>
            <div class = "col-lg-6"><?= $form->field($model, 'sponsor_amount')->textInput(['maxlength' => true, 'placeholder' => '']) ?></div>
        </div>
    </div>
</div>
<div class="form-step">
    <h2><i class="ti ti-moneybag fw-bold"></i>PIC Details</h2>
    <div class="row">
        <div class = "col-lg-6">
            <?= $form->field($model, 'home_university_pic_name')->textInput(['maxlength' => true, 'placeholder' => '']) ?>
        </div>
        <div class = "col-lg-6">
            <?= $form->field($model, 'home_university_pic_email')->textInput(['maxlength' => true, 'placeholder' => '']) ?>
        </div>
        <div class = "col-lg-6">
            <?= $form->field($model, 'home_university_pic_mobile_number')->textInput(['maxlength' => true, 'placeholder' => '']) ?>
        </div>
        <div class = "col-lg-6">
            <?= $form->field($model, 'home_university_pic_position')->textInput(['maxlength' => true, 'placeholder' => '']) ?>
        </div>
        <div class = "col-lg-6">
            <?= $form->field($model, 'home_university_approval_date')->textInput(['type' => 'date', 'placeholder' => '']) ?>
        </div>

        <div class = "col-lg-6">
            <?= $form->field($model, 'f_recommendation_letter_file', ['template' => $templateFileInput])->fileInput()?>
        </div>
    </div>
</div>
<div class="form-step step__last">
    <h2><i class="ti ti-file fw-bold"></i>Files & Agreement</h2>
    <div class="row">
        <div class = "col-lg-6"> <?= $form->field($model, 'f_passport_file', ['template' => $templateFileInput])->fileInput()?></div>
        <div class = "col-lg-6"> <?= $form->field($model, 'f_latest_passport_photo_file', ['template' => $templateFileInput])->fileInput()?></div>
        <div class = "col-lg-6"> <?= $form->field($model, 'f_latest_academic_transcript_file', ['template' => $templateFileInput])->fileInput()?></div>
        <div class = "col-lg-6"> <?= $form->field($model, 'f_confirmation_letter_file', ['template' => $templateFileInput])->fileInput()?></div>
        <div class = "col-lg-6"> <?= $form->field($model, 'f_sponsorship_letter_file', ['template' => $templateFileInput])->fileInput()?></div>
        <div class="col-lg-12">
            <?= $form->field($model, 'agreement')->checkbox([
                'label' => '<p class="text-dark mb-3">I agree on the <a class="link text-decoration-underline" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"> Terms and Conditions</a></p> ',
                'encode' => false
            ])->label(false) ?>

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
<!--        <button type="button" class="btn-save">Save</button>-->
<!--        <button type="button" class="btn-submit">Submit</button>-->
    </div>
</div>

    <?php ActiveForm::end(); ?>


<script>
    $(document).ready(function() {
        $('#add-course-button').on('click', function() {
            var courseIndex = $('#course-container .course-row').length;
            if (courseIndex < 7) {
                var newRow = `<?php $addCourses->addCourses($form, $modelCourse, '[courseIndex]', 'host');?>`;
                newRow = newRow.replace(/\[courseIndex\]/g, courseIndex);
                newRow = newRow.replace(/InboundHostUniversityCourses\d*\[course_/g, 'InboundHostUniversityCourses[' + courseIndex + '][course_');
                newRow = newRow.replace(/id="inboundhostuniversitycourses-courseindex/g, 'id="inboundhostuniversitycourses-' + courseIndex);
                newRow = newRow.replace(/field-inboundhostuniversitycourses-courseindex/g, 'field-inboundhostuniversitycourses-' + courseIndex);

                $('#course-container').append(newRow);
                $('#course-container').find('.course-row:last input[type="text"]').val('');
            } else {
                Swal.fire({
                    title: "Oops...!",
                    text: "You Can't Add More than 7 Courses.",
                    icon: "error",
                });
            }
        });

        $(document).on('click', '.remove-course-button', function() {
            var index = $(this).data('index');
            // Adjust the selector if needed
            $('#course-row-' + index).remove();
        });
    });



    document.addEventListener('DOMContentLoaded', function () {
        // Initialize elements based on server-side state or defaults
        initializeFormState();

        // Event listeners for dynamic form interactions
        setupEventListeners();

        // Function to initialize form elements based on server-side state
        function initializeFormState() {
            const accommodationOption = document.getElementById('accommodation-option');
            const accommodationContainer = document.getElementById('accommodation');

            // Check initial state of accommodation option
            if (accommodationOption.value === 'Yes') {
                accommodationContainer.classList.remove('d-none');
            } else {
                accommodationContainer.classList.add('d-none');
            }

            // Initialize other form elements based on their initial state or server-side data
            // For example, initialize funding options based on server-side values
            const funding = document.getElementById('funding');
            handleFundingChange(funding.value); // Example function to handle funding option change
        }

        // Function to setup event listeners for dynamic form interactions
        function setupEventListeners() {
            const accommodationOption = document.getElementById('accommodation-option');
            const funding = document.getElementById('funding');
            const english = document.getElementById('english-test');
            const program = document.getElementById('programme-type');

            // Event listener for accommodation option change
            accommodationOption.addEventListener('change', function () {
                const accommodationContainer = document.getElementById('accommodation');

                if (this.value === 'Yes') {
                    accommodationContainer.classList.remove('d-none');
                } else {
                    accommodationContainer.classList.add('d-none');
                    clearInputs(accommodationContainer);
                }
            });

            // Event listener for funding option change
            funding.addEventListener('change', function () {
                handleFundingChange(this.value);
            });
            english.addEventListener('change', function (){
                handleEnglishChange(this.value);
            })
            program.addEventListener('change', function (){
                handleEnglishChange(this.value);
            })
        }

        // Function to handle changes in funding options
        function handleFundingChange(value) {
            const fundingOther = document.getElementById('funding_other');
            const fundingScholarship = document.getElementById('funding_scholarship');

            if (value === 'Other') {
                fundingOther.classList.remove('d-none');
                fundingScholarship.classList.add('d-none');
                clearInputs(fundingScholarship);
            } else if (value === 'Scholarship') {
                fundingScholarship.classList.remove('d-none');
                fundingOther.classList.add('d-none');
                clearInputs(fundingOther);
            } else {
                fundingOther.classList.add('d-none');
                fundingScholarship.classList.add('d-none');
                clearInputs(fundingOther);
                clearInputs(fundingScholarship);
            }
        }
        function handleEnglishChange(value) {
            const EnglishOther = document.getElementById('inbound-language_english_test_name_other');


            if (value === 'Other') {
                EnglishOther.disabled = false;
            }else {
                EnglishOther.disabled = true;
                clearInputById('inbound-language_english_test_name_other');
            }
        }  function handleEnglishChange(value) {
            const proposeOther = document.getElementById('inbound-propose_program_type_other');


            if (value === 'Other') {
                proposeOther.disabled = false;
            }else {
                proposeOther.disabled = true;
                clearInputById('inbound-propose_program_type_other');
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
