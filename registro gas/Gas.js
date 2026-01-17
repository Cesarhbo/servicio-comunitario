let jornadas = [];
let jornadaActual = { fecha: null, filas: [], totales: { c10: 0, c18: 0, c43: 0, general: 0 }, pagos: [] };
let precios = { "10": 10.00, "18": 18.00, "43": 40.00 };
let mostrarTodos = true; // Variable para controlar si mostrar todos o solo los últimos 3

// Cargar datos al iniciar
window.onload = function() {
    cargarDatos();
};

function cargarDatos() {
    const datosGuardados = localStorage.getItem('registroGas');
    if (datosGuardados) {
        const datos = JSON.parse(datosGuardados);
        jornadas = datos.jornadas || [];
        jornadaActual = datos.jornadaActual || { fecha: null, filas: [], totales: { c10: 0, c18: 0, c43: 0, general: 0 }, pagos: [] };
        precios = datos.precios || precios;
    }
    
    const tabla = document.getElementById('cuerpo-tabla');
    tabla.innerHTML = ""; // Limpiar antes de cargar
    
    let filasAMostrar = mostrarTodos ? jornadaActual.filas : jornadaActual.filas.slice(-3); // Mostrar todos o solo los últimos 3
    
    filasAMostrar.forEach((fila, tableIndex) => {
        const nuevaFila = tabla.insertRow();
        nuevaFila.innerHTML = `
            <td style="text-align: left;">${fila.nombre}</td>
            <td>${fila.c10}</td>
            <td>${fila.c18}</td>
            <td>${fila.c43}</td>
            <td>${fila.suma}</td>
        `;
    });
    
    actualizarInterfazTotales();
}

function guardarDatos() {
    const datos = {
        precios: precios,
        jornadas: jornadas,
        jornadaActual: jornadaActual
    };
    localStorage.setItem('registroGas', JSON.stringify(datos));
}

function agregarFila() {
    const nombreInput = document.getElementById('nombre');
    const c10Input = document.getElementById('c10');
    const c18Input = document.getElementById('c18');
    const c43Input = document.getElementById('c43');

    const nombre = nombreInput.value.trim();
    const c10 = parseInt(c10Input.value) || 0;
    const c18 = parseInt(c18Input.value) || 0;
    const c43 = parseInt(c43Input.value) || 0;
    const sumaFila = c10 + c18 + c43;

    if (nombre === "") { 
        alert("Por favor, pon un nombre"); 
        return; 
    }

    if (jornadaActual.fecha === null) {
        jornadaActual.fecha = new Date().toISOString();
    }

    // Agregar al array de datos
    jornadaActual.filas.push({
        nombre: nombre.toUpperCase(),
        c10: c10,
        c18: c18,
        c43: c43,
        suma: sumaFila,
        fecha: new Date().toISOString()
    });

    // Actualizar objeto de totales
    jornadaActual.totales.c10 += c10;
    jornadaActual.totales.c18 += c18;
    jornadaActual.totales.c43 += c43;
    jornadaActual.totales.general += sumaFila;

    // Guardar y refrescar tabla
    guardarDatos();
    cargarDatos(); 

    // Limpiar los campos de entrada
    nombreInput.value = "";
    c10Input.value = "";
    c18Input.value = "";
    c43Input.value = "";
    nombreInput.focus(); // Poner el cursor listo para el siguiente nombre
}

function actualizarInterfazTotales() {
    document.getElementById('t10').innerText = jornadaActual.totales.c10;
    document.getElementById('t18').innerText = jornadaActual.totales.c18;
    document.getElementById('t43').innerText = jornadaActual.totales.c43;
    document.getElementById('tGeneral').innerText = jornadaActual.totales.general;
    // Calcular montos por tipo y total en Bs usando los precios unificados
    const p10 = precios["10"] || 0;
    const p18 = precios["18"] || 0;
    const p43 = precios["43"] || 0;

    const monto10 = (jornadaActual.totales.c10 || 0) * p10;
    const monto18 = (jornadaActual.totales.c18 || 0) * p18;
    const monto43 = (jornadaActual.totales.c43 || 0) * p43;
    const montoGeneral = monto10 + monto18 + monto43;

    // Actualizar la interfaz con formato Bs
    const fmt = (v) => 'Bs ' + Number(v).toFixed(2);
    if (document.getElementById('m10')) document.getElementById('m10').innerText = fmt(monto10);
    if (document.getElementById('m18')) document.getElementById('m18').innerText = fmt(monto18);
    if (document.getElementById('m43')) document.getElementById('m43').innerText = fmt(monto43);
    if (document.getElementById('mGeneral')) document.getElementById('mGeneral').innerText = fmt(montoGeneral);
}

function generarPDF() {
    const element = document.getElementById('formato-impresion');
    html2pdf().from(element).save('registro-gas.pdf');
}

function borrarTodo() {
    if(confirm("¿Estás seguro de borrar la jornada actual? Los registros anteriores se mantendrán.")) {
        jornadaActual = { fecha: null, filas: [], totales: { c10: 0, c18: 0, c43: 0, general: 0 }, pagos: [] };
        guardarDatos();
        cargarDatos();
    }
}

function mostrarUltimosTres() {
    mostrarTodos = false;
    cargarDatos();
}

function mostrarTodosRegistros() {
    mostrarTodos = true;
    cargarDatos();
}

// Escuchar cambios en localStorage desde otras pestañas (sin recargar)
window.addEventListener('storage', (e) => {
    if (e.key === 'registroGas' && e.newValue) {
        try {
            const datos = JSON.parse(e.newValue);
            precios = datos.precios || precios;
            jornadas = datos.jornadas || jornadas;
            jornadaActual = datos.jornadaActual || jornadaActual;
            // Refrescar la vista con los nuevos precios y totales
            cargarDatos();
        } catch (err) {
            console.error('Error parsing registroGas from storage event', err);
        }
    }
});