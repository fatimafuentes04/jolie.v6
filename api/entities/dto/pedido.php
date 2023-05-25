
<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/pedido_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad USUARIO.
*/
class Pedido extends PedidoQueries
{
    // Declaración de atributos pedido (propiedades).
    protected $id_pedido = null;
    //Detalle pedido parametro
    protected $iddetalle = null;
    protected $idestado_pedido = null;
    protected $fecha_pedido = null;
    protected $direccion_pedido = null;
    protected $cliente = null;

        //Atributos de detalle pedido
    protected $id_producto = null;
    protected $cantidad = null;
    protected $precio_producto = null;


    /*
    *   Métodos para validar y asignar valores de los atributos.
    */
    public function setIddetalle($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->iddetalle = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setid_pedido($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_pedido = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEstadoPedido($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->idestado_pedido = $value;
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

    public function setcantidad($value)
    {
        if (Validator::validateString($value, 1, 200)) {
            $this->cantidad = $value;
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

    public function setid_producto($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_producto = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setprecio_producto($value)
    {
        if (Validator::validateString($value, 1, 200)) {
            $this->precio_producto = $value;
            return true;
        } else {
            return false;
        }
    }


      /*
    *   Métodos para obtener valores de los atributos.
    */
    public function getid_pedido()
    {
        return $this->id_pedido;
    }

    public function getIddetalle()
    {
        return $this->iddetalle;
    }

    public function getEstadoPedido()
    {
        return $this->idestado_pedido;
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

    public function getid_producto()
    {
        return $this->id_producto;
    }

    public function getcantidad()
    {
        return $this->cantidad;
    }

    public function getprecio_producto()
    {
        return $this->precio_producto;
    }
}
