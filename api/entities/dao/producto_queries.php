<?php
require_once('../../helpers/database.php');


/*funcion para leer datos desde la base de datos*/
class ProductoQueries
{
    public function readAll()
    {
        $sql = 'SELECT id_producto, categoria, nombre_producto, descripcion_producto, precio_producto, imagen_producto, estado_producto, nombre_usuario, talla, imagen
        FROM producto
        INNER JOIN categoria USING(id_categoria)
        INNER JOIN estado_producto USING(idestado_producto)
        INNER JOIN usuario USING(id_usuario)
        INNER JOIN talla USING(id_talla)
        INNER JOIN imagen USING(id_imagen)
        ORDER BY id_producto';
        return Database::getRows($sql);
    }

    //Funcion para eliminar un registro
    public function deleteRow()
    {
        $sql = 'DELETE FROM producto
                WHERE id_producto = ?';
        $params = array($this->id_producto);
        return Database::executeRow($sql, $params);
    }
    
     /*funcion para lectura de datos*/
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

     /*funcion para crear insercion*/
    public function createRow()
    {
        $sql = 'INSERT INTO producto(id_categoria, nombre_producto, descripcion_producto, precio_producto, imagen_producto, idestado_producto, id_usuario, id_talla, id_imagen)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->id_categoria, $this->nombre_producto, $this->descripcion, $this->precio, $this->imagen, $this->estado_producto, $this->id_usuario, $this->id_talla, $this->imgcarucel);
        return Database::executeRow($sql, $params);
    }

     /*funcion para actualizar producto*/
    public function updateRow()
    {
        $sql = 'UPDATE producto SET id_categoria = ?, nombre_producto = ?, descripcion_producto = ?, precio_producto = ?, imagen_producto = ?, idestado_producto = ?, id_usuario = ?, id_talla = ?, id_imagen = ? WHERE id_producto = ? ';
        $params = array($this->id_categoria, $this->nombre_producto, $this->descripcion, $this->precio, $this->imagen, $this->estado_producto, $this->id_usuario, $this->id_talla, $this->imgcarucel, $this->id_producto);
        return Database::executeRow($sql, $params);
    }

    /*cargar combox */

    //leer categoria
    public function readCategoria()
    {
        $sql = 'SELECT id_categoria, categoria FROM categoria';
        return Database::getRows($sql);
    }
    //leer estado
    public function readEstado()
    {
        $sql = 'SELECT idestado_producto, estado_producto FROM estado_producto';
        return Database::getRows($sql);
    }
    //leer talla
    public function readTalla()
    {
        $sql = 'SELECT id_talla, talla FROM talla';
        return Database::getRows($sql);
    }
    //leer usuario
    public function readUsuario()
    {
        $sql = 'SELECT id_usuario, usuario FROM usuario';
        return Database::getRows($sql);
    }
    //leer imagen
    public function readImagen()
    {
        $sql = 'SELECT id_imagen, imagen FROM imagen';
        return Database::getRows($sql);
    }   
    //GRAFICAS
    public function cantidadProductosCategoria()
    {
        $sql = 'SELECT categoria, COUNT(id_producto) cantidad
                FROM producto
                INNER JOIN categoria USING(id_categoria)
                GROUP BY categoria ORDER BY cantidad DESC';
        return Database::getRows($sql);
    }

    public function porcentajeProductosCategoria()
    {
        $sql = 'SELECT talla, COUNT(id_producto) cantidad
        FROM producto
        INNER JOIN talla USING(id_talla)
        GROUP BY talla ORDER BY cantidad DESC';
        return Database::getRows($sql);
    }

    public function Productos_mas_baratos()
    {
        $sql = 'SELECT usuario, COUNT(idtipo_usuario) cantidad
        FROM usuario
        INNER JOIN tipo_usuario USING(idtipo_usuario)
        GROUP BY usuario ORDER BY cantidad DESC LIMIT 4';
        return Database::getRows($sql);
    }

    public function Productos_mas_caros()
    {
        $sql = 'SELECT producto, COUNT(id_imagen) cantidad
        FROM producto
        INNER JOIN imagen USING(id_imagen)
        GROUP BY producto ORDER BY cantidad DESC LIMIT 6';
        return Database::getRows($sql);
    }

    public function Suma_de_productos()
    {
        $sql = 'SELECT producto.nombre_producto, SUM(detalle_pedido.cantidad) as cantidad
        FROM detalle_pedido JOIN producto USING(id_producto)
        GROUP BY nombre_producto
        ORDER BY SUM(detalle_pedido.cantidad)DESC LIMIT 5';
        return Database::getRows($sql);
    }
}
