<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../entities/dto/pedido.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;

// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Datos Generales');
// Se instancia el módelo Categoría para obtener los datos.
$Pedido = new Pedido;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataPedido = $Pedido->readAll()) {
    //se aliniar horizontalmente con el comentado landscape -> $pdf->AddPage("landscape");
    $pdf->AddPage("landscape");
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(175);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Times', 'B', 9);
    // Se imprimen las celdas con los encabezados. 126 ancho en vertical y 267 ancho en horizontal se divide en los 33.375 y se hace el calculo
    $pdf->cell(89, 10, 'ID', 1, 0, 'C', 1); //(Ancho, Alto, Titulo, borde 1 - 0, salto de linea L-C-R, color de fondo 1-0)
    $pdf->cell(89, 10, 'ID DE PEDIDO', 1, 0, 'C', 1);
    $pdf->cell(89, 10, 'CLIENTE', 1, 1, 'C', 1);
    // $pdf->cell(53.4, 10, 'DIRECCION', 1, 0, 'C', 1);
    // $pdf->cell(53.4, 10, 'ESTADO', 1, 1, 'C', 1);
    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->setFillColor(225);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Times', '', 9);
   
    // Se recorren los registros fila por fila.
    foreach ($dataPedido as $rowPedido) {
        // Se imprime una celda con el nombre de la categoría.
        // $pdf->cell(0, 10, $pdf->encodeString('Categoría: ' . $rowPedido$dataPedido['nombre_categoria']), 1, 1, 'C', 1);
        // SELECT id_Pedido$dataPedido, id_Pedido, id_producto, cantidad, precio_producto
        // FROM public.Pedido$dataPedido_Pedido;
        // 'SELECT id_detalle, nombre_producto, producto.precio_producto, producto.imagen_producto, detalle_pedido.cantidad
        // FROM pedido
        // $sql = 'SELECT d.id_detalle, d.id_pedido, v.nombre_producto, d.cantidad, d.precio_producto
        // from detalle_pedido d
        $pdf->cell(89, 10, $rowPedido['id_pedido'], 1, 0, 'C');
        $pdf->cell(89, 10, $rowPedido['id_pedido'], 1, 0, 'C');
        // $pdf->cell(53.4, 10, $rowPedido['producto.precio_producto'], 1, 0, 'C');
        // $pdf->cell(53.4, 10, $rowPedido['producto.imagen_producto'], 1, 0, 'C');
        $pdf->cell(89, 10, $rowPedido['nombre_cliente'], 1, 1, 'C');
        // ($rowPedido$dataPedido['estado_Pedido$dataPedido'])? $estado = 'Activo': $estado = 'Inactivo';
        //indicar el 1,1 al final para que sea una sola fila cada dato 
        // $pdf->cell(33.375, 1,$pdf->Image($pdf->encodeString('../../img/people/'.$rowUsuario['foto']),null,null,20.5,20), 0, 1, 'C');
        // $pdf->cell(53.4, 10, $estado, 1, 1, 'C');
        // Se instancia el módelo Producto para procesar los datos.
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay dato persona para mostrar'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'detalle.pdf');
