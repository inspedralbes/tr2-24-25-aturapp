document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    const button = form.querySelector('button[type="submit"]');
    const inputs = form.querySelectorAll('input, textarea');

    function checkFormCompletion() {
        let isValid = true;
        
        inputs.forEach(input => {
            if (!input.value) {
                isValid = false;
            }
        });

        button.disabled = !isValid;
    }

    inputs.forEach(input => {
        input.addEventListener('input', checkFormCompletion);
    });

    checkFormCompletion();
});