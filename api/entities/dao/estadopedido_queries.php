<?php
require_once('../../helpers/database.php');

class EstadoPedidoQueries
{

     /*funcion para leer el estado de un pedido*/
    public function readAll()
    {
        $sql = 'SELECT idestado_pedido, estado_pedido
        FROM estado_pedido';
        return Database::getRows($sql);
    }
}
