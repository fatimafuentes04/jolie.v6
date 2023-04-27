<?php
require_once('../../helpers/database.php');


/*funcion para leer datos*/
class clientesQueries
{
    public function readAll()
    {
        $sql = 'SELECT * FROM cliente ORDER BY id_cliente';
        return Database::getRows($sql);
    }

    /*funcion para eliminar datos*/
    public function deleteRow()
    {
        $sql = 'DELETE FROM cliente
                WHERE id_cliente = ?';
        $params = array($this->id_cliente);
        return Database::executeRow($sql, $params);
    }

    /*funcion para leer datos*/
    public function readOne()
    {
        $sql = 'SELECT * FROM cliente
                WHERE id_cliente = ?';
        $params = array($this->id_cliente);
        return Database::getRow($sql, $params);
    }

    /*funcion para crear insercion*/

    public function createRow()
    {
        $sql = 'INSERT INTO cliente (nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, nacimiento_cliente, direccion_cliente, estado_cliente)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre_cliente, $this->apellido_cliente, $this->dui_cliente, $this->correo_cliente, $this->telefono_cliente, $this->nacimiento_cliente, $this->direccion_cliente, $this->estado_cliente);
        return Database::executeRow($sql, $params);
    }

     /*funcion para actualizar cliente*/
    public function updateRow()
    {
        $sql = 'UPDATE cliente SET nombre_cliente = ? , apellido_cliente = ?, dui_cliente = ?, correo_cliente = ?, telefono_cliente = ?, nacimiento_cliente = ?, direccion_cliente = ?, estado_cliente = ? WHERE id_cliente = ? ';
        $params = array($this->nombre_cliente, $this->apellido_cliente, $this->dui_cliente, $this->correo_cliente, $this->telefono_cliente, $this->nacimiento_cliente, $this->direccion_cliente, $this->estado_cliente, $this->id_cliente);
        return Database::executeRow($sql, $params);
    }

         /*funcion para buscar cliente*/
    public function searchRows($value)
    {
        $sql = 'SELECT id_cliente,  nombre_cliente, apellido_cliente, dui_cliente, correo_cliente
        FROM cliente
        WHERE nombre_cliente ILIKE ? OR apellido_cliente::text ILIKE ? OR dui_cliente ILIKE ? OR correo_cliente ILIKE ?';
        $params = array("%$value%", "%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }
}
