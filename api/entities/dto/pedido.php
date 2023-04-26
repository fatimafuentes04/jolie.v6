
<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/pedido_queries.php');

class Pedido extends PedidoQueries
{
    protected $id = null;
        //Detalle pedido parametro
    protected $iddetalle = null;
    protected $estado_pedido = null;
    protected $fecha_pedido = null;
    protected $direccion_pedido = null;
    protected $cliente = null;
    

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
        if (Validator::validateBoolean($value)) {
            $this->estado_pedido = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setFechaPedido($value)
    {
        if (Validator::validateDate($value)) {
            $this->fecha_pedido = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDireccionPedido($value)
    {
        if (Validator::validateString($value, 1, 200)) {
            $this->direccion_pedido = $value;
            return true;
        } else {
            return false;
        } 
    }

    public function setCliente($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->cliente = $value;
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
        return $this->estado_pedido;
    }

    public function getDireccionPedido()
    {
        return $this->direccion_pedido;
    }

    public function getFechaPedido()
    {
        return $this->fecha_pedido;
    }

    public function getCliente()
    {
        return $this->cliente;
    }

}
