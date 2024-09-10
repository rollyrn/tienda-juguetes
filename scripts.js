document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.getElementById('loginForm');
    const username = document.getElementById('username');
    const password = document.getElementById('password');
    const usernameError = document.getElementById('usernameError');
    const passwordError = document.getElementById('passwordError');

    // Validación en tiempo real
    username.addEventListener('input', function () {
        if (username.value.trim() === '') {
            usernameError.textContent = 'El nombre de usuario es obligatorio.';
        } else {
            usernameError.textContent = '';
        }
    });

    password.addEventListener('input', function () {
        const passwordValue = password.value;
        if (passwordValue.length < 8) {
            passwordError.textContent = 'La contraseña debe tener al menos 8 caracteres.';
        } else if (!/[A-Z]/.test(passwordValue)) {
            passwordError.textContent = 'La contraseña debe incluir al menos una letra mayúscula.';
        } else if (!/[0-9]/.test(passwordValue)) {
            passwordError.textContent = 'La contraseña debe incluir al menos un número.';
        } else if (!/[!@#$%^&*]/.test(passwordValue)) {
            passwordError.textContent = 'La contraseña debe incluir al menos un carácter especial (!@#$%^&*).';
        } else {
            passwordError.textContent = '';
        }
    });

    // Validación al enviar el formulario
    loginForm.addEventListener('submit', function (event) {
        event.preventDefault(); // Evita que el formulario se envíe sin validación
        if (username.value.trim() !== '' && password.value.length >= 8 && 
            /[A-Z]/.test(password.value) && /[0-9]/.test(password.value) && /[!@#$%^&*]/.test(password.value)) {
            alert('Inicio de sesión exitoso');
        } else {
            alert('Por favor, corrige los errores en el formulario.');
        }
    });
});