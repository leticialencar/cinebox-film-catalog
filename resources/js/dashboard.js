window.scrollCarousel = function(direction) {
    const container = document.getElementById('carousel');
    container.scrollBy({ left: direction * 300, behavior: 'smooth' });
}

window.scrollTopRated = function(direction) {
    const container = document.getElementById('toprated-carousel');
    container.scrollBy({ left: direction * 300, behavior: 'smooth' });
}

window.scrollUpcoming = function(direction) {
    const container = document.getElementById('upcoming-carousel');
    container.scrollBy({ left: direction * 500, behavior: 'smooth' });
}