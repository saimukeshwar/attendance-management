function validateForm() {
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var errorMsg = document.getElementById("errorMsg");

    if (email.trim() === "" || password.trim() === "") {
        errorMsg.textContent = "Please enter both email and password.";
        return false;
    }

    return true;
}
