const stars = document.querySelectorAll('#starContainer .star');
const ratingInput = document.getElementById('ratingInput');

function setStars(value) {
    stars.forEach((star, idx) => {
        const half = star.querySelector('.half');
        if (value >= idx + 1) {
            half.style.width = '100%';
        } else if (value >= idx + 0.5) {
            half.style.width = '50%';
        } else {
            half.style.width = '0';
        }
    });
}

setStars((parseFloat(ratingInput.value) || 0) / 2);

stars.forEach((star, idx) => {
    star.addEventListener('click', e => {
        const rect = star.getBoundingClientRect();
        const x = e.clientX - rect.left;
        let value = idx + 1;
        if (x < rect.width / 2) value -= 0.5;
        ratingInput.value = value * 2; 
        setStars(value);
    });

    star.addEventListener('mousemove', e => {
        const rect = star.getBoundingClientRect();
        const x = e.clientX - rect.left;
        let hoverValue = idx + 1;
        if (x < rect.width / 2) hoverValue -= 0.5;
        setStars(hoverValue);
    });
});

document.getElementById('starContainer').addEventListener('mouseleave', () => {
    setStars((parseFloat(ratingInput.value) || 0) / 2); 
});