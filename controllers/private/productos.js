// Constantes para completar las rutas de la API.
const PRODUCTO_API = 'business/dashboard/producto.php';
const CATEGORIA_API = 'business/dashboard/categoria.php';
const titulo_modal =document.getElementById('modal-title');
const TBODY_ROWS = document.getElementById('tboby-row');

const OPTIONS = {
    dismissible: false
}

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
    // Se inicializa el contenido de la tabla.
    TBODY_ROWS.innerHTML = '';

    // Se verifica la acción a realizar.
    (form) ? action = 'search' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(PRODUCTO_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            // Se establece un icono para el estado del producto.
        
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
                <tr>
                    <td>${row.id_producto}</td>
                    <td>${row.nombre_producto}</td>
                    <td>${row.descripcion}</td>
                    <td>${row.precio}</td>

                    <td>${row.estado_producto}</td>

                    <td>${row.porcentaje_descuento}</td>
                    <td>${row.isbn}</td>
                    <td>${row.imagen}</td>
                    <td>${row.stock}</td>
                    <td>
                    <button><i class='bx bx-edit'></i></button>
                    <button id="deletebtn" onclick="Deleteproducto(${row.id_producto})">
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

function createProductos() {
    titulo_modal.textContent ='CREATE PRODUCTO';
    fillSelect(PRODUCTO_API, 'readCategoria', 'categoria');
}

async function Deleteproducto(id_producto) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar el producto de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_producto', id_producto);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(PRODUCTO_API, 'delete', FORM);
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
