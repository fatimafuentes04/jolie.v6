<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/estadopedido_queries.php');

/*
*	Clase para manejar la transferencia de datos de la entidad USUARIO.
*/
class EstadoPedido extends EstadoPedidoQueries

{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $estadopedido = null;

     /*
    *   Métodos para validar y asignar valores de los atributos.
    */
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

    /*
    *   Métodos para obtener valores de los atributos.
    */
    public function getId()
    {
        return $this->id;
    }

    public function getEstadoPedido()
    {
        return $this->estadopedido;
    }
}
