<?php
require_once('../../entities/dto/producto.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $Producto_p = new Producto;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $Producto_p->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $producto->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$Producto_p->setNombre($_POST['Nombre_P'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$Producto_p->setDescripcion($_POST['Descripcion_P'])) {
                    $result['exception'] = 'Descripción incorrecta';
                } elseif (!$Producto_p->setPrecio($_POST['Precio_P'])) {
                    $result['exception'] = 'Precio incorrecto';
                } elseif (!isset($_POST['categoria'])) {
                    $result['exception'] = 'Seleccione una categoría';
                } elseif (!$Producto_p->setCategoria($_POST['categoria'])) {
                    $result['exception'] = 'Categoría incorrecta';
                } elseif (!$Producto_p->setEstado(isset($_POST['estado']) ? 1 : 0)) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    $result['exception'] = 'Seleccione una imagen';
                } elseif (!$Producto_p->setImagen($_FILES['archivo'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($Producto_p->createRow()) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['archivo'], $Producto_p->getRuta(), $producto->getImagen())) {
                        $result['message'] = 'Producto creado correctamente';
                    } else {
                        $result['message'] = 'Producto creado pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();;
                }
                break;
            case 'readOne':
                if (!$Producto_p->setid_producto($_POST['id_producto'])) {
                    $result['exception'] = 'Producto incorrecto';
                } elseif ($result['dataset'] = $Producto_p->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Producto inexistente';
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$producto->setId($_POST['id'])) {
                    $result['exception'] = 'Producto incorrecto';
                } elseif (!$data = $producto->readOne()) {
                    $result['exception'] = 'Producto inexistente';
                } elseif (!$producto->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$producto->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripción incorrecta';
                } elseif (!$producto->setPrecio($_POST['precio'])) {
                    $result['exception'] = 'Precio incorrecto';
                } elseif (!$producto->setCategoria($_POST['categoria'])) {
                    $result['exception'] = 'Seleccione una categoría';
                } elseif (!$producto->setEstado(isset($_POST['estado']) ? 1 : 0)) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    if ($producto->updateRow($data['imagen_producto'])) {
                        $result['status'] = 1;
                        $result['message'] = 'Producto modificado correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } elseif (!$producto->setImagen($_FILES['archivo'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($producto->updateRow($data['imagen_producto'])) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['archivo'], $producto->getRuta(), $producto->getImagen())) {
                        $result['message'] = 'Producto modificado correctamente';
                    } else {
                        $result['message'] = 'Producto modificado pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$Producto_p->setid_producto($_POST['id_producto'])) {
                    $result['exception'] = 'Producto incorrecto';
                } elseif (!$data = $Producto_p->readOne()) {
                    $result['exception'] = 'Producto inexistente';
                } elseif ($Producto_p->deleteRow()) {
                    $result['status'] = 1;
                        $result['message'] = 'Producto eliminado correctamente';
                } else{ 
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readCategoria':
                if ($result['dataset'] = $Producto_p->readCategorias()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'readEditorial':
                if ($result['dataset'] = $Producto_p->readEditoriales()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'readUsuarios':
                if ($result['dataset'] = $Producto_p->readUsuarios()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'readAutor':
                if ($result['dataset'] = $Producto_p->readAutores()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'porcentajeProductosCategoria':
                if ($result['dataset'] = $producto->porcentajeProductosCategoria()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay datos disponibles';
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
        // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
        header('content-type: application/json; charset=utf-8');
        // Se imprime el resultado en formato JSON y se retorna al controlador.
        print(json_encode($result));
    } else {
        print(json_encode('Acceso denegado'));
    }
} else {
    print(json_encode('Recurso no disponible'));
}
