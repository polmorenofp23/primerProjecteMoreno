// Show the toasts when page loaded
document.addEventListener('DOMContentLoaded', function () {
    var toastEls = Array.from(document.querySelectorAll('.toast'));
    toastEls.forEach(function (el) {
        var t = bootstrap.Toast.getOrCreateInstance(el);
        t.show();
    });
});

/*
 * Show a bootstrap toast with a plain text message.
 * Usage: showResponseToast('Saved successfully', { level: 'success', title: 'Saved', delay: 4000 })
 */
window.showResponseToast = function(message, opts = {}){
    if (!message) return;
    const { level = 'info', title = '', delay = 3000, bgClass = '', textClass = '' } = opts;

    let bg = bgClass, text = textClass;
    if (!bg && !text) {
        switch(level) {
            case 'success': bg = 'bg-success'; text = 'text-white'; break;
            case 'info': bg = 'bg-info'; text = 'text-white'; break;
            case 'warning': bg = 'bg-warning'; text = 'text-dark'; break;
            case 'danger': bg = 'bg-danger'; text = 'text-white'; break;
            default: bg = 'bg-light'; text = 'text-dark'; break;
        }
    }

    let container = document.querySelector('.bc-toast-container');
    if (!container) {
        container = document.createElement('div');
        container.className = 'toast-container bc-toast-container position-fixed top-0 end-0 p-3';
        container.style.zIndex = '1080';
        document.body.appendChild(container);
    }

    const toastId = 'bcToast' + Date.now() + Math.floor(Math.random()*1000);
    const toast = document.createElement('div');
    toast.id = toastId;
    toast.className = `toast align-items-center ${bg} border-0`;
    toast.setAttribute('role','alert');
    toast.setAttribute('aria-live','assertive');
    toast.setAttribute('aria-atomic','true');
    toast.dataset.bsDelay = String(delay);

    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body ${text}">
                ${ title ? `<strong>${escapeHtml(title)}:</strong> ` : '' }${escapeHtml(message)}
            </div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>`;

    container.appendChild(toast);

    const bsToast = new bootstrap.Toast(toast, { delay: delay });
    bsToast.show();
    toast.addEventListener('hidden.bs.toast', () => toast.remove());
};

// small helper to escape text for insertion into innerHTML
function escapeHtml(str){
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}