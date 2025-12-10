document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menu-toggle');
    const navLinks = document.querySelector('.nav-links');

    // Toggle menu di tampilan mobile
    menuToggle.addEventListener('click', function() {
        navLinks.classList.toggle('active');
        const icon = menuToggle.querySelector('i');
        // Mengganti icon dari bars menjadi times (close)
        if (navLinks.classList.contains('active')) {
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-times');
        } else {
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
        }
    });

    // Menutup menu saat link di klik (hanya relevan di mobile)
    navLinks.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 768) {
                navLinks.classList.remove('active');
                document.getElementById('menu-toggle').querySelector('i').classList.remove('fa-times');
                document.getElementById('menu-toggle').querySelector('i').classList.add('fa-bars');
            }
        });
    });
}); 