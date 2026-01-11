

// Toggle Password
function togglePass(id) {
    const input = document.getElementById(id);
    const icon = document.getElementById(id + '_icon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    } else {
        input.type = 'password';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    }
}

// Preview profile picture
document.getElementById('profile_picture_input').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const avatar = document.getElementById('profile-avatar');
            if (avatar.tagName === 'IMG') {
                avatar.src = e.target.result;
            } else {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'avatar-circle mx-auto shadow-sm';
                img.id = 'profile-avatar';
                avatar.parentNode.replaceChild(img, avatar);
            }
        };
        reader.readAsDataURL(file);
    }
});

// Auto-hide alert
setTimeout(function() {
    let alertElement = document.querySelector('.alert');
    if (alertElement) {
        let bsAlert = new bootstrap.Alert(alertElement);
        bsAlert.close();
    }
}, 5000);
