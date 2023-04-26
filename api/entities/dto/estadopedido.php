<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/estadopedido_queries.php');

class EstadoPedido extends EstadoPedidoQueries

{
    protected $id = null;
    protected $estadopedido = null;

    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEstadoPedido($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->estadopedido = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEstadoPedido()
    {
        return $this->estadopedido;
    }

}
