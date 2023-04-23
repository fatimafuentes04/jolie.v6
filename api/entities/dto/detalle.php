<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/detalle_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad USUARIO.
*/
class Usuario extends UsuarioQueries
{
    // Declaración de atributos (propiedades).
    protected $id_detalle = null;
    protected $id_pedido = null;
    protected $id_producto = null;   
    protected $cantidad = null;
    protected $precio_producto = null;
  
    /*
    *   Métodos para validar y asignar valores de los atributos.
    */
    public function setId_detalle($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_detalle = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setId_pedido($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_pedido = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setId_producto($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_producto = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCantidad($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->cantidad = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setPrecio_producto($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->precio_producto = $value;
            return true;
        } else {
            return false;
        }
    }


    /*
    *   Métodos para obtener valores de los atributos.
    */
    public function getId_detalle()
    {
        return $this->id_detalle;
    }

    public function getId_pedido()
    {
        return $this->id_pedido;
    }

    public function getId_producto()
    {
        return $this->id_producto;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function getPrecio_producto()
    {
        return $this->precio_producto;
    }


    
}
