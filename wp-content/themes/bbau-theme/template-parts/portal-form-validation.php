<style>
.portal-form-validation-message {
    display: none;
    margin-top: .35rem;
    margin-bottom: 0;
}

.portal-form-validation-message.is-visible {
    display: block;
}

.portal-form-validation-message strong {
    margin-right: .25rem;
}

.vigilance-portal .form-control.is-invalid,
.vigilance-portal .form-select.is-invalid {
    border-color: #dc3545;
}
</style>

<script>

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.vigilance-portal form').forEach(function (form) {
        form.setAttribute('novalidate', 'novalidate');

        const message = document.createElement('div');
        message.className = 'invalid-feedback portal-form-validation-message';
        message.setAttribute('role', 'alert');
        message.setAttribute('aria-live', 'polite');

        form.addEventListener('submit', function (event) {
            if (form.checkValidity()) {
                return;
            }

            event.preventDefault();
            event.stopImmediatePropagation();

            const invalidField = form.querySelector(':invalid');
            if (!invalidField) {
                return;
            }

            form.querySelectorAll('.is-invalid').forEach(function (field) {
                field.classList.remove('is-invalid');
            });
            invalidField.classList.add('is-invalid');

            const fieldContainer = invalidField.closest('.mb-3, .mb-4, .col-md-6, .col-md-4');
            const fieldLabel = invalidField.labels && invalidField.labels[0]
                ? invalidField.labels[0]
                : fieldContainer && fieldContainer.querySelector('label');
            const label = fieldLabel
                ? fieldLabel.textContent.replace(/\*/g, '').replace(/\s+/g, ' ').trim()
                : (invalidField.name || 'This field');
            const validity = invalidField.validity;
            let reason = 'has an invalid value';

            if (validity.valueMissing) {
                reason = 'is required';
            } else if (validity.typeMismatch && invalidField.type === 'email') {
                reason = 'must be a valid email address';
            } else if (validity.tooShort || validity.tooLong || validity.patternMismatch) {
                const minLength = invalidField.getAttribute('minlength');
                const maxLength = invalidField.getAttribute('maxlength');
                if (minLength && maxLength && minLength === maxLength) {
                    const unit = invalidField.getAttribute('pattern') === '\\d{' + minLength + '}'
                        ? 'digits'
                        : 'characters';
                    reason = 'must be exactly ' + minLength + ' ' + unit;
                } else {
                    reason = 'does not match the required format';
                }
            }

            message.innerHTML = '<strong>Error:</strong> '
                + label + ' ' + reason + '.';
            if (fieldContainer) {
                fieldContainer.appendChild(message);
            } else {
                invalidField.insertAdjacentElement('afterend', message);
            }
            message.classList.add('is-visible');
            invalidField.focus({ preventScroll: true });
            invalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, true);

        form.addEventListener('input', function () {
            const invalidField = form.querySelector(':invalid');
            if (!invalidField) {
                message.classList.remove('is-visible');
                form.querySelectorAll('.is-invalid').forEach(function (field) {
                    field.classList.remove('is-invalid');
                });
            }
        });
    });
});
</script>
