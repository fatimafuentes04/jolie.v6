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

            // Función leer de producto
            case 'readAll':
                if ($result['dataset'] = $Producto_p->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;

                // case 'search':
                //     $_POST = Validator::validateForm($_POST);
                //     if ($_POST['search'] == '') {
                //         $result['exception'] = 'Ingrese un valor para buscar';
                //     } elseif ($result['dataset'] = $producto->searchRows($_POST['search'])) {
                //         $result['status'] = 1;
                //         $result['message'] = 'Existen '.count($result['dataset']).' coincidencias';
                //     } elseif (Database::getException()) {
                //         $result['exception'] = Database::getException();
                //     } else {
                //         $result['exception'] = 'No hay coincidencias';
                //     }
                //     break;

                // Función crear de producto
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!isset($_POST['categoria'])) {
                    $result['exception'] = 'Seleccione una categoría';
                } elseif (!$Producto_p->setCategoria($_POST['categoria'])) {
                    $result['exception'] = 'Categoría incorrecta';
                } elseif (!$Producto_p->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Descripción incorrecta';
                } elseif (!$Producto_p->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Precio incorrecto';
                } elseif (!$Producto_p->setPrecio($_POST['precio'])) {
                    $result['exception'] = 'Precio incorrecto';
                } elseif (!isset($_POST['estado'])) {
                    $result['exception'] = 'Seleccione una categoría';
                } elseif (!$Producto_p->setEstadoProducto($_POST['estado'])) {
                    $result['exception'] = 'Categoría incorrecta';
                } elseif (!isset($_POST['talla'])) {
                    $result['exception'] = 'Seleccione una categoría';
                } elseif (!$Producto_p->setTalla($_POST['talla'])) {
                    $result['exception'] = 'Categoría incorrecta';
                } elseif (!isset($_POST['usuario'])) {
                    $result['exception'] = 'Seleccione una categoría';
                } elseif (!$Producto_p->setUsuario($_POST['usuario'])) {
                    $result['exception'] = 'Categoría incorrecta';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    $result['exception'] = 'Seleccione una imagen';
                } elseif (!$Producto_p->setImagen($_FILES['archivo'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif (!isset($_POST['moreimg'])) {
                    $result['exception'] = 'Seleccione una categoría';
                } elseif (!$Producto_p->setimagencarrusel($_POST['moreimg'])) {
                    $result['exception'] = 'img incorrecta';
                } elseif ($Producto_p->createRow()) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['archivo'], $Producto_p->getRuta(), $Producto_p->getImagen())) {
                        $result['message'] = 'Producto creado correctamente';
                    } else {
                        $result['message'] = 'Producto creado pero no se guardó la imagen';
                 }
                    
                } else {
                    $result['exception'] = Database::getException();
                }
                break;

                // Función leer de producto
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

                // case 'readAllValoracion':
                //     if (!$Producto_p->setid_producto($_POST['id_producto'])) {
                //         $result['exception'] = 'Valoracion incorrecta';
                //     } elseif ($result['dataset'] = $Producto_p->readAllValoracion()) {
                //         $result['status'] = 1;
                //         $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                //     } elseif (Database::getException()) {
                //         $result['exception'] = Database::getException();
                //     } else {
                //         $result['exception'] = 'No hay datos registrados';
                //     }
                // break;

                // case 'deleteValo':
                //     if (!$Producto_p->setid_valo($_POST['id_valoracion'])) {
                //         $result['exception'] = 'Valoracion incorrecto';
                //     } elseif (!$data = $Producto_p->readOneValo()) {
                //         $result['exception'] = 'Valoracion inexistente';
                //     } elseif ($producto->deleteRowValo($data['estado_comentario'])) {
                //         $result['status'] = 1;
                //             $result['message'] = 'Valoracion eliminado correctamente';
                //     } else {
                //         $result['exception'] = Database::getException();
                //     }
                //     break;

                    // Función leer de categoria en producto
            case 'readCategoria':
                if ($result['dataset'] = $Producto_p->readCategoria()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
                 // Función leer de estado en producto
            case 'readEstado':
                if ($result['dataset'] = $Producto_p->readEstado()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
                 // Función leer de talla en producto
            case 'readTalla':
                if ($result['dataset'] = $Producto_p->readTalla()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
                 // Función leer de imagen en producto
            case 'readImagen':
                if ($result['dataset'] = $Producto_p->readImagen()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;

                 // Función leer de usuario en producto
            case 'readUsuario':
                if ($result['dataset'] = $Producto_p->readUsuario()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;


                 // Función actualizar producto
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$Producto_p->setid_producto($_POST['id'])) {
                    $result['exception'] = 'Producto incorrecto';
                } elseif (!$data = $Producto_p->readOne()) {
                    $result['exception'] = 'Producto inexistente';
                } elseif (!$Producto_p->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$Producto_p->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripción incorrecta';
                } elseif (!$Producto_p->setPrecio($_POST['precio'])) {
                    $result['exception'] = 'Precio incorrecto';
                } elseif (!$Producto_p->setCategoria($_POST['categoria'])) {
                    $result['exception'] = 'Seleccione una categoría';
                } elseif (!$Producto_p->setEstadoProducto($_POST['estado'])) {
                    $result['exception'] = 'Seleccione una categoría';
                } elseif (!$Producto_p->setTalla($_POST['talla'])) {
                    $result['exception'] = 'Seleccione una categoría';
                } elseif (!$Producto_p->setUsuario($_POST['usuario'])) {
                    $result['exception'] = 'Seleccione una usuario';
                } elseif (!$Producto_p->setimagencarrusel($_POST['moreimg'])) {
                    $result['exception'] = 'Seleccione una categoría';
                } elseif (!$Producto_p->setImagen($_FILES['archivo'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($Producto_p->updateRow($data['imagen_producto'])) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['archivo'], $Producto_p->getRuta(), $Producto_p->getImagen())) {
                        $result['message'] = 'Producto modificado correctamente';
                    } else {
                        $result['message'] = 'Producto modificado pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;

                 // Función eliminar producto
            case 'delete':
                if (!$Producto_p->setid_producto($_POST['id_producto'])) {
                    $result['exception'] = 'Producto incorrecto';
                } elseif (!$data = $Producto_p->readOne()) {
                    $result['exception'] = 'Producto inexistente';
                } elseif ($Producto_p->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Producto eliminado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;

                case 'cantidadProductosCategoria':
                    if ($result['dataset'] = $Producto_p->cantidadProductosCategoria()) {
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'No hay datos disponibles';
                    }
                    break;
                case 'porcentajeProductosCategoria':
                    if ($result['dataset'] = $Producto_p->porcentajeProductosCategoria()) {
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'No hay datos disponibles';
                    }
                    break;
                case 'Productos_mas_baratos':
                    if ($result['dataset'] = $Producto_p->Productos_mas_baratos()) {
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'No hay datos disponibles';
                    }
                    break;
                case 'Productos_mas_caros':
                    if ($result['dataset'] = $Producto_p->Productos_mas_caros()) {
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'No hay datos disponibles';
                    }
                    break;
                case 'Suma_de_productos':
                    if ($result['dataset'] = $Producto_p->Suma_de_productos()) {
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
