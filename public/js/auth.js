/**
 * Authentication Logic for Royal Betutu Raja
 */

function toggleVisibility(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    } else {
        input.type = 'password';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    }
}

function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('bi-eye-slash');
        toggleIcon.classList.add('bi-eye');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('bi-eye');
        toggleIcon.classList.add('bi-eye-slash');
    }
}

 document.addEventListener('DOMContentLoaded', function () {
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const icon = document.querySelector('#toggleIcon');

        togglePassword.addEventListener('click', function () {
            // Ubah tipe input
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // Ubah icon (Bootstrap Icons)
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
        });
    });

    // Ganti bagian fetch di script Anda dengan ini:
fetch(`/admin/reservation/${id}/${actionMap[type].suffix}`, {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest' // Tambahkan ini
    }
})
.then(async res => {
    // Cek jika response bukan JSON (misal error 500 html)
    const contentType = res.headers.get("content-type");
    if (contentType && contentType.indexOf("application/json") !== -1) {
        return res.json();
    } else {
        throw new Error("Server tidak mengirimkan JSON");
    }
})
.then(data => {
    if(data.success) {
        Swal.fire('Berhasil!', data.message, 'success').then(() => location.reload());
    } else {
        Swal.fire('Gagal!', data.message || 'Terjadi kesalahan', 'error');
    }
})
.catch(err => {
    console.error(err);
    Swal.fire('Error!', 'Gagal memproses permintaan. Silakan cek koneksi atau log server.', 'error');
});
