<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad USUARIO.
*/
class UsuarioQueries
{
    public function readAll(){
        $sql = 'SELECT * FROM detalle_pedido ORDER BY id_detalle';
        return Database::getRows($sql);
    }

    
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


    /**Funci'on para cargar combobox */
    public function readEstado(){
        $sql='SELECT id_estado, estado FROM estado';
        return Database::getRow($sql);
    }

   

    /**Metodo para crear usuario */
    public function createRow()
    {
        $sql = 'INSERT INTO usuarios(nombre_usuario, apellido_usuario, usuario, clave_usuario, estado_usuario, idtipo_usuario)
                VALUES(?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre_usuario, $this->apellido_usuario, $this->usuario, $this->clave_usuario, $this->estado_usuario, $this->idtipo_usuario);
        return Database::executeRow($sql, $params);
    }



public function readOne()
{
    $sql = 'SELECT * FROM detalle_pedido
            WHERE id_detalle = ?';
    $params = array($this->id_detalle);
    return Database::getRow($sql, $params);
}

 
public function deleteRow()
{
    $sql = 'DELETE FROM detalle_pedido
            WHERE is_detalle = ?';
    $params = array($this->id_detalle);
    return Database::executeRow($sql, $params);
}
}
