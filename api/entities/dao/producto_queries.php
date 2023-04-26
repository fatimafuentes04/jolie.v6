<?php
require_once('../../helpers/database.php');


 /*funcion para leer datos*/
    class ProductoQueries
    {


    public function readAll(){
        $sql = 'SELECT id_producto, categoria, nombre_producto, descripcion_producto, precio_producto, imagen_producto, estado_producto, nombre_usuario, talla, imagen
        FROM producto
        INNER JOIN categoria USING(id_categoria)
        INNER JOIN estado_producto USING(idestado_producto)
        INNER JOIN usuario USING(id_usuario)
        INNER JOIN talla USING(id_talla)
        INNER JOIN imagen USING(id_imagen)';
        return Database::getRows($sql);
    }

        /*funcion para leer datos*/    
    public function deleteRow()
    {
        $sql = 'DELETE FROM producto
                WHERE id_producto = ?';
        $params = array($this->id_producto);
        return Database::executeRow($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT id_producto, id_categoria, categoria, nombre_producto, descripcion_producto, precio_producto, imagen_producto, idestado_producto, estado_producto, id_usuario, usuario, id_talla, talla, id_imagen, imagen 
                FROM producto
                INNER JOIN categoria USING(id_categoria)
                INNER JOIN estado_producto USING(idestado_producto)
                INNER JOIN usuario USING(id_usuario)
                INNER JOIN talla USING(id_talla)
                INNER JOIN imagen USING(id_imagen)
                WHERE id_producto = ?';
        $params = array($this->id_producto);
        return Database::getRow($sql, $params);
    }

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
 