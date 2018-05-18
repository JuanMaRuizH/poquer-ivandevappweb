var hasError = function (field) {
    var error = "";
    // Don't validate submits, buttons, file and reset inputs, and disabled fields
    if (field.disabled || field.type === 'file' || field.type === 'reset' || field.type === 'submit' || field.type === 'button') return;
    // Get validity
    var validity = field.validity;
    // If valid, return null
    if (validity.valid) {
        field.classList.remove('is-invalid');
        field.classList.add('is-valid');
        return;
    }
    // If field is required and empty

    if (validity.valueMissing) { $error = 'Debe rellenar este campo'; }
    // If pattern doesn't match
    else if (validity.patternMismatch) {
        // If pattern info is included, return custom error
        $error = field.getAttribute('title') || 'Por favor usa el siguiente formato.';
    }
    // If all else fails, return a generic catchall error
    else {
        $error = 'El valor introducido en este campo no es válido.';
    }
    return $error;
};
var showError = function (field, error) {
    field.classList.add('is-invalid');
    var id = field.id || field.name;
    if (!id) return;
    var message = field.form.querySelector('.invalid-feedback#error-for-' + id);
    if (message) message.innerHTML = error;
};

(function () {
    'use strict';

    window.addEventListener('load', function () {
        var form = document.querySelector('.validate');
        form.setAttribute('novalidate', true);
        form.addEventListener('blur', function (event) {
            var error = hasError(event.target);
            if (error) {
                showError(event.target, error);
            }
        }, true);
        form.addEventListener('invalid', function (event) {
            var error = hasError(event.target);
            if (error) {
                showError(event.target, error);
            }
        }, true);
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });

    });
})();