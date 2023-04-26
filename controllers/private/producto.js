//Constantes para completar las rutas de la API.
const PRODUCTO_API = 'business/dashboard/producto.php';
const CATEGORIA_API = 'business/dashboard/categoria.php';
const titulo_modal = document.getElementById('modal-title');
const TBODY_ROWS = document.getElementById('tboby-row');
const FORMULARIO = document.getElementById('save-form');
// Constante para establecer el formulario de buscar.
const SEARCH_FORM = document.getElementById('search-form');


// javascript se manda a llamar el id y en php el name uwu

// Método manejador de eventos para cuando el documento ha cargado.
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


FORMULARIO.addEventListener('submit', async(event) =>{
    event.preventDefault();
    (document.getElementById('id').value) ? action = 'update' : action = 'create';
    const FORM = new FormData(FORMULARIO);
    const JSON = await dataFetch(PRODUCTO_API, action, FORM);
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
    // RECORDS.textContent ='';
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
                    <button id="editbtn" data-bs-toggle="modal" data-bs-target="#save-modal" onclick="updateProducto(${row.id_producto})">
                    <i class='bx bx-edit'></i>
                    </button>
                    <button id="deletebtn" onclick="Deleteproducto(${row.id_producto})">
                    <i class='bx bxs-trash'></i>
                    </button>
                    </td>
                </tr>
            `;
        });

        // RECORDS.textContent = JSON.message;

    } else {
        sweetAlert(4, JSON.exception, true);
    }
}

function createProductos() {
    // FORMULARIO.reset();
    titulo_modal.textContent ='CREAR PRODUCTOS';
    fillSelect(PRODUCTO_API, 'readCategoria', 'categoria');
    fillSelect(PRODUCTO_API, 'readEditorial', 'editorial'); 
    fillSelect(PRODUCTO_API, 'readUsuarios', 'usuario'); 
    fillSelect(PRODUCTO_API, 'readAutor', 'autor'); 
    
}

async function updateProducto(id_producto) {
    // FORMULARIO.reset();
    const FORM = new FormData();
    FORM.append('id_producto', id_producto);
    const JSON = await dataFetch(PRODUCTO_API, 'readOne', FORM);
    if (JSON.status) {
        titulo_modal.textContent ='MODIFICAR PRODUCTO';
        document.getElementById('id').value = JSON.dataset.id_producto;
        document.getElementById('nombre').value = JSON.dataset.nombre_producto;
        document.getElementById('descripcion').value = JSON.dataset.descripcion;
        document.getElementById('precio').value = JSON.dataset.precio;
        fillSelect(PRODUCTO_API, 'readCategoria', 'categoria', JSON.dataset.id_categoria);
        fillSelect(PRODUCTO_API, 'readEditorial', 'editorial', JSON.dataset.id_editorial);
        // document.getElementById('estado').value = JSON.dataset.estado_producto;
        fillSelect(PRODUCTO_API, 'readAll', 'producto', JSON.dataset.id_producto);
        if (JSON.dataset.estado_producto) {
            document.getElementById('estado').checked = true;
        } else {
            document.getElementById('estado').checked = false;
        }
        fillSelect(PRODUCTO_API, 'readUsuarios', 'usuario', JSON.dataset.id_usuario);
        fillSelect(PRODUCTO_API, 'readAutor', 'autor', JSON.dataset.id_autor);
        document.getElementById('porcentaje').value = JSON.dataset.porcentaje_descuento;
        document.getElementById('isbn').value = JSON.dataset.isbn;
        document.getElementById('archivo').value = JSON.dataset.imagen;
        document.getElementById('stock').value = JSON.dataset.stock;
    }
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



// SEARCH_FORM.addEventListener('submit', (event) => {
//     // Se evita recargar la página web después de enviar el formulario.
//     event.preventDefault();
//     // Constante tipo objeto con los datos del formulario.
//     const FORM = new FormData(SEARCH_FORM);
//     // Llamada a la función para llenar la tabla con los resultados de la búsqueda.
//     fillTable(FORM);
// });