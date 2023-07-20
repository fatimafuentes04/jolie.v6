<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../entities/dto/producto.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;

// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Datos Generales');
// Se instancia el módelo Categoría para obtener los datos.
$Producto = new Producto;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataProducto = $Producto->readAll()) {
    //se aliniar horizontalmente con el comentado landscape -> $pdf->AddPage("landscape");
    $pdf->AddPage("landscape");
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(175);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Times', 'B', 9);
    // Se imprimen las celdas con los encabezados. 126 ancho en vertical y 267 ancho en horizontal se divide en los 33.375 y se hace el calculo
    $pdf->cell(33.375, 10, 'ID', 1, 0, 'C', 1); //(Ancho, Alto, Titulo, borde 1 - 0, salto de linea L-C-R, color de fondo 1-0)
    $pdf->cell(33.375, 10, 'CATEGORIA', 1, 0, 'C', 1);
    $pdf->cell(33.375, 10, 'NOMBRE', 1, 0, 'C', 1);
    $pdf->cell(33.375, 10, 'DESCRIPCION', 1, 0, 'C', 1);
    $pdf->cell(33.375, 10, 'PRECIO', 1, 0, 'C', 1);
    $pdf->cell(33.375, 10, 'USUARIO', 1, 0, 'C', 1);
    $pdf->cell(33.375, 10, 'TALLA', 1, 0, 'C', 1);
    $pdf->cell(33.375, 10, 'ESTADO', 1, 1, 'C', 1);
    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->setFillColor(225);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Times', '', 9);
   
    // Se recorren los registros fila por fila.
    foreach ($dataProducto as $rowProducto) {
        // Se imprime una celda con el nombre de la categoría.
        // $pdf->cell(0, 10, $pdf->encodeString('Categoría: ' . $rowProducto['nombre_categoria']), 1, 1, 'C', 1);
        // $sql = 'SELECT id_producto, categoria, nombre_producto, descripcion_producto, precio_producto, imagen_producto, estado_producto, nombre_usuario, talla, imagen
        // FROM producto 
        $pdf->cell(33.375, 10, $rowProducto['id_producto'], 1, 0, 'C');
        $pdf->cell(33.375, 10, $rowProducto['categoria'], 1, 0, 'C');
        $pdf->cell(33.375, 10, $rowProducto['nombre_producto'], 1, 0, 'C');
        $pdf->cell(33.375, 10, $rowProducto['descripcion_producto'], 1, 0, 'C');
        $pdf->cell(33.375, 10, $rowProducto['precio_producto'], 1, 0, 'C');
        $pdf->cell(33.375, 10, $rowProducto['nombre_usuario'], 1, 0, 'C');
        $pdf->cell(33.375, 10, $rowProducto['talla'], 1, 0, 'C');
        $pdf->cell(33.375, 10, $rowProducto['estado_producto'], 1, 1, 'C');

        // ($rowProducto['estado_producto'])? $estado = 'Activo': $estado = 'Inactivo';
        //indicar el 1,1 al final para que sea una sola fila cada dato 
        // $pdf->cell(33.375, 10, $rowProducto['idtipo_Producto'], 1, 0, 'C');
        // $pdf->cell(33.375, 1,$pdf->Image($pdf->encodeString('../../img/people/'.$rowProducto['foto']),null,null,20.5,20), 0, 1, 'C');
        // $pdf->cell(33.375, 10, $estado, 1, 1, 'C');
        // Se instancia el módelo Producto para procesar los datos.
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay dato persona para mostrar'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'productos.pdf');
