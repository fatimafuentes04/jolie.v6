// Constantes para completar las rutas de la API.
const PRODUCTO_API = 'business/dashboard/producto.php';

const MODAL_TITLE = document.getElementById('modal-title');

const TBODY_ROWS = document.getElementById('tbody-rows');
const RECORDS = document.getElementById('records');


// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para llenar la tabla con los registros disponibles.
    fillTable();
});

async function fillTable(form = null) {
    // Se inicializa el contenido de la tabla.
    TBODY_ROWS.innerHTML = '';
    RECORDS.textContent = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'search' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(PRODUCTO_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {

            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
            <tr>

                <td><img src="${SERVER_URL}imagenes/productos/${row.imagen_producto}" class="materialboxed" height="100"></td>
                <td>${row.categoria}</td>
                <td>${row.nombre_producto}</td>
                <td>${row.descripcion_producto}</td>
                <td>${row.precio_producto}</td>
                <td>${row.estado_producto}</td>
                <td>${row.nombre_usuario}</td>
                <td>${row.talla}</td>
                <td><img src="${SERVER_URL}imagenes/carrucelp/${row.imagen}" class="materialboxed" height="100"></td>
                <td>
                <button id="editbtn" onclick="updateUsuario(${row.id_producto})" data-bs-toggle="modal" data-bs-target="#save-modal"  class="btn btn-secondary btns">
                    <i class='bx bx-edit' ></i>
                    </button>
                    <button id="deletebtn" onclick="Deleteusuario(${row.id_producto})"  class="btn btn-secondary btns">
                    <i class='bx bxs-trash'></i>
                    </button>

                <button id="" data-bs-toggle="modal" data-bs-target="#detallepedido" onclick="fillTableDetallePedido(${row.id_producto})" class="btn btn-secondary btns">
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

function openCreate() {

    SAVE_MODAL.show();
    SAVE_FORM.reset();
    fillSelect(CATEGP_API, 'readAll', 'catgp');
    fillSelect(USUARIOP_API, 'readAll', 'usuap');
    // Se asigna título a la caja de diálogo.
    MODAL_TITLE.textContent = 'Crear producto';

}


