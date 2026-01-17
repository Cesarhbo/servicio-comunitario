// --- NUEVA LÓGICA PARA LÍDERES ---

// 1. Inicializar datos de líderes desde localStorage
let lideres = JSON.parse(localStorage.getItem('lideresGas')) || [];
let editingId = null; // id del líder que se está editando (null si se crea uno nuevo)

// 2. Manejar el Registro de Líderes
document.getElementById('formLider').addEventListener('submit', (e) => {
    e.preventDefault();
    const nombre = document.getElementById('nombreLider').value.trim();
    const cedula = document.getElementById('cedulaLider').value.trim();
    const calle = document.getElementById('calleLider').value.trim();
    const habitantes = document.getElementById('habitantesLider').value;
    const estatus = document.getElementById('estatusCalle').value;

    if (editingId) {
        // Actualizar líder existente
        const idx = lideres.findIndex(l => l.id === editingId);
        if (idx !== -1) {
            lideres[idx].nombre = nombre;
            lideres[idx].cedula = cedula;
            lideres[idx].calle = calle;
            lideres[idx].habitantes = habitantes;
            lideres[idx].estatus = estatus;
        }
        editingId = null;
        // Restaurar texto del botón y ocultar cancelar
        const btn = document.querySelector('.btn-registrar'); if (btn) btn.innerText = 'Registrar Líder';
        const btnCancel = document.getElementById('btnCancelEdit'); if (btnCancel) btnCancel.style.display = 'none';
    } else {
        const nuevoLider = {
            id: Date.now(), // ID único para poder eliminar
            nombre,
            cedula,
            calle,
            habitantes,
            estatus
        };
        lideres.push(nuevoLider);
    }

    guardarYRenderizarLideres();
    e.target.reset();
});

// 3. Guardar en Storage y refrescar tabla
function guardarYRenderizarLideres() {
    localStorage.setItem('lideresGas', JSON.stringify(lideres));
    renderTablaLideres();
}

// Calcular y mostrar contadores y montos (censo)
function actualizarResumen() {
    const resumen = { alDia: 0, pendiente: 0, censo: 0, habAlDia: 0, habPendiente: 0, habCenso: 0 };

    lideres.forEach(l => {
        const hab = parseInt(l.habitantes) || 0;
        if (l.estatus === 'Al día') { resumen.alDia++; resumen.habAlDia += hab; }
        else if (l.estatus === 'Pendiente') { resumen.pendiente++; resumen.habPendiente += hab; }
        else if (l.estatus === 'En Censo') { resumen.censo++; resumen.habCenso += hab; }
    });

    const totalHab = resumen.habAlDia + resumen.habPendiente + resumen.habCenso;

    // Actualizar DOM
    if (document.getElementById('countAlDia')) document.getElementById('countAlDia').innerText = resumen.alDia;
    if (document.getElementById('countPendiente')) document.getElementById('countPendiente').innerText = resumen.pendiente;
    if (document.getElementById('countCenso')) document.getElementById('countCenso').innerText = resumen.censo;

    if (document.getElementById('habAlDia')) document.getElementById('habAlDia').innerText = resumen.habAlDia;
    if (document.getElementById('habPendiente')) document.getElementById('habPendiente').innerText = resumen.habPendiente;
    if (document.getElementById('habCenso')) document.getElementById('habCenso').innerText = resumen.habCenso;
    if (document.getElementById('totalHab')) document.getElementById('totalHab').innerText = totalHab;
}

// 4. Renderizar tabla de Líderes
function renderTablaLideres() {
    const tabla = document.getElementById('tablaLideres');
    tabla.innerHTML = "";
    // Ordenar por estatus y nombre para mejor presentación
    lideres.sort((a,b)=> a.estatus.localeCompare(b.estatus) || a.nombre.localeCompare(b.nombre));

    lideres.forEach(lider => {
        let claseEstatus = 'status-pendiente';
        if (lider.estatus === 'Al día') claseEstatus = 'status-al-dia';
        if (lider.estatus === 'En Censo') claseEstatus = 'status-en-censo';
        
        tabla.innerHTML += `
            <tr>
                <td>${lider.nombre}</td>
                <td>${lider.cedula}</td>
                <td>${lider.calle}</td>
                <td>${lider.habitantes}</td>
                <td><span class="status-tag ${claseEstatus}">${lider.estatus}</span></td>
                <td>
                    <button class="btn-edit" onclick="editarLider(${lider.id})">Editar</button>
                    <button class="btn-eliminar" onclick="eliminarLider(${lider.id})">Eliminar</button>
                </td>
            </tr>
        `;
    });

    // Actualizar resumen después de renderizar la tabla
    actualizarResumen();
}

// 5. Función para eliminar un líder
function eliminarLider(id) {
    if(confirm("¿Seguro que desea eliminar este registro?")) {
        lideres = lideres.filter(l => l.id !== id);
        // Si se estaba editando este líder, cancelar la edición
        if (editingId === id) {
            editingId = null;
            const form = document.getElementById('formLider'); if (form) form.reset();
            const btn = document.querySelector('.btn-registrar'); if (btn) btn.innerText = 'Registrar Líder';
            const btnCancel = document.getElementById('btnCancelEdit'); if (btnCancel) btnCancel.style.display = 'none';
        }
        guardarYRenderizarLideres();
    }
}

// 6. Editar líder: llena el formulario con los datos y cambia el modo a 'editar'
function editarLider(id) {
    const lider = lideres.find(l => l.id === id);
    if (!lider) return;
    document.getElementById('nombreLider').value = lider.nombre;
    document.getElementById('cedulaLider').value = lider.cedula;
    document.getElementById('calleLider').value = lider.calle;
    document.getElementById('habitantesLider').value = lider.habitantes;
    document.getElementById('estatusCalle').value = lider.estatus;
    editingId = id;
    const btn = document.querySelector('.btn-registrar'); if (btn) btn.innerText = 'Guardar cambios';
    const btnCancel = document.getElementById('btnCancelEdit'); if (btnCancel) btnCancel.style.display = 'inline-block';
    document.getElementById('nombreLider').focus();
}

// Cancelar edición
document.getElementById('btnCancelEdit').addEventListener('click', () => {
    editingId = null;
    const form = document.getElementById('formLider'); if (form) form.reset();
    const btn = document.querySelector('.btn-registrar'); if (btn) btn.innerText = 'Registrar Líder';
    const btnCancel = document.getElementById('btnCancelEdit'); if (btnCancel) btnCancel.style.display = 'none';
});

// LLAMAR ESTA FUNCIÓN AL INICIO DEL SCRIPT
renderTablaLideres();