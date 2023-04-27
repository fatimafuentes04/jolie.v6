<?php
require_once('../../helpers/database.php');

class PedidoQueries
{
    /*
    *   Métodos para realizar las operaciones de buscar(search) de pedido
    */


    public function readAll()
    {
        $sql = 'SELECT id_pedido, fecha_pedido, direccion_pedido, nombre_cliente, estado_pedido
        FROM pedido
        INNER JOIN cliente USING(id_cliente)
        INNER JOIN estado_pedido USING(idestado_pedido)
        ORDER BY id_pedido';
        return Database::getRows($sql);
    }

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

    public function deleteRow()
    {
        $sql = 'DELETE FROM pedido 
              WHERE id_pedido = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO pedido(fecha_pedido, direccion_pedido, idestado_pedido, id_cliente)
            VALUES (?, ?, ?, ?)';
        $params = array($this->fecha_pedido, $this->direccion_pedido, $this->estado_pedido, $this->cliente);
        return Database::executeRow($sql, $params);
    }

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
}
