// Constante para completar la ruta de la API.
const PEDIDO_API = 'business/public/pedido.php';
// Constante para establecer el formulario de cambiar producto.
const ITEM_FORM = document.getElementById('item-form');
// Constante para establecer el cuerpo de la tabla.
const TBODY_ROWS = document.getElementById('tbody-rows');
// Constante tipo objeto para establecer las opciones del componente Modal.
const OPTIONS = {
    dismissible: false
}
// Se inicializa el componente Modal para que funcionen las cajas de diálogo.
//M.Modal.init(document.querySelectorAll('.modal'), OPTIONS);
// Constante para establecer la caja de diálogo de cambiar producto.
//const ITEM_MODAL = M.Modal.getInstance(document.getElementById('item-modal'));

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para mostrar los productos del carrito de compras.
    readOrderDetail();
});

// Método manejador de eventos para cuando se envía el formulario de cambiar cantidad de producto.
//ITEM_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
  //  event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
  //  const FORM = new FormData(ITEM_FORM);
    // Petición para actualizar la cantidad de producto.
  //  const JSON = await dataFetch(PEDIDO_API, 'updateDetail', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
  //  if (JSON.status) {
        // Se actualiza la tabla para visualizar los cambios.
   //     readOrderDetail();
        // Se cierra la caja de diálogo del formulario.
    //    ITEM_MODAL.close();
        // Se muestra un mensaje de éxito.
  //      sweetAlert(1, JSON.message, true);
 //   } else {
  //      sweetAlert(2, JSON.exception, false);
  //  }
//});

/*
*   Función para obtener el detalle del carrito de compras.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
async function readOrderDetail() {
    // Petición para obtener los datos del pedido en proceso.
    const JSON = await dataFetch(PEDIDO_API, 'readOrderDetail');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se inicializa el cuerpo de la tabla.
        TBODY_ROWS.innerHTML = '';
        // Se declara e inicializa una variable para calcular el importe por cada producto.
        let subtotal = 0;
        // Se declara e inicializa una variable para sumar cada subtotal y obtener el monto final a pagar.
        let total = 0;
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            subtotal = row.precio_producto * row.cantidad;
            total += subtotal;
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
                <tr>
                    <td>${row.nombre_producto}</td>
                    <td>${row.precio_producto}</td>
                    <td>${row.cantidad}</td>
                    <td>${subtotal.toFixed(2)}</td>
                    <td>
                    <button class="button" type="button" data-bs-toggle="modal" data-bs-target="#save-modal"  onclick="openUpdate(${row.id_detalle}, ${row.cantidad})">
                    <span class="button__text">Actualizar</span>
                    <span class="button__icon"><svg xmlns="http://www.w3.org/2000/svg" width="48" viewBox="0 0 48 48" height="48" class="svg"><path d="M35.3 12.7c-2.89-2.9-6.88-4.7-11.3-4.7-8.84 0-15.98 7.16-15.98 16s7.14 16 15.98 16c7.45 0 13.69-5.1 15.46-12h-4.16c-1.65 4.66-6.07 8-11.3 8-6.63 0-12-5.37-12-12s5.37-12 12-12c3.31 0 6.28 1.38 8.45 3.55l-6.45 6.45h14v-14l-4.7 4.7z"></path><path fill="none" d="M0 0h48v48h-48z"></path></svg></span>
                  </button>
                  <br>
                  <button class="b_elimiinar" type="button"  onclick="openDelete(${row.id_detalle})">
                    <span class="button__text">Eliminar</span>
                    <span class="button__icon"><svg class="svg" height="512" viewBox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg"><title></title><path d="M112,112l20,320c.95,18.49,14.4,32,32,32H348c17.67,0,30.87-13.51,32-32l20-320" style="fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"></path><line style="stroke:#fff;stroke-linecap:round;stroke-miterlimit:10;stroke-width:32px" x1="80" x2="432" y1="112" y2="112"></line><path d="M192,112V72h0a23.93,23.93,0,0,1,24-24h80a23.93,23.93,0,0,1,24,24h0v40" style="fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"></path><line style="fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px" x1="256" x2="256" y1="176" y2="400"></line><line style="fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px" x1="184" x2="192" y1="176" y2="400"></line><line style="fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px" x1="328" x2="320" y1="176" y2="400"></line></svg></span>
                  </button>
                    </td>
                </tr>
            `;
        });
        // Se muestra el total a pagar con dos decimales.
        document.getElementById('pago').textContent = total.toFixed(2);
        // Se inicializa el componente Tooltip para que funcionen las sugerencias textuales.
        M.Tooltip.init(document.querySelectorAll('.tooltipped'));
    } else {
        sweetAlert(4, JSON.exception, false, 'index.html');
    }
}

/*
*   Función para abrir la caja de diálogo con el formulario de cambiar cantidad de producto.
*   Parámetros: id (identificador del producto) y quantity (cantidad actual del producto).
*   Retorno: ninguno.
*/
//function openUpdate(id, quantity) {
    // Se abre la caja de diálogo que contiene el formulario.
    //ITEM_MODAL.open();
    // Se inicializan los campos del formulario con los datos del registro seleccionado.
   // document.getElementById('id_detalle').value = id;
   // document.getElementById('cantidad').value = quantity;
    // Se actualizan los campos para que las etiquetas (labels) no queden sobre los datos.
   // M.updateTextFields();
//}

/*
*   Función asíncrona para mostrar un mensaje de confirmación al momento de finalizar el pedido.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
//async function finishOrder() {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
   // const RESPONSE = await confirmAction('¿Está seguro de finalizar el pedido?');
    // Se verifica la respuesta del mensaje.
  //  if (RESPONSE) {
        // Petición para finalizar el pedido en proceso.
   //     const JSON = await dataFetch(PEDIDO_API, 'finishOrder');
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
   //     if (JSON.status) {
   //        sweetAlert(1, JSON.message, true, 'index.html');
    //    } else {
    //        sweetAlert(2, JSON.exception, false);
      //  }
  //  }
//}

/*
*   Función asíncrona para mostrar un mensaje de confirmación al momento de eliminar un producto del carrito.
*   Parámetros: id (identificador del producto).
*   Retorno: ninguno.
*/
//async function openDelete(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
  //  const RESPONSE = await confirmAction('¿Está seguro de remover el producto?');
    // Se verifica la respuesta del mensaje.
 //   if (RESPONSE) {
        // Se define un objeto con los datos del producto seleccionado.
   //     const FORM = new FormData();
 //       FORM.append('id_detalle', id);
        // Petición para eliminar un producto del carrito de compras.
   //     const JSON = await dataFetch(PEDIDO_API, 'deleteDetail', FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
   //     if (JSON.status) {
            // Se carga nuevamente la tabla para visualizar los cambios.
    //        readOrderDetail();
     //       sweetAlert(1, JSON.message, true);
     ///   } else {
      //      sweetAlert(2, JSON.exception, false);
       // }
  //  }
//}