<?php
require_once('../../helpers/database.php');


/*funcion para leer datos*/
class clientesQueries
{
    public function readAll()
    {
        $sql = 'SELECT id_cliente, nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, nacimiento_cliente, direccion_cliente, estado_cliente, clave
        FROM public.cliente ORDER BY id_cliente;';
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

    //funcion para crear una nueva cuenta
    public function createCuenta()
    {
        $sql = " INSERT INTO cliente(nombre_cliente, apellido_cliente, correo_cliente, direccion_cliente, numero_doc, direccion, clave)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
        $params = array($this->nombre_cliente, $this->apellido_cliente, $this->correo_cliente, $this->dui_cliente, $this->telefono_cliente, $this->direccion_cliente, $this->clave);
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

    //funcion para verificar la credencial de usuario con la base de datos
    public function checkUser($correo)
    {
        $sql = 'SELECT id_cliente, estado_cliente FROM cliente WHERE nombre_cliente = ?';
        $params = array($correo);
        if ($data = Database::getRow($sql, $params)) {
            $this->id_cliente = $data['id_cliente'];
            $this->estado_cliente = $data['estado_cliente'];
            $this->nombre_cliente = $correo;
            return true;
        } else {
            return false;
        }
    }

    //funcion para verificar que la clave coincida con el registro de la base de datos
    public function checkPassword($password)
    {
        $sql = 'SELECT clave FROM cliente WHERE id_cliente = ?';
        $params = array($this->id_cliente);
        $data= Database::getRow($sql,$params);
        if ($password==$data['clave']) {
        return true;
        }else{
        return false;
    }
    
}

}
