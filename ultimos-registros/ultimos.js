function cargarReporte() {
    // Siempre mostrar todos los registros
    const titulo = document.getElementById('titulo-reporte');
    titulo.innerText = 'CONSOLIDADO DE JORNADAS DE CILINDROS';

    const datosGuardados = localStorage.getItem('registroGas');
    const tabla = document.getElementById('tabla-reporte');
    const mensaje = document.getElementById('mensaje-vacio');
    const cuerpo = document.getElementById('cuerpo-reporte');

    if (datosGuardados) {
        const datos = JSON.parse(datosGuardados);
        let todasJornadas = datos.jornadas || [];
        const jornadaActual = datos.jornadaActual;
        if (jornadaActual && jornadaActual.filas.length > 0) {
            todasJornadas = [...todasJornadas, jornadaActual];
        }

        if (todasJornadas.length > 0) {
            // Ocultar mensaje y mostrar tabla
            mensaje.style.display = 'none';
            tabla.style.display = 'table';
            
            cuerpo.innerHTML = ""; // Limpiar antes de llenar

            // Agrupar por mes y año
            const grupos = {};
            todasJornadas.forEach(jornada => {
                jornada.filas.forEach(fila => {
                    const fecha = new Date(fila.fecha);
                    const mesAno = fecha.toLocaleDateString('es-ES', { year: 'numeric', month: 'long' });
                    if (!grupos[mesAno]) {
                        grupos[mesAno] = [];
                    }
                    grupos[mesAno].push(fila);
                });
            });

            Object.keys(grupos).sort((a, b) => new Date(b) - new Date(a)).forEach(mesAno => {
                // Agregar fila de encabezado para el mes
                const headerTr = document.createElement('tr');
                headerTr.innerHTML = `<td colspan="5" style="background-color: #f0f0f0; font-weight: bold; text-align: center;">${mesAno}</td>`;
                cuerpo.appendChild(headerTr);
                
                grupos[mesAno].forEach(fila => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td style="text-align: left;">${fila.nombre}</td>
                        <td>${fila.c10}</td>
                        <td>${fila.c18}</td>
                        <td>${fila.c43}</td>
                        <td>${fila.suma}</td>
                    `;
                    cuerpo.appendChild(tr);
                });
            });

            // Calcular totales generales
            let totalC10 = 0, totalC18 = 0, totalC43 = 0, totalGeneral = 0;
            todasJornadas.forEach(jornada => {
                totalC10 += jornada.totales.c10;
                totalC18 += jornada.totales.c18;
                totalC43 += jornada.totales.c43;
                totalGeneral += jornada.totales.general;
            });

            document.getElementById('rt10').innerText = totalC10;
            document.getElementById('rt18').innerText = totalC18;
            document.getElementById('rt43').innerText = totalC43;
            document.getElementById('rtGeneral').innerText = totalGeneral;
        }
    }
}

function generarPDF() {
    const element = document.getElementById('tabla-reporte');
    html2pdf().from(element).save('reporte-registros.pdf');
}

function borrarTodosRegistros() {
    if(confirm("¿Estás seguro de eliminar todos los registros guardados? Esta acción no se puede deshacer.")) {
        localStorage.removeItem('registroGas');
        location.reload();
    }
}

// Ejecutar al cargar la página
window.onload = cargarReporte;