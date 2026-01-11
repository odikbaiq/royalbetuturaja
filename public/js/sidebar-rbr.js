/**
 * Royal Betutu Raja Sidebar Scripts
 */
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('rbrSidebar');
    const toggleBtn = document.querySelector('[data-rbr-toggle]');

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            sidebar.classList.toggle('active');
        });
    }

    // Menutup sidebar jika klik di luar area sidebar pada layar mobile
    document.addEventListener('click', function(event) {
        const isClickInside = sidebar.contains(event.target);
        const isClickToggle = toggleBtn && toggleBtn.contains(event.target);

        if (!isClickInside && !isClickToggle && sidebar.classList.contains('active')) {
            sidebar.classList.remove('active');
        }
    });
});

/**
 * Royal Betutu Raja - Notification System
 */

function showRbrAlert(icon, title, text) {
    Swal.fire({
        icon: icon,
        title: title,
        text: text,
        timer: 3000,
        showConfirmButton: false,
        timerProgressBar: true,
        customClass: {
            popup: 'rbr-swal-popup',
        },
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
}

