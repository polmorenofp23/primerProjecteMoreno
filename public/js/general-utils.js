// Show the toasts when page loaded
document.addEventListener('DOMContentLoaded', function () {
    var toastEls = Array.from(document.querySelectorAll('.toast'));
    toastEls.forEach(function (el) {
        var t = bootstrap.Toast.getOrCreateInstance(el);
        t.show();
    });
});