// Constante para completar la ruta de la API.
const PEDIDO_API = 'business/dashboard/pedido.php';

const CLIENTE_API = 'business/dashboard/cliente.php';
const ESTADOP_API = 'business/dashboard/estadopedido.php';
//Constante para cambiarle el titulo a el modal
const MODAL_TITLE = document.getElementById('modal-title');
// Constante para establecer el formulario de buscar.

const SAVE_MODAL = new bootstrap.Modal(document.getElementById('exampleModal'));

const SEARCH_FORM = document.getElementById('search-form');

const SAVE_FORM = document.getElementById('save-form');
// Constantes para cuerpo de la tabla
const TBODY_ROWS = document.getElementById('tbody-rowsPed');
const RECORDS = document.getElementById('recordsPed');

//Cargar cosntanstes cuepor de las tablas de detalle pedido
const TBODYDT_ROWS = document.getElementById('tbody-rowsv');
const RECORDDT = document.getElementById('recordsPed');

//Método para que cargue graficamente la tabla
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para llenar la tabla con los registros disponibles.
    fillTable();


});

SEARCH_FORM.addEventListener('submit', (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SEARCH_FORM);
    // Llamada a la función para llenar la tabla con los resultados de la búsqueda.
    fillTable(FORM);
});


SAVE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica la acción a realizar.
    (document.getElementById('id').value) ? action = 'update' : action = 'create';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM);
    // Petición para guardar los datos del formulario.
    const JSON = await dataFetch(PEDIDO_API, action, FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        SAVE_MODAL.hide();
        // Se carga nuevamente la tabla para visualizar los cambios.
        fillTable();
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});



function openCreate() {

    SAVE_FORM.reset();
    // Se asigna título a la caja de diálogo.
    MODAL_TITLE.textContent = 'Crear pedido';
    fillSelect(CLIENTE_API, 'readAll', 'cliente');
    fillSelect(ESTADOP_API, 'readAll', 'estado');

}


async function fillTable(form = null) {
    // Se inicializa el contenido de la tabla.
    TBODY_ROWS.innerHTML = '';
    RECORDS.textContent = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'search' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(PEDIDO_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {

            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
            <tr>
                <td>${row.nombre_cliente}</td>
                <td>${row.fecha_pedido}</td>
                <td>${row.direccion_pedido}</td>
                <td>${row.estado_pedido}</td>
                <td>

                <button id="editbtn" onclick="openUpdate(${row.id_pedido})" data-bs-toggle="modal" data-bs-target="#save-modal"  class="btn btn-secondary btns">
                <i class='bx bx-edit' ></i>
                </button>
                <button id="deletebtn" onclick="openDelete(${row.id_pedido})"  class="btn btn-secondary btns">
                <i class='bx bxs-trash'></i>
                </button>

                <button id="" data-bs-toggle="modal" data-bs-target="#detallepedido" onclick="fillTableDetallePedido(${row.id_pedido})" class="btn btn-secondary btns">
                <i class="fa-regular fa-clipboard"></i>
                </button>
 

                </td>
            </tr>
            `;
        });

        RECORDS.textContent = JSON.message;
    } else {
        sweetAlert(4, JSON.exception, true);
    }
}

async function openDelete(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar el pedido de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_pedido', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(PEDIDO_API, 'delete', FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            // Se carga nuevamente la tabla para visualizar los cambios.
            fillTable();
            // Se muestra un mensaje de éxito.
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}

async function openUpdate(id) {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('id_pedido', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(PEDIDO_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        SAVE_MODAL.show();
        // Se asigna título para la caja de diálogo.
        MODAL_TITLE.textContent = 'Actualizar pedido';
        // Se inicializan los campos del formulario.
        document.getElementById('id').value = JSON.dataset.id_pedido;
        fillSelect(CLIENTE_API, 'readAll', 'cliente', JSON.dataset.id_cliente);
        document.getElementById('fecha').value = JSON.dataset.fecha_pedido;
        document.getElementById('direccion').value = JSON.dataset.direccion_pedido;
        fillSelect(ESTADOP_API, 'readAll', 'estado', JSON.dataset.idestado_pedido);

    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

//Detalle pedido YA LO TOQUE
async function fillTableDetallePedido(id) {
    // Se inicializa el contenido de la tabla.
    TBODYDT_ROWS.innerHTML = '';
    RECORDDT.textContent = '';
    const FORM = new FormData();
    FORM.append('id_pedido', id);
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(PEDIDO_API, 'readAllValoracion', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODYDT_ROWS.innerHTML += `
            <tr>
                <td>${row.id_pedido}</td>
                <td>${row.nombre_producto}</td>
                <td>${row.cantidad}</td>
                <td>${row.precio_producto}</td>
                <td>
                   
                </td>
            </tr>
            `;
        });

        RECORDDT.textContent = JSON.message;
    } else {
        sweetAlert(4, JSON.exception, true);
    }
}

//#region reporte  de dato personal
/*
 *   Función para abrir el reporte de productos por categoría.
 *   Parámetros: ninguno.
 *   Retorno: ninguno.
 */
function openReport() {
	// Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
	const PATH = new URL(`${SERVER_URL}reports/private/reporte_orden.php`);
	// Se abre el reporte en una nueva pestaña del navegador web.
	window.open(PATH.href);
}
//#endregion
