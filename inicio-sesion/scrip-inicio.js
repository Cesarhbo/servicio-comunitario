window.addEventListener('DOMContentLoaded', function() {
	const email = localStorage.getItem('userEmail');
	const welcome = document.getElementById('welcomeMessage');

	// Si no hay usuario, volvemos al login
	if (!email) {
		window.location.href = '../adelanto servicio/login/login.html';
		return;
	}

	// Mostramos el correo en la pantalla de inicio
	if (welcome) {
		welcome.textContent = 'Has iniciado sesión correctamente.';
	}

	// Logout: limpiamos y redirigimos al login
	const logoutBtn = document.getElementById('logoutBtn');
	if (logoutBtn) {
		logoutBtn.addEventListener('click', function() {
			localStorage.removeItem('userEmail');
			window.location.href = '../adelanto servicio/login/login.html';
		});
	}

	// Botón para ir a la página principal
	const btnPrincipal = document.getElementById('btnPrincipal');
	if (btnPrincipal) {
		btnPrincipal.addEventListener('click', function() {
			window.location.href = '../pagina-principal/principal.html';
		});
	}
});
