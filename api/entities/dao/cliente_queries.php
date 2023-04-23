<?php
require_once('../../helpers/database.php');


 /*funcion para leer datos*/
    class clientesQueries{
    public function readAll(){
        $sql = 'SELECT * FROM cliente ORDER BY id_cliente';
        return Database::getRows($sql);
    }

     /*funcion para eliminar datos*/
    // public function deleteRow()
    // {
    //     $sql = 'DELETE FROM cliente
    //             WHERE id_cliente = ?';
    //     $params = array($this->id_cliente);
    //     return Database::executeRow($sql, $params);
    // }

     /*funcion para leer datos*/
    public function readOne()
    {
        $sql = 'SELECT * FROM cliente
                WHERE id_cliente = ?';
        $params = array($this->id_cliente);
        return Database::getRow($sql, $params);
    }

 /*funcion para crear insercion*/
/*
    public function createRow()
    {
        $sql = 'INSERT INTO productos(nombre_producto, descripcion, precio, id_editorial, id_categoria, estado_producto, id_usuario, id_autor, procentaje_descuento, isbn, imagen, stock)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre_producto, $this->descripcion, $this->precio, $this->editorial, $this->id_categoria, $this->estado_producto, $this->id_usuario, $this->id_autor, $this->porcentaje_descuento,$this->isbn,$this->imagen,$this->stock, $_SESSION['id_usuario']);
        return Database::getException($sql, $params);
    }
    */
}
 