document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('#rating-stars .star-rating');
    const ratingInput = document.getElementById('rating-input');
    const ratingText = document.getElementById('rating-text');
    let currentRating = 0;

    const ratingTexts = {
        1: 'Sangat Buruk',
        2: 'Buruk',
        3: 'Cukup',
        4: 'Baik',
        5: 'Sangat Baik'
    };

    function updateStars(rating) {
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.remove('far');
                star.classList.add('fas', 'selected');
            } else {
                star.classList.remove('fas', 'selected');
                star.classList.add('far');
            }
        });
    }

    stars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = parseInt(this.getAttribute('data-rating'));
            currentRating = rating;
            ratingInput.value = rating;
            ratingText.textContent = ratingTexts[rating];
            updateStars(rating);
        });

        star.addEventListener('mouseover', function() {
            const rating = parseInt(this.getAttribute('data-rating'));
            updateStars(rating);
            ratingText.textContent = ratingTexts[rating];
        });

        star.addEventListener('mouseout', function() {
            updateStars(currentRating);
            if (currentRating) {
                ratingText.textContent = ratingTexts[currentRating];
            } else {
                ratingText.textContent = 'Pilih rating';
            }
        });
    });

    // Initialize
    updateStars(currentRating);
});
