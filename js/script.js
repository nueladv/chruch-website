// Smooth Scroll to Top
const scrollToTopButton = document.getElementById('scroll-to-top');

window.onscroll = function() {
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
        scrollToTopButton.style.display = "block";
    } else {
        scrollToTopButton.style.display = "none";
    }
};

// Scroll to top functionality
scrollToTopButton.addEventListener('click', function() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

// Form Validation (simple)
const form = document.querySelector('form');
form.addEventListener('submit', function(e) {
    const title = form.querySelector('input[name="judul"]').value;
    const description = form.querySelector('textarea[name="deskripsi"]').value;
    const image = form.querySelector('input[type="file"]').value;

    if (!title || !description || !image) {
        alert("Semua kolom harus diisi!");
        e.preventDefault();  // Prevent form submission
    }
});
