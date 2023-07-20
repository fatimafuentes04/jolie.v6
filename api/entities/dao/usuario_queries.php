<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad USUARIO.
*/
class UsuarioQueries
{
     /*funcion para lectura de  datos*/
    public function readAll()
    {
        $sql = 'SELECT id_usuario, nombre_usuario, apellido_usuario, usuario, clave_usuario, estado_usuario, idtipo_usuario
        FROM public.usuario ORDER BY id_usuario; ';
        // INNER JOIN tipo_usuario USING(idtipo_usuario)
        return Database::getRows($sql);
    }

    /*
    *   Métodos para gestionar la cuenta del usuario 
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

     /*funcion para verificar contraseña*/
    public function checkPassword($password)
    {
        $sql = 'SELECT clave_usuario FROM usuario WHERE id_usuario = ?';
        $params = array($this->id_usuario);
        $data = Database::getRow($sql, $params);
        if ($password == $data['clave_usuario']) {
            return true;
        } else {
            return false;
        }
    }

    //funcion para actualizar clave de la cuenta
    public function changePassword()
    {
        $sql = 'UPDATE usuario SET clave_usuario = ? WHERE id_usuario = ?';
        $params = array($this->clave, $_SESSION['id_usuario']);
        return Database::executeRow($sql, $params);
    }

    // public function readProfile()
    // {
    //     $sql = 'SELECT id_usuario, nombre_usuario, apellido_usuario, usuario, clave_usuario, estado_usuario, idtipo_usuario
    //             FROM usuario
    //             WHERE id_usuario = ?';
    //     $params = array($_SESSION['id_usuario']);
    //     return Database::getRow($sql, $params);
    // }

     /*funcion para actualizar usuario*/
    public function updateRow()
    {
        $sql = 'UPDATE usuario
                SET nombre_usuario = ?, apellido_usuario = ?, usuario = ?, clave_usuario = ?, estado_usuario = ?, idtipo_usuario = ?
                WHERE id_usuario = ?';
        $params = array($this->nombre_usuario, $this->apellido_usuario, $this->usuario, $this->clave_usuario, $this->estado_usuario, $this->idtipo_usuario, $this->id_usuario);
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


    /**Funcion para cargar combobox */
    public function readTipo()
    {
        $sql = 'SELECT idtipo_usuario, tipo_usuario FROM tipo_usuario';
        return Database::getRows($sql);
    }



    /**Metodo para crear usuario */
    public function createRow()
    {
        $sql = 'INSERT INTO usuario (nombre_usuario, apellido_usuario, usuario, clave_usuario, estado_usuario, idtipo_usuario)
                VALUES(?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre_usuario, $this->apellido_usuario, $this->usuario, $this->clave_usuario, $this->estado_usuario, $this->idtipo_usuario);
        return Database::executeRow($sql, $params);
    }


     /*funcion para lectura de usuario*/
    public function readOne()
    {
        $sql = 'SELECT * FROM usuario
            WHERE id_usuario = ?';
        $params = array($this->id_usuario);
        return Database::getRow($sql, $params);
    }

     /*funcion para eliminar usuario*/
    public function deleteRow()
    {
        $sql = 'DELETE FROM usuario
            WHERE id_usuario = ?';
        $params = array($this->id_usuario);
        return Database::executeRow($sql, $params);
    }
}
