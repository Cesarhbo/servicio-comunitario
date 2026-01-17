const btnMenu = document.getElementById('btnMenu');
const sidebar = document.getElementById('sidebar');
const content = document.getElementById('mainContent');

btnMenu.addEventListener('click', () => {
    // toggle añade la clase si no está, y la quita si ya está
    sidebar.classList.toggle('active');
    if (content) {
        content.classList.toggle('shifted');
    }
});