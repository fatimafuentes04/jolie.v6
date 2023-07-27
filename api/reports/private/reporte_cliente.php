<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../entities/dto/cliente.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;

// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Datos Generales');
// Se instancia el módelo Categoría para obtener los datos.
$cliente = new cliente;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($datacliente = $cliente->readAll()) {
    //se aliniar horizontalmente con el comentado landscape -> $pdf->AddPage("landscape");
    $pdf->AddPage("landscape");
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(76, 115, 131);
        // Se establece la fuente para los encabezados.
    $pdf->setFont('Times', 'B', 9);
    // Se imprimen las celdas con los encabezados. 126 ancho en vertical y 267 ancho en horizontal se divide en los 33.375 y se hace el calculo
    $pdf->cell(33.375, 10, 'ID', 1, 0, 'C', 1); //(Ancho, Alto, Titulo, borde 1 - 0, salto de linea L-C-R, color de fondo 1-0)
    $pdf->cell(33.375, 10, 'NOMBRE', 1, 0, 'C', 1);
    $pdf->cell(33.375, 10, 'APELLIDO', 1, 0, 'C', 1);
    $pdf->cell(31.375, 10, 'DUI', 1, 0, 'C', 1);
    $pdf->cell(40.375, 10, 'CORREO', 1, 0, 'C', 1);
    $pdf->cell(30.375, 10, 'TELEFONO', 1, 0, 'C', 1);
    $pdf->cell(34.375, 10, 'F. NACIMIENTO', 1, 0, 'C', 1);
    $pdf->cell(30.375, 10, 'ESTADO', 1, 1, 'C', 1);
    // Se establece un color de relleno para mostrar el nombre de la categoría.
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Times', '', 9);
   
    // Se recorren los registros fila por fila.
    foreach ($datacliente as $rowcliente) {
        // Se imprime una celda con el nombre de la categoría.
        // $pdf->cell(0, 10, $pdf->encodeString('Categoría: ' . $rowcliente['nombre_categoria']), 1, 1, 'C', 1);
        // $sql = 'SELECT id_cliente, nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, nacimiento_cliente, direccion_cliente, estado_cliente, clave
        // FROM public.cliente ORDER BY id_cliente;';
        $pdf->cell(33.375, 10, $rowcliente['id_cliente'], 1, 0, 'C');
        $pdf->cell(33.375, 10, $rowcliente['nombre_cliente'], 1, 0, 'C');
        $pdf->cell(33.375, 10, $rowcliente['apellido_cliente'], 1, 0, 'C');
        $pdf->cell(31.375, 10, $rowcliente['dui_cliente'], 1, 0, 'C');
        $pdf->cell(40.375, 10, $rowcliente['correo_cliente'], 1, 0, 'C');
        $pdf->cell(30.375, 10, $rowcliente['telefono_cliente'], 1, 0, 'C');
        ($rowcliente['estado_cliente'])? $estado = 'Activo': $estado = 'Inactivo';
        //indicar el 1,1 al final para que sea una sola fila cada dato 
        $pdf->cell(34.375, 10, $rowcliente['nacimiento_cliente'], 1, 0, 'C');
        // $pdf->cell(33.375, 1,$pdf->Image($pdf->encodeString('../../img/people/'.$rowUsuario['foto']),null,null,20.5,20), 0, 1, 'C');
        $pdf->cell(30.375, 10, $estado, 1, 1, 'C');
        // Se instancia el módelo Producto para procesar los datos.
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay dato persona para mostrar'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'productos.pdf');
