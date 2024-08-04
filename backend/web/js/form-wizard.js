const nextButton = document.querySelector('.btn-next');
const prevButton = document.querySelector('.btn-prev');
const steps = document.querySelectorAll('.step');
const form_steps = document.querySelectorAll('.form-step');

let active = 1;

nextButton.addEventListener('click', () => {
    active++;
    if (active > steps.length) {
        active = steps.length;
    }
    updateProgress();
});

prevButton.addEventListener('click', () => {
    active--;
    if (active < 1) {
        active = 1;
    }
    updateProgress();
});

// Add click event listener to each step
steps.forEach((step, index) => {
    step.addEventListener('click', () => {
        active = index + 1;
        updateProgress();
    });
});

const updateProgress = () => {
    steps.forEach((step, i) => {
        if (i == (active - 1)) {
            // Add 'active' class to the current step and form step
            step.classList.add('active');
            form_steps[i].classList.add('active');
        } else {
            // Remove 'active' class from other steps and form steps
            step.classList.remove('active');
            form_steps[i].classList.remove('active');
        }
    });
    if (active === 1) {
        prevButton.disabled = true;
    } else if (active === steps.length) {
        nextButton.disabled = true;
    } else {
        prevButton.disabled = false;
        nextButton.disabled = false;
    }
};

// jQuery validation error handling
$('#create-form').on('afterValidate', function (event, messages) {
    var formSteps = $('.form-step');
    for (var i = 0; i < formSteps.length; i++) {
        var step = formSteps[i];
        var hasError = $(step).find('.has-error').length > 0;
        if (hasError) {
            active = i + 1;
            updateProgress();
            break;
        }
    }
});

document.addEventListener('DOMContentLoaded', function () {
    // Select all form fields with aria-invalid="true"
    const invalidFields = document.querySelectorAll('[aria-invalid="true"]');

    invalidFields.forEach(function (field) {
        // Remove aria-invalid attribute and hide .help-block on focus
        field.addEventListener('focus', function () {
            field.removeAttribute('aria-invalid');
            hideHelpBlock(field);
        });

        // Remove aria-invalid attribute and hide .help-block on input or change
        const eventType = (field.tagName === 'SELECT' || field.type === 'file') ? 'change' : 'input';
        field.addEventListener(eventType, function () {
            field.removeAttribute('aria-invalid');
            hideHelpBlock(field);
        });
    });

    // Function to hide .help-block associated with the field
    function hideHelpBlock(field) {
        const formGroup = field.closest('.form-group');
        if (formGroup) {
            const helpBlock = formGroup.querySelector('.help-block');
            if (helpBlock) {
                helpBlock.style.display = 'none';
            }
        }
    }
});
