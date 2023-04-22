<?php
require_once('../../helpers/database.php');


 /*funcion para leer datos*/
    class ProductoQueries{
    public function readAll(){
        $sql = 'SELECT * FROM producto ORDER BY id_producto';
        return Database::getRows($sql);
    }

     /*funcion para eliminar datos*/
    public function deleteRow()
    {
        $sql = 'DELETE FROM productos
                WHERE id_producto = ?';
        $params = array($this->id_producto);
        return Database::executeRow($sql, $params);
    }

     /*funcion para leer datos*/
    public function readOne()
    {
        $sql = 'SELECT * FROM producto
                WHERE id_producto = ?';
        $params = array($this->id_producto);
        return Database::getRow($sql, $params);
    }
 /*cargar combox */

public function readCategorias (){
    $sql = 'SELECT id_categoria, nombre_categoria FROM categorias';
    return Database::getRows($sql);
}
public function readEditoriales(){
    $sql = 'SELECT id_editorial, nombre_editorial FROM editoriales';
    return Database::getRows($sql);
}
public function readUsuarios (){
    $sql = 'SELECT id_usuario, nombre FROM usuario';
    return Database::getRows($sql);
}
public function readAutores(){
    $sql = 'SELECT id_autor, nombre_autor FROM autores';
    return Database::getRows($sql);
}

 /*funcion para crear insercion*/

    public function createRow()
    {
        $sql = 'INSERT INTO productos(nombre_producto, descripcion, precio, id_editorial, id_categoria, estado_producto, id_usuario, id_autor, procentaje_descuento, isbn, imagen, stock)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre_producto, $this->descripcion, $this->precio, $this->editorial, $this->id_categoria, $this->estado_producto, $this->id_usuario, $this->id_autor, $this->porcentaje_descuento,$this->isbn,$this->imagen,$this->stock, $_SESSION['id_usuario']);
        return Database::getException($sql, $params);
    }
}
 