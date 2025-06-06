let currentSlide = 0;
const slides = document.querySelectorAll('.slideBox');
const totalSlides = slides.length;

const userBtn = document.getElementById('user-btn');
const profileDropdown = document.querySelector('.profile');

userBtn.addEventListener('click', () => {
    profileDropdown.classList.toggle('active');
});

document.addEventListener('click', (event) => {
    if (!userBtn.contains(event.target) && !profileDropdown.contains(event.target)) {
        profileDropdown.classList.remove('active');
    }
});


function nextSlide() {
    slides[currentSlide].classList.remove('active');
    currentSlide = (currentSlide + 1) % totalSlides;
    slides[currentSlide].classList.add('active');
}

function prevSlide() {
    slides[currentSlide].classList.remove('active');
    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
    slides[currentSlide].classList.add('active');
}

document.addEventListener('DOMContentLoaded', () => {
    slides[0].classList.add('active');
});





document.querySelectorAll('.box').forEach(box => {
    box.addEventListener('mouseenter', () => {
        box.style.transform = 'scale(1.05)';
    });

    box.addEventListener('mouseleave', () => {
        box.style.transform = 'scale(1)';
    });
});


