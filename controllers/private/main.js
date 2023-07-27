// Constante para completar la ruta de la API.
const PRODUCTO_API = 'business/dashboard/producto.php';

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Se define un objeto con la fecha y hora actual.
    let today = new Date();
    // Se define una variable con el número de horas transcurridas en el día.
    let hour = today.getHours();
    // Se define una variable para guardar un saludo.
    let greeting = '';
    // Dependiendo del número de horas transcurridas en el día, se asigna un saludo para el usuario.
    if (hour < 12) {
        greeting = 'Buenos días';
    } else if (hour < 19) {
        greeting = 'Buenas tardes';
    } else if (hour <= 23) {
        greeting = 'Buenas noches';
    }
    // Se muestra un saludo en la página web.
   // document.getElementById('greeting').textContent = greeting;
    // Se llaman a la funciones que generan los gráficos en la página web.
    graficoBarrasCategorias();
    graficoPastelCategorias();
    Productos_mas_baratos();
    Productos_mas_caros();
    Suma_de_productos();
});

/*
*   Función asíncrona para mostrar en un gráfico de barras la cantidad de productos por categoría.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
async function graficoBarrasCategorias() {
    // Petición para obtener los datos del gráfico.
    const JSON = await dataFetch(PRODUCTO_API, 'cantidadProductosCategoria');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (JSON.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let categorias = [];
        let cantidades = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            categorias.push(row.categoria);
            cantidades.push(row.cantidad);
        });
        // Llamada a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
        barGraph('chart1', categorias, cantidades, 'Cantidad de productos', 'Cantidad de productos por categoría');
    } else {
        document.getElementById('chart1').remove();
        console.log(JSON.exception);
    }
}

/*
*   Función asíncrona para mostrar en un gráfico de pastel el porcentaje de productos por categoría.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
async function graficoPastelCategorias() {
    // Petición para obtener los datos del gráfico.
    const JSON = await dataFetch(PRODUCTO_API, 'porcentajeProductosCategoria');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (JSON.status) {
        // Se declaran los arreglos para guardar los datos a gráficar.
        let talla = [];
        let cantidad = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            talla.push(row.talla);
            cantidad.push(row.cantidad);
        });
        // Llamada a la función que genera y muestra un gráfico de pastel. Se encuentra en el archivo components.js
        pieGraph('chart2', talla, cantidad, 'Cantidad de tallas');
    } else {
        document.getElementById('chart2').remove();
        console.log(JSON.exception);
    }
}

/*
*   Función asíncrona para mostrar en un gráfico de barras la cantidad de productos por categoría.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
async function Productos_mas_baratos() {
    // Petición para obtener los datos del gráfico.
    const JSON = await dataFetch(PRODUCTO_API, 'Productos_mas_baratos');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (JSON.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let producto = [];
        let precio = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            producto.push(row.usuario);
            precio.push(row.cantidad);
        });
        // Llamada a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
        barGraphdoughnut('chart3', producto, precio, 'Precio del producto', 'Productos más baratos');
    } else {
        document.getElementById('chart3').remove();
        console.log(JSON.exception);
    }
}

/*
*   Función asíncrona para mostrar en un gráfico de pastel el porcentaje de productos por categoría.
*   Parámetros: ninguno.
*   Retorno: ninguno.
// */
async function Productos_mas_caros() {
    // Petición para obtener los datos del gráfico.
    const JSON = await dataFetch(PRODUCTO_API, 'Productos_mas_caros');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (JSON.status) {
        // Se declaran los arreglos para guardar los datos a gráficar.
        let producto = [];
        let precio = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            producto.push(row.producto);
            precio.push(row.cantidad);
        });
        // Llamada a la función que genera y muestra un gráfico de pastel. Se encuentra en el archivo components.js
        barGraphpolarArea('chart4', producto, precio, 'Cantidad de imagenes por su tipo');
    } else {
        document.getElementById('chart4').remove();
        console.log(JSON.exception);
    }
}
/*
*   Función asíncrona para mostrar en un gráfico de pastel el porcentaje de productos por categoría.
*   Parámetros: ninguno.
*   Retorno: ninguno.
// */
async function Suma_de_productos() {
    // Petición para obtener los datos del gráfico.
    const JSON = await dataFetch(PRODUCTO_API, 'Suma_de_productos');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (JSON.status) {
        // Se declaran los arreglos para guardar los datos a gráficar.
        let producto = [];
        let precio = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            producto.push(row.nombre_producto);
            precio.push(row.cantidad);
        });
        // Llamada a la función que genera y muestra un gráfico de pastel. Se encuentra en el archivo components.js
        barGraphLineal('chart5', producto, precio, 'Sumatoria de productos vendidos');
    } else {
        document.getElementById('chart5').remove();
        console.log(JSON.exception);
    }
}