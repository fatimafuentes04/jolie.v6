<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad USUARIO.
*/
class UsuarioQueries
{
    /*
    *   Métodos para gestionar la cuenta del usuario. si les muestra error en el id_usuario o algo mas es porque casi siempre muestra el error pero siempre sigue funcionando 
    */
    public function checkUser($nombre)
    {
        $sql = 'SELECT id_usuario FROM usuarios WHERE correo_electronico = ?';
        $params = array($nombre);
        if ($data = Database::getRow($sql, $params)) {
            $this->id_usuario = $data['id_usuario'];
            $this->correo_electronico = $nombre;
            return true;
        } else {
            return false;
        }
    }

    public function checkPassword($password)
    {
        $sql = 'SELECT clave FROM usuarios WHERE id_usuario = ?';
        $params = array($this->id_usuario);
        $data= Database::getRow($sql,$params);
        if ($password==$data['clave']) {
        return true;
        }else{
        return false;
        }
    }

    public function changePassword()
    {
        $sql = 'UPDATE usuarios SET clave = ? WHERE id_usuario = ?';
        $params = array($this->clave, $_SESSION['id_usuario']);
        return Database::executeRow($sql, $params);
    }

    public function readProfile()
    {
        $sql = 'SELECT id_usuario, nombre, telefono, correo_electronico, direccion, clave
                FROM usuarios
                WHERE id_usuario = ?';
        $params = array($_SESSION['id_usuario']);
        return Database::getRow($sql, $params);
    }

    public function editProfile()
    {
        $sql = 'UPDATE usuarios
                SET nombre = ?, telefono = ?, correo_electronico = ?, direccion = ?
                WHERE id_usuario = ?';
        $params = array($this->nombre, $this->telefono, $this->correo_electronico, $this->direccion, $_SESSION['id_usuario']);
        return Database::executeRow($sql, $params);
    }

    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    /*
    public function searchRows($value)
    {
        $sql = 'SELECT id_usuario, nombres_usuario, apellidos_usuario, correo_usuario, alias_usuario
                FROM usuarios
                WHERE apellidos_usuario ILIKE ? OR nombres_usuario ILIKE ?
                ORDER BY apellidos_usuario';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }
    */
/*
    public function createRow()
    {
        $sql = 'INSERT INTO usuarios(nombres_usuario, apellidos_usuario, correo_usuario, alias_usuario, clave_usuario)
                VALUES(?, ?, ?, ?, ?)';
        $params = array($this->nombres, $this->apellidos, $this->correo, $this->alias, $this->clave);
        return Database::executeRow($sql, $params);
    }
*/
public function readAll(){
    $sql = 'SELECT * FROM usuarios ORDER BY id_usuario';
    return Database::getRows($sql);
}

public function readOne()
{
    $sql = 'SELECT * FROM usuarios
            WHERE id_usuario = ?';
    $params = array($this->id_usuario);
    return Database::getRow($sql, $params);
}

 
public function deleteRow()
{
    $sql = 'DELETE FROM usuarios
            WHERE id_usuario = ?';
    $params = array($this->id_usuario);
    return Database::executeRow($sql, $params);
}
}
