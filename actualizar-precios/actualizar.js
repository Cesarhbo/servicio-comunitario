// Estructura unificada en localStorage bajo la clave 'registroGas'
let registro = null;

function loadRegistro() {
    const raw = localStorage.getItem('registroGas');
    if (raw) {
        registro = JSON.parse(raw);
        // Compatibilidad: si no existe la sección de pagos en jornadaActual, crearla
        registro.jornadaActual = registro.jornadaActual || { fecha: null, filas: [], totales: { c10:0,c18:0,c43:0,general:0 }, pagos: [] };
        registro.precios = registro.precios || { "10": 10.00, "18": 18.00, "43": 40.00 };
    } else {
        registro = {
            precios: { "10": 10.00, "18": 18.00, "43": 40.00 },
            jornadas: [],
            jornadaActual: { fecha: null, filas: [], totales: { c10:0,c18:0,c43:0,general:0 }, pagos: [] }
        };
        localStorage.setItem('registroGas', JSON.stringify(registro));
    }
}

function saveRegistro() {
    localStorage.setItem('registroGas', JSON.stringify(registro));
}

// Actualizar precio base (solo modifica precios)
function actualizarPrecio() {
    const tipo = document.getElementById('tipoGas').value;
    const nuevoPrecio = parseFloat(document.getElementById('nuevoPrecio').value);

    if (nuevoPrecio > 0) {
        registro.precios[tipo] = nuevoPrecio;
        // Guardar entrada en el historial de precios
        registro.historialPrecios = registro.historialPrecios || [];
        registro.historialPrecios.push({ tipo, precio: nuevoPrecio, fecha: new Date().toLocaleString() });
        saveRegistro();
        renderPrecios();
        renderHistorialPrecios();
        alert(`Precio de ${tipo}kg actualizado a Bs ${nuevoPrecio.toFixed(2)}`);
    } else {
        alert("Ingresa un precio válido en Bs");
    }
}

// Mostrar precios actuales
function renderPrecios() {
    const visor = document.getElementById('listaPrecios');
    const p = registro.precios;
    visor.innerHTML = `
        <span>10kg: Bs ${p["10"].toFixed(2)}</span> | 
        <span>18kg: Bs ${p["18"].toFixed(2)}</span> | 
        <span>43kg: Bs ${p["43"].toFixed(2)}</span>
    `;
}

function renderHistorialPrecios() {
    const cont = document.getElementById('historialPrecios');
    cont.innerHTML = '';
    const h = registro.historialPrecios || [];
    if (h.length === 0) {
        cont.innerHTML = '<em>No hay actualizaciones registradas.</em>';
        return;
    }
    // Mostrar las últimas 20 actualizaciones (más recientes primero)
    h.slice().reverse().slice(0,20).forEach(item => {
        const div = document.createElement('div');
        div.className = 'hist-item';
        div.innerText = `${item.fecha} — ${item.tipo}kg: Bs ${Number(item.precio).toFixed(2)}`;
        cont.appendChild(div);
    });
}
// Inicializar (solo precios)
// Inicializar
loadRegistro();
renderPrecios();
renderHistorialPrecios();