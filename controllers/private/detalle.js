// Constantes para completar las rutas de la API.
const DETALLE_API = 'business/dashboard/detalle.php';
const titulo_modal = document.getElementById('modal-title');
const TBODY_ROWS = document.getElementById('tbody-rows');
const RECORDS = document.getElementById('records');




// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para llenar la tabla con los registros disponibles.
    fillTable();
});

/*
*   Función asíncrona para llenar la tabla con los registros disponibles.
*   Parámetros: form (objeto opcional con los datos de búsqueda).
*   Retorno: ninguno.
*/
async function fillTable(form = null) {

    TBODY_ROWS.innerHTML = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'search' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(DETALLE_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            // Se establece un icono para el estado del producto.

            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
                <tr>
                <td>${row.id_detalle}</td>
                <td>${row.id_pedido}</td>
                <td>${row.id_producto}</td>
                <td>${row.cantidad}</td>
                <td>${row.precio_producto}</td>
                    <td>
                    <button><i class='bx bx-edit'></i></button>
                    <button id="deletebtn" onclick="DeleteDetalle(${row.id_detalle})">
                    <i class='bx bxs-trash'></i>
                    </button>
                    </td>
                </tr>
            `;
        });


    } else {
        sweetAlert(4, JSON.exception, true);
    }
}


function createDetalle() {
    titulo_modal.textContent = 'CREAR DETALLE';
    fillSelect(DETALLE_API, 'readProducto', 'producto');
}

async function DeleteDetalle(id_detalle) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar el producto de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_detalle', id_detalle);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(DETALLE_API, 'delete', FORM);
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


//#region reporte  de dato personal
/*
 *   Función para abrir el reporte de productos por categoría.
 *   Parámetros: ninguno.
 *   Retorno: ninguno.
 */
function openReportD() {
	// Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
	const PATH = new URL(`${SERVER_URL}reports/private/reporte_detalle.php`);
	// Se abre el reporte en una nueva pestaña del navegador web.
	window.open(PATH.href);
}
//#endregion
