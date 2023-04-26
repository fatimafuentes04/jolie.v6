<?php
require_once('../../entities/dto/usuario.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $usuario = new Usuario;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'username' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'getUser':
                if (isset($_SESSION['usuario'])) {
                    $result['status'] = 1;
                    $result['username'] = $_SESSION['usuario'];
                } else {
                    $result['exception'] = 'Alias de usuario indefinido';
                }
                break;
            case 'logOut':
                if (session_destroy()) {
                    $result['status'] = 1;
                    $result['message'] = 'Sesión eliminada correctamente';
                } else {
                    $result['exception'] = 'Ocurrió un problema al cerrar la sesión';
                }
                break;

            case 'readProfile':
                if ($result['dataset'] = $usuario->readProfile()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Usuario inexistente';
                }
                break;
            case 'editProfile':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->setNombres($_POST['nombre'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$usuario->setApellidos($_POST['apellidos'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                } elseif (!$usuario->setCorreo($_POST['usuario'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$usuario->setAlias($_POST['alias'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif ($usuario->editProfile()) {
                    $result['status'] = 1;
                    $_SESSION['clave'] = $usuario->getAlias();
                    $result['message'] = 'Perfil modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'changePassword':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->setId($_SESSION['id_usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$usuario->checkPassword($_POST['actual'])) {
                    $result['exception'] = 'Clave actual incorrecta';
                } elseif ($_POST['nueva'] != $_POST['confirmar']) {
                    $result['exception'] = 'Claves nuevas diferentes';
                } elseif (!$usuario->setClave($_POST['nueva'])) {
                    $result['exception'] = Validator::getPasswordError();
                } elseif ($usuario->changePassword()) {
                    $result['status'] = 1;
                    $result['message'] = 'Contraseña cambiada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;

            case 'readAll':
                if ($result['dataset'] = $usuario->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
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
                } elseif ($result['dataset'] = $usuario->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
                case 'readTipo':
                    if ($result['dataset'] = $usuario->readTipo()) {
                        $result['status'] = 1;
                        $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                    } elseif (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'No hay datos registrados';
                    }
                    break;
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->setNombre_usuario($_POST['nombre_usuario'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$usuario->setApellido_usuario($_POST['apellido_usuario'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                } elseif (!$usuario->setUsuario($_POST['usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$usuario->setClave_usuario($_POST['clave_usuario'])) {
                    $result['exception'] = Validator::getPasswordError();
                } elseif (!$usuario->setIdtipo_usuario($_POST['idtipo_usuario'])) {
                    $result['exception'] = 'Tipo de usuario incorrecto';
                } elseif (!$usuario->setEstado_usuario(isset($_POST['toggler-1']) ? 1 : 0)) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif ($usuario->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;



            case 'readOne':
                if (!$usuario->setId_usuario($_POST['id_usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif ($result['dataset'] = $usuario->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Usuario inexistente';
                }
                break;

           
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->setId($_POST['id'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$usuario->readOne()) {
                    $result['exception'] = 'Usuario inexistente';
                } elseif (!$usuario->setNombres($_POST['nombres'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$usuario->setApellidos($_POST['apellidos'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                } elseif (!$usuario->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif ($usuario->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if ($_POST['id_usuario'] == $_SESSION['id_usuario']) {
                    $result['exception'] = 'No se puede eliminar a sí mismo';
                } elseif (!$usuario->setid_usuario($_POST['id_usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$usuario->readOne()) {
                    $result['exception'] = 'Usuario inexistente';
                } elseif ($usuario->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario eliminado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
    } else {
        // Se compara la acción a realizar cuando el administrador no ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readUsers':
                if ($usuario->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Debe autenticarse para ingresar';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'signup':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->setNombres($_POST['nombres'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$usuario->setApellidos($_POST['apellidos'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                } elseif (!$usuario->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$usuario->setAlias($_POST['usuario'])) {
                    $result['exception'] = 'Alias incorrecto';
                } elseif ($_POST['codigo'] != $_POST['confirmar']) {
                    $result['exception'] = 'Claves diferentes';
                } elseif (!$usuario->setClave($_POST['codigo'])) {
                    $result['exception'] = Validator::getPasswordError();
                } elseif ($usuario->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario registrado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'login':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->checkUser($_POST['usuario'])) {
                    $result['exception'] = Database::getException();
                } elseif ($usuario->checkPassword($_POST['clave'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Autenticacion correcta';
                    $_SESSION['id_usuario'] = $usuario->getId_usuario();
                    $_SESSION['usuario'] = $usuario->getUsuario();
                } else {
                    $result['exception'] = 'Clave incorrecta';
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible fuera de la sesión';
        }
    }
    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('content-type: application/json; charset=utf-8');
    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result));
} else {
    print(json_encode('Recurso no disponible'));
}
