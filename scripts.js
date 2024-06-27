document.getElementById('addEmployeeForm').addEventListener('submit', function(event) {
    const form = event.target;
    const passwordField = form.querySelector('input[name="password"]');
    const confirmPasswordField = form.querySelector('input[name="confirmPassword"]');

    if (passwordField.value !== confirmPasswordField.value) {
        alert('Passwords do not match');
        event.preventDefault(); // Prevent form submission
    }
});
