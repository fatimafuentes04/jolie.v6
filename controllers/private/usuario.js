// Constantes para completar las rutas de la API.
const USUARIO_API = 'business/dashboard/usuario.php';
const titulo_modal =document.getElementById('modal-title');
const TBODY_ROWS = document.getElementById('tbody-rows');
const RECORDS = document.getElementById('records');
const FORMULARIO = document.getElementById('save-form');



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
   
    TBODY_ROWS.innerHTML ='';
    RECORDS.textContent ='';
    // Se verifica la acción a realizar.
    (form) ? action = 'search' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(USUARIO_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            // Se establece un icono para el estado del producto.
        
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
                <tr>
                    <td>${row.id_usuario}</td>
                    <td>${row.nombre_usuario}</td>
                    <td>${row.apellido_usuario}</td>
                    <td>${row.usuario}</td>

                    
                   <!-- <td>${row.clave_usuario}</td>-->
                    <td>${row.estado_usuario}</td>
                    <td>${row.idtipo_usuario}</td>
                    <td>
                    <button id="editbtn" onclick="updateUsuario(${row.id_usuario})" data-bs-toggle="modal" data-bs-target="#save-modal"  class="btn btn-secondary btns">
                    <i class='bx bx-edit' ></i>
                    </button>
                    <button id="deletebtn" onclick="Deleteusuario(${row.id_usuario})"  class="btn btn-secondary btns">
                    <i class='bx bxs-trash'></i>
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

function createUsuario(){
    titulo_modal.textContent ='CREAR USUARIO';
    fillSelect(USUARIO_API, 'readTipo', 'idtipo_usuario');
    console.log('se abrio modal agregar');
}



FORMULARIO.addEventListener('submit', async(event) =>{
    console.log('submit');
    event.preventDefault();
    (document.getElementById('id').value) ? action = 'update' : action = 'create';
    const FORM = new FormData(FORMULARIO);
    const JSON = await dataFetch(USUARIO_API, action, FORM);
    if (JSON.status) {
        // Se carga nuevamente la tabla para visualizar los cambios.
        fillTable();      
        // Se muestra un mensaje de éxito.
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});



async function updateUsuario(id_usuario) {
    // FORMULARIO.reset();
    const FORM = new FormData();
    FORM.append('id_usuario', id_usuario);
    const JSON = await dataFetch(USUARIO_API, 'readOne', FORM);
    if (JSON.status) {
        titulo_modal.textContent ='MODIFICAR USUARIO';
        document.getElementById('id').value = JSON.dataset.id_usuario;
        document.getElementById('nombre_usuario').value = JSON.dataset.nombre_usuario;
        document.getElementById('apellido_usuario').value = JSON.dataset.apellido_usuario;
        document.getElementById('usuario').value = JSON.dataset.usuario;
        document.getElementById('clave_usuario').value = JSON.dataset.clave_usuario;
        fillSelect(USUARIO_API, 'readTipo', 'idtipo_usuario', JSON.dataset.idtipo_usuario   );
        document.getElementById('idtipo_usuario').value = JSON.dataset.idtipo_usuario;
        // document.getElementById('estado').value = JSON.dataset.estado_producto;
        if (JSON.dataset.estado_usuario
            ) {
            document.getElementById('toggler-1').checked = true;
        } else {
            document.getElementById('toggler-1').checked = false;
        }
    }
}




async function Deleteusuario(id_usuario) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar el producto de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_usuario', id_usuario);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(USUARIO_API, 'delete', FORM);
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



