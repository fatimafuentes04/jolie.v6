<?php
require_once('../../helpers/database.php');

class PedidoQueries
{
    /*
    *   Métodos para realizar las operaciones de buscar(search) de pedido
    */


     /*funcion para lectura de datos*/
    public function readAll()
    {
        $sql = 'SELECT id_pedido, fecha_pedido, direccion_pedido, nombre_cliente, estado_pedido
        FROM pedido
        INNER JOIN cliente USING(id_cliente)
        INNER JOIN estado_pedido USING(idestado_pedido)
        ORDER BY id_pedido';
        return Database::getRows($sql);
    }

     /*funcion para buscar datos de pedido*/
    public function searchRows($value)
    {
        $sql = 'SELECT id_pedido,  nombre_cliente, fecha_pedido, direccion_pedido, estado_pedido
        FROM pedido
        INNER JOIN cliente USING(id_cliente)
        INNER JOIN estado_pedido USING(idestado_pedido)
        WHERE nombre_cliente ILIKE ? OR fecha_pedido::text ILIKE ? OR direccion_pedido ILIKE ? OR estado_pedido ILIKE ?';
        $params = array("%$value%", "%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

     /*funcion para lectura de datos*/
    public function readOne()
    {
        $sql = 'SELECT id_pedido, fecha_pedido, direccion_pedido, idestado_pedido, id_cliente
        FROM pedido 
        INNER JOIN cliente USING(id_cliente)
        INNER JOIN estado_pedido USING(idestado_pedido)
        WHERE id_pedido=?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

     /*funcion para eliminar pedido*/
    public function deleteRow()
    {
        $sql = 'DELETE FROM pedido 
              WHERE id_pedido = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

     /*funcion para crear insercion*/
    public function createRow()
    {
        $sql = 'INSERT INTO pedido(fecha_pedido, direccion_pedido, idestado_pedido, id_cliente)
            VALUES (?, ?, ?, ?)';
        $params = array($this->fecha_pedido, $this->direccion_pedido, $this->estado_pedido, $this->cliente);
        return Database::executeRow($sql, $params);
    }

     /*funcion para actualizar pedido*/
    public function updateRow()
    {
        $sql = 'UPDATE pedido
                SET  id_cliente=?, fecha_pedido =?, direccion_pedido =?, idestado_pedido =?
                WHERE id_pedido = ?';
        $params = array($this->cliente, $this->fecha_pedido, $this->direccion_pedido, $this->estado_pedido, $this->id);
        return Database::executeRow($sql, $params);
    }

    //Detalle pedido CAMBIAR
    public function readAllDetallePedido()
    {
        $sql = 'SELECT d.id_detalle, d.id_pedido, v.nombre_producto, d.cantidad, d.precio_producto
        from detalle_pedido d
        inner join producto v using (id_producto)
        where id_pedido = ?';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }

    //Detalle pedido CAMBIAR
    public function readOneDetallePedido()
    {
        $sql = 'SELECT * FROM detalle_pedido
        WHERE id_detalle = ?';
        $params = array($this->iddetalle);
        return Database::getRow($sql, $params);
    }

    // Método para verificar si existe un pedido en proceso para seguir comprando, de lo contrario se crea uno.
    public function startOrder()
    {
        $sql = 'SELECT id_pedido
        FROM pedido
        WHERE idestado_pedido = 1 AND id_cliente = ?';
        $params = array($_SESSION['id_cliente']);
        if ($data = Database::getRow($sql, $params)) {
            $this->id_pedido = $data['id_pedido'];
            return true;
        } else {
            $sql = 'INSERT INTO pedido(direccion_pedido, id_cliente)
            VALUES((SELECT direccion_cliente FROM cliente WHERE id_cliente = ?), ?)';
            $params = array($_SESSION['id_cliente'], $_SESSION['id_cliente']);
            // Se obtiene el ultimo valor insertado en la llave primaria de la tabla pedidos.
            if ($this->id_pedido = Database::getLastRow($sql, $params)) {
                return true;
            } else {
                return false;
            }
        }
    }

    // Método para agregar un producto al carrito de compras.
    public function createDetail()
    {
        // Se realiza una subconsulta para obtener el precio del producto.
        $sql = 'INSERT INTO detalle_pedido(id_producto, precio_producto, cantidad, id_pedido)
        VALUES(?, (SELECT precio_producto FROM producto WHERE id_producto = ?), ?, ?)';
        $params = array($this->id_producto, $this->id_producto, $this->cantidad, $this->id_pedido);
        return Database::executeRow($sql, $params);
    }

    // Método para obtener los productos que se encuentran en el carrito de compras.
    public function readOrderDetail()
    {
        $sql = 'SELECT id_detalle, nombre_producto, producto.precio_producto, producto.imagen_producto, detalle_pedido.cantidad
        FROM pedido INNER JOIN detalle_pedido USING(id_pedido) INNER JOIN producto USING(id_producto)
        WHERE id_pedido = ?';
        $params = array($this->id_pedido);
        return Database::getRows($sql, $params);
    }

    // Método para finalizar un pedido por parte del cliente.
    public function finishOrder()
    {
        // Se establece la zona horaria local para obtener la fecha del servidor.
            date_default_timezone_set('America/El_Salvador');
            $date = date('Y-m-d');
        $this->id_estadopedido = 2;
        $sql = 'UPDATE pedidos SET  id_estadopedido = ?, fecha_pedido = ? where id_pedido = ?';
        $params = array($this->id_estadopedido, $date, $_SESSION['id_pedido']);
        return Database::executeRow($sql, $params);
    }

    // Método para actualizar la cantidad de un producto agregado al carrito de compras.
    public function updateDetail()
    {
        $sql = 'UPDATE detalles_pedidos
                SET cantidad_producto = ?
                WHERE id_detallepedido = ? AND id_pedido = ?';
        $params = array($this->cantidad, $this->id_detallepedido, $_SESSION['id_pedido']);
        return Database::executeRow($sql, $params);
    }

    // Método para eliminar un producto que se encuentra en el carrito de compras.
    public function deleteDetail()
    {
        $sql = 'DELETE FROM detalles_pedidos
                WHERE id_detallepedido = ? AND id_pedido = ?';
        $params = array($this->id_detallepedido, $_SESSION['id_pedido']);
        return Database::executeRow($sql, $params);
    }
}
