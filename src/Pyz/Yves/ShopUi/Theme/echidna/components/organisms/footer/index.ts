import './footer.scss';

document.addEventListener('DOMContentLoaded', function () {
    const scrollButton = document.getElementById('scroll-to-top');
    if (scrollButton != null) {
        window.addEventListener('scroll', function () {
            if (window.scrollY > 0) {
                scrollButton.classList.add('show');
            } else {
                scrollButton.classList.remove('show');
            }
        });

        scrollButton.addEventListener('click', function () {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
});







