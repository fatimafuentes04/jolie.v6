<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/cliente_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad PRODUCTO.
*/
class cliente extends clientesQueries
{
    // Declaración de atributos (propiedades).
    protected $id_cliente = null;
    protected $nombres_cliente = null;
    protected $apellidos_cliente = null;
    protected $dui_cliente = null;
    protected $correo_cliente = null;
    protected $telefono_cliente = null;
    protected $nacimiento_cliente = null;
    protected $direccion_cliente = null;
    protected $estado_cliente = null;
    

    /*
    *   Métodos para validar y asignar valores de los atributos. 13 campos
    */
    public function setid_cliente($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNombres($value)
    {
        if (Validator::validateString($value, 1, 50)) {
            $this->nombres_cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setapellidos($value)
    {
        if (Validator::validateString($value, 1, 250)) {
            $this->apellidos_cliente = $value;
            return true;
        } else {
            return false;
        }
    }
    
    public function setDUI($value)
    {
        if (Validator::validateDUI($value)) {
            $this->dui_cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCorreo($value)
    {
        if (Validator::validateEmail($value)) {
            $this->correo_cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTelefono($value)
    {
        if (Validator::validatePhone($value)) {
            $this->telefono_cliente = $value;
            return true;
        } else {
            return false;
        }
    }
    
    public function setNacimiento($value)
    {
        if (Validator::validateDate($value)) {
            $this->nacimiento_cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setdireccion($value)
    {
        if (Validator::validateString($value, 1, 250)) {
            $this->direccion_cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    
    public function setEstado($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->estado_cliente = $value;
            return true;
        } else {
            return false;
        }
    }
    /*
    *   Métodos para obtener valores de los atributos.
    */
    public function getid_cliente()
    {
        return $this->id_cliente;
    }

    public function getnombres_cliente()
    {
        return $this->nombres_cliente;
    }

    public function getapellidos()
    {
        return $this->apellidos_cliente;
    }

    public function getDUI()
    {
        return $this->dui_cliente;
    }

    public function getCorreo()
    {
        return $this->correo_cliente;
    }

    public function getnacimiento()
    {
        return $this->nacimiento_cliente;
    }
    public function getTelefono()
    {
        return $this->telefono_cliente;
    }
    public function getdireccion()
    {
        return $this->direccion_cliente;
    }

    public function getestado_cliente()
    {
        return $this->estado_cliente;
    }
    
}
