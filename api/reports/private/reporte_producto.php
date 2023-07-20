<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../entities/dto/usuario.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;

// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Datos Generales');
// Se instancia el módelo Categoría para obtener los datos.
$Usuario = new Usuario;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataUsuario = $Usuario->readAll()) {
    //se aliniar horizontalmente con el comentado landscape -> $pdf->AddPage("landscape");
    $pdf->AddPage("landscape");
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(175);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Times', 'B', 9);
    // Se imprimen las celdas con los encabezados. 126 ancho en vertical y 267 ancho en horizontal se divide en los 33.375 y se hace el calculo
    $pdf->cell(44.5, 10, 'ID', 1, 0, 'C', 1); //(Ancho, Alto, Titulo, borde 1 - 0, salto de linea L-C-R, color de fondo 1-0)
    $pdf->cell(44.5, 10, 'NOMBRE', 1, 0, 'C', 1);
    $pdf->cell(44.5, 10, 'APELLIDO', 1, 0, 'C', 1);
    $pdf->cell(44.5, 10, 'USUARIO', 1, 0, 'C', 1);
    $pdf->cell(44.5, 10, 'TIPO', 1, 0, 'C', 1);
    $pdf->cell(44.5, 10, 'ESTADO', 1, 1, 'C', 1);
    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->setFillColor(225);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Times', '', 9);
   
    // Se recorren los registros fila por fila.
    foreach ($dataUsuario as $rowUsuario) {
        // Se imprime una celda con el nombre de la categoría.
        // $pdf->cell(0, 10, $pdf->encodeString('Categoría: ' . $rowUsuario['nombre_categoria']), 1, 1, 'C', 1);
    //     SELECT id_usuario, nombre_usuario, apellido_usuario, usuario, clave_usuario, estado_usuario, idtipo_usuario
	// FROM public.usuario ORDER BY id_usuario; 
        $pdf->cell(44.5, 10, $rowUsuario['id_usuario'], 1, 0, 'C');
        $pdf->cell(44.5, 10, $rowUsuario['nombre_usuario'], 1, 0, 'C');
        $pdf->cell(44.5, 10, $rowUsuario['apellido_usuario'], 1, 0, 'C');
        $pdf->cell(44.5, 10, $rowUsuario['usuario'], 1, 0, 'C');
        ($rowUsuario['estado_usuario'])? $estado = 'Activo': $estado = 'Inactivo';
        //indicar el 1,1 al final para que sea una sola fila cada dato 
        $pdf->cell(44.5, 10, $rowUsuario['idtipo_usuario'], 1, 0, 'C');
        // $pdf->cell(33.375, 1,$pdf->Image($pdf->encodeString('../../img/people/'.$rowUsuario['foto']),null,null,20.5,20), 0, 1, 'C');
        $pdf->cell(44.5, 10, $estado, 1, 1, 'C');
        // Se instancia el módelo Producto para procesar los datos.
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay dato persona para mostrar'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'productos.pdf');
