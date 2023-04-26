// Constantes para completar las rutas de la API.
const CLIENTE_API = 'business/dashboard/cliente.php';
const titulo_modal = document.getElementById('modal-title');
const TBODY_ROWS = document.getElementById('tboby-rows');
const FORMULARIO = document.getElementById('save-form');

const OPTIONS = {
    dismissible: false
}

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para llenar la tabla con los registros disponibles.
    fillTable();
});

FORMULARIO.addEventListener('submit', async(event) =>{
    event.preventDefault();
    (document.getElementById('id').value) ? action = 'update' : action = 'create';
    const FORM = new FormData(FORMULARIO);
    const JSON = await dataFetch(CLIENTE_API, action, FORM);
    if (JSON.status) {
        // Se carga nuevamente la tabla para visualizar los cambios.
        fillTable();      
        // Se muestra un mensaje de éxito.
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
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
    const JSON = await dataFetch(CLIENTE_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            // Se establece un icono para el estado del producto.
        
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
                <tr>
                    <td>${row.id_cliente}</td>
                    <td>${row.nombre_cliente}</td>
                    <td>${row.apellido_cliente}</td>
                    <td>${row.dui_cliente}</td>
                    <td>${row.correo_cliente}</td>
                    <td>${row.telefono_cliente}</td>
                    <td>${row.nacimiento_cliente}</td>
                    <td>${row.direccion_cliente}</td>
                    <td>${row.estado_cliente}</td>
                    <td>
                    <button id="editbtn" onclick="updateCliente(${row.id_cliente})" data-bs-toggle="modal" data-bs-target="#save-modal"  >
                    <i class='bx bx-edit'></i>
                    </button>
                    <button id="deletebtn" onclick="Deletecliente(${row.id_cliente})">
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


function createCliente() {
    titulo_modal.textContent ='CREAR CLIENTE modal'; 
    console.log('Clientes Modal');
    // fillSelect(USUARIO_API, 'readtipo_doc', 'documento');
    // fillSelect(USUARIO_API, 'readestado_usuario', 'estado_usuario');
}


async function updateCliente(id_cliente) {
    // FORMULARIO.reset();
    const FORM = new FormData();
    FORM.append('id_cliente', id_cliente);
    const JSON = await dataFetch(CLIENTE_API, 'readOne', FORM);
    if (JSON.status) {
        titulo_modal.textContent ='MODIFICAR CLIENTE';
        document.getElementById('id').value = JSON.dataset.id_cliente;
        document.getElementById('nombre').value = JSON.dataset.nombre_cliente;
        document.getElementById('dui').value = JSON.dataset.dui_cliente;
        document.getElementById('correo').value = JSON.dataset.correo_cliente;
        document.getElementById('apellido').value = JSON.dataset.apellido_cliente;
        document.getElementById('telefono').value = JSON.dataset.telefono_cliente;
        document.getElementById('nacimiento').value = JSON.dataset.nacimiento_cliente;
        document.getElementById('direccion').value = JSON.dataset.direccion_cliente;
        // document.getElementById('estado').value = JSON.dataset.estado_producto;
        fillSelect(CLIENTE_API, 'readAll', 'cliente', JSON.dataset.id_cliente);
        if (JSON.dataset.estado_cliente) {
            document.getElementById('toggler-1').checked = true;
        } else {
            document.getElementById('toggler-1').checked = false;
        }
    }
}

async function Deletecliente(id_cliente) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar el producto de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_cliente', id_cliente);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(CLIENTE_API, 'delete', FORM);
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
