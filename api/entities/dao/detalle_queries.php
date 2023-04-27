<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad USUARIO.
*/
class DetalleQueries
{
     /*funcion para lectura de datos*/
    public function readAll()
    {
        $sql = 'SELECT * FROM detalle_pedido ORDER BY id_detalle';
        return Database::getRows($sql);
    }

     /*funcion para eliminar detalle pedido*/
    public function deleteRow()
    {
        $sql = 'DELETE FROM detalle_pedido
            WHERE id_detalle = ?';
        $params = array($this->id_detalle);
        return Database::executeRow($sql, $params);
    }

     /*funcion para lectura de datos*/
    public function readOne()
    {
        $sql = 'SELECT * FROM detalle_pedido
            WHERE id_detalle = ?';
        $params = array($this->id_detalle);
        return Database::getRow($sql, $params);
    }

         /*funcion para lectura de datos*/
    public function readProducto()
    {
        $sql = 'SELECT id_producto, nombre_producto FROM producto';
        return Database::getRows($sql);
    }


         /*funcion para lectura de datos de pedido*/
    public function readPedido()
    {
        $sql = 'SELECT id_pedido FROM pedido';
        return Database::getRows($sql);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO detalle_pedido (id_pedido, id_producto, cantidad, precio_producto)
            VALUES(?, ?, ?, ?)';
        $params = array($this->id_pedido, $this->id_producto, $this->cantidad, $this->precio_producto);
        return Database::executeRow($sql, $params);
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




    /**Metodo para crear usuario */
}
