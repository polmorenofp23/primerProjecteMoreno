/**
 * Toggle visibility of a password input field and the eye icon
 *
 * @param {string} fieldId - id of the input element to toggle
 */
function togglePassword(fieldId, btn) {
	try {
		const field = document.getElementById(fieldId);
		if (!field) return;
		const isPwd = field.type === 'password';
		field.type = isPwd ? 'text' : 'password';

		if (btn && btn.querySelector) {
			const icon = btn.querySelector('i');
			if (icon) {
				icon.classList.toggle('bi-eye');
				icon.classList.toggle('bi-eye-slash');
			}
		}
	} catch (e) {
		console.error('togglePassword error', e);
	}
}

function validateForm(e) {

	let form = null;
	if (e && e.currentTarget && e.currentTarget.tagName === 'FORM') {
		form = e.currentTarget;
	} else if (e && e.target && e.target.closest) {
		form = e.target.closest('form') || document.querySelector('.form-card form');
	} else if (e && e.tagName === 'FORM') {
		form = e;
	} else {
		form = document.querySelector('.form-card form');
	}

	if (!form) return true;

	const fields = form.querySelectorAll('input[required], textarea[required], select[required]');
	let firstInvalid = null;

	fields.forEach(function (field) {
		const group = field.closest('.form-group');
		let feedbackDiv = group ? group.querySelector('.input-feedback') : null;

		if (!feedbackDiv && group) {
			feedbackDiv = document.createElement('div');
			feedbackDiv.className = 'input-feedback';
			group.appendChild(feedbackDiv);
		}

		if (feedbackDiv) feedbackDiv.innerHTML = '';

		if (!field.checkValidity()) {
			const message = field.validity.valueMissing ? 'This field is required.' : 'Invalid field value.';

			if (feedbackDiv) {
				feedbackDiv.innerHTML = '<p class="mb-0">' + escapeHtml(message) + '</p>';
			}
			if (!firstInvalid) firstInvalid = field;
		}
	});

	if (firstInvalid) {
		if (e && e.preventDefault) e.preventDefault();
		firstInvalid.focus();
		return false;
	}

	return true;
}

/** HELPERS */
// helper to escape text for insertion
function escapeHtml(str) {
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/\"/g, '&quot;')
        .replace(/'/g, '&#39;');
}