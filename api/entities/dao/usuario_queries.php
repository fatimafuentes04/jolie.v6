<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad USUARIO.
*/
class UsuarioQueries
{
    public function readAll(){
        $sql = 'SELECT id_usuario, nombre_usuario, apellido_usuario, usuario, clave_usuario, estado_usuario, tipo_usuario
        FROM usuario
        INNER JOIN tipo_usuario USING(idtipo_usuario)';
        return Database::getRows($sql);
    }

    /*
    *   Métodos para gestionar la cuenta del usuario. si les muestra error en el id_usuario o algo mas es porque casi siempre muestra el error pero siempre sigue funcionando 
    */
    public function checkUser($usuario)
    {
        $sql = 'SELECT id_usuario FROM usuario WHERE usuario = ?';
        $params = array($usuario);
        if ($data = Database::getRow($sql, $params)) {
            $this->id_usuario = $data['id_usuario'];
            $this->usuario = $usuario;
            return true;
        } else {
            return false;
        }
    }

    public function checkPassword($password)
    {
        $sql = 'SELECT clave_usuario FROM usuario WHERE id_usuario = ?';
        $params = array($this->id_usuario);
        $data= Database::getRow($sql,$params);
        if ($password==$data['clave_usuario']) {
        return true;
        }else{
        return false;
        }
    }
/* 
    public function changePassword()
    {
        $sql = 'UPDATE usuario SET clave_usuario = ? WHERE id_usuario = ?';
        $params = array($this->clave, $_SESSION['id_usuario']);
        return Database::executeRow($sql, $params);
    }

    public function readProfile()
    {
        $sql = 'SELECT id_usuario, nombre_usuario, apellido_usuario, usuario, clave_usuario, estado_usuario, idtipo_usuario
                FROM usuario
                WHERE id_usuario = ?';
        $params = array($_SESSION['id_usuario']);
        return Database::getRow($sql, $params);
    }

    public function editProfile()
    {
        $sql = 'UPDATE usuario
                SET nombre_usuario = ?, apellido_usuario = ?, usuario = ?, clave_usuario = ?estado_usuario, idtipo_usuario = ?
                WHERE id_usuario = ?';
        $params = array($this->nombre_usuario, $this->apellido_usuario, $this->usuario, $this->clave_usuario,, $this->estado_usuario, $this->idtipo_usuario, $_SESSION['id_usuario']);
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


public function readOne()
{
    $sql = 'SELECT * FROM usuario
            WHERE id_usuario = ?';
    $params = array($this->id_usuario);
    return Database::getRow($sql, $params);
}

 
public function deleteRow()
{
    $sql = 'DELETE FROM usuario
            WHERE id_usuario = ?';
    $params = array($this->id_usuario);
    return Database::executeRow($sql, $params);
}
}
