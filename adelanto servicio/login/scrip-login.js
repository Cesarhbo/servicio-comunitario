document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Evita que la página se recargue

    // Capturamos los datos que el usuario escribió
    const email = document.getElementById('email').value.trim();
    const pass = document.getElementById('password').value;

    // Credencial de prueba
    const correoValido = "cesar@gmail.com";
    const passwordValido = "1234";

    // Comparamos los datos
    if (email === correoValido && pass === passwordValido) {
        // Guardamos el usuario en localStorage para compartir con la vista de inicio
        localStorage.setItem('userEmail', email);
        alert("¡Datos correctos! Redirigiendo...");
        // Redirigimos a la página de inicio (ruta relativa desde esta carpeta)
        window.location.href = "../../inicio-sesion/inicio.html";
    } else {
        alert("Correo o contraseña incorrectos. Intenta de nuevo.");
    }
});