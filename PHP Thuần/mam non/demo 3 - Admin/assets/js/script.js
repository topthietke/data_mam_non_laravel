document.addEventListener('DOMContentLoaded', function () {

    // Hiệu ứng xuất hiện khi cuộn trang
    const faders = document.querySelectorAll('.aos-fade');
    const appearOnScroll = new IntersectionObserver(function (entries, observer) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15 });
    faders.forEach(el => appearOnScroll.observe(el));

    // Nút cuộn lên đầu trang
    const backToTop = document.getElementById('backToTop');
    if (backToTop) {
        window.addEventListener('scroll', function () {
            backToTop.style.display = window.scrollY > 400 ? 'flex' : 'none';
        });
        backToTop.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // Đổi màu nền navbar khi cuộn
    const navbar = document.getElementById('mainNavbar');
    if (navbar) {
        window.addEventListener('scroll', function () {
            navbar.classList.toggle('shadow-lg', window.scrollY > 30);
        });
    }

    // Tự động đóng menu mobile khi bấm 1 mục
    document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
        link.addEventListener('click', () => {
            const nav = document.getElementById('navbarNav');
            if (nav && nav.classList.contains('show')) {
                bootstrap.Collapse.getOrCreateInstance(nav).hide();
            }
        });
    });

    // Gửi form liên hệ bằng AJAX
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const btn = contactForm.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = 'Đang gửi...';

            const alertBox = document.getElementById('contactAlert');
            alertBox.classList.add('d-none');

            fetch('contact-process.php', {
                method: 'POST',
                body: new FormData(contactForm)
            })
            .then(res => res.json())
            .then(data => {
                alertBox.classList.remove('d-none', 'alert-success', 'alert-danger');
                alertBox.classList.add(data.success ? 'alert-success' : 'alert-danger');
                alertBox.textContent = data.message;
                if (data.success) contactForm.reset();
            })
            .catch(() => {
                alertBox.classList.remove('d-none', 'alert-success');
                alertBox.classList.add('alert-danger');
                alertBox.textContent = 'Có lỗi xảy ra, vui lòng thử lại sau.';
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = originalText;
            });
        });
    }
});
