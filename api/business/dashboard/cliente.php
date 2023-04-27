<?php
require_once('../../entities/dto/cliente.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $Cliente_p = new cliente;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $Cliente_p->readAll()) {
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
                    } elseif ($result['dataset'] = $pedido->searchRows($_POST['search'])) {
                        $result['status'] = 1;
                        $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                    } elseif (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'No hay coincidencias';
                    }
                    break;
    
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$Cliente_p->setNombres($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$Cliente_p->setDUI($_POST['dui'])) {
                    $result['exception'] = 'dui incorrecta';
                } elseif (!$Cliente_p->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'correo incorrecto';
                } elseif (!$Cliente_p->setapellidos($_POST['apellido'])) {
                    $result['exception'] = 'apellido incorrecto';
                } elseif (!$Cliente_p->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'telefono incorrecto';
                }elseif (!$Cliente_p->setNacimiento($_POST['nacimiento'])) {
                    $result['exception'] = 'nacimiento incorrecto';
                } elseif (!$Cliente_p->setdireccion($_POST['direccion'])) {
                    $result['exception'] = 'direccion incorrecto';
                }elseif (!$Cliente_p->setEstado(isset($_POST['toggler-1']) ? 1 : 0)) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif ($Cliente_p->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Se ha creado, correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readOne':
                if (!$Cliente_p->setid_cliente($_POST['id_cliente'])) {
                    $result['exception'] = 'cliente incorrecto';
                } elseif ($result['dataset'] = $Cliente_p->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Producto inexistente';
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$Cliente_p->setid_cliente($_POST['id'])) {
                    $result['exception'] = 'Cliente_p incorrecto';
                } elseif (!$data = $Cliente_p->readOne()) {
                    $result['exception'] = 'Cliente_p inexistente';
                } elseif (!$Cliente_p->setNombres($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$Cliente_p->setDUI($_POST['dui'])) {
                    $result['exception'] = 'Descripción incorrecta';
                } elseif (!$Cliente_p->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Precio incorrecto';
                } elseif (!$Cliente_p->setapellidos($_POST['apellido'])) {
                    $result['exception'] = 'Seleccione una apellido';
                } elseif (!$Cliente_p->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'Seleccione una apellido';
                } elseif (!$Cliente_p->setNacimiento($_POST['nacimiento'])) {
                    $result['exception'] = 'Seleccione una apellido';
                } elseif (!$Cliente_p->setdireccion($_POST['direccion'])) {
                    $result['exception'] = 'Seleccione una apellido';
                } elseif (!$Cliente_p->setEstado(isset($_POST['toggler-1']) ? 1 : 0)) {
                    $result['exception'] = 'Estado incorrecto';
                }  elseif ($Cliente_p->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Se ha actualizado, correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$Cliente_p->setid_cliente($_POST['id_cliente'])) {
                    $result['exception'] = 'Producto incorrecto';
                } elseif (!$data = $Cliente_p->readOne()) {
                    $result['exception'] = 'Producto inexistente';
                } elseif ($Cliente_p->deleteRow()) {
                    $result['status'] = 1;
                        $result['message'] = 'Producto eliminado correctamente';
                } else{ 
                    $result['exception'] = Database::getException();
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
