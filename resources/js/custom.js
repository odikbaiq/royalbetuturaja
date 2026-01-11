// Custom JavaScript extracted from blade views

// From resources/views/auth/register.blade.php
function togglePassword(fieldId, el) {
    const input = document.getElementById(fieldId);
    const icon = el.querySelector('i');

    if (input.type === "password") {
        input.type = "text";
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    } else {
        input.type = "password";
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    }
}

// From resources/views/customer/profile.blade.php
function togglePass(id) {
    const input = document.getElementById(id);
    const icon = document.getElementById(id + '_icon');

    if (input.type === 'password') {
        input.type = 'text';
        // Saat teks terlihat, gunakan mata terbuka
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    } else {
        input.type = 'password';
        // Saat teks tersembunyi, gunakan mata coret
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    }
}
