/**
 * Toggle visibility of a password input field.
 * Also toggles a sibling Bootstrap Icons eye/eye-slash if present.
 *
 * @param {string} fieldId - id of the input element to toggle
 */
function togglePassword(fieldId) {
	try {
		const field = document.getElementById(fieldId);
		if (!field) return;
		const isPwd = field.type === 'password';
		field.type = isPwd ? 'text' : 'password';

		// Try to find an icon inside the same input-group sibling and toggle classes
		const inputGroup = field.closest('.input-group');
		if (inputGroup) {
			const icon = inputGroup.querySelector('.input-group span i'); // , .input-group-text i
			if (icon) {
				if (isPwd) {
					icon.classList.remove('bi-eye');
					icon.classList.add('bi-eye-slash');
				} else {
					icon.classList.remove('bi-eye-slash');
					icon.classList.add('bi-eye');
				}
			}
		}
	} catch (e) {
		console.error('togglePassword error', e);
	}
}

window.togglePassword = togglePassword;     // Expose for older browsers