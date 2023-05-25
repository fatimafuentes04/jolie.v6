<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/public/usuario_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad USUARIO.
*/
class Usuario extends UsuarioQueries
{
    // Declaración de atributos (propiedades).
    protected $id_usuario = null;
    protected $nombre_usuario = null;
    protected $apellido_usuario = null;
    protected $usuario = null;
    protected $clave_usuario = null;
    protected $estado_usuario = null;
    protected $idtipo_usuario = null;

    /*
    *   Métodos para validar y asignar valores de los atributos.
    */
    public function setId_usuario($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_usuario = $value;
            return true;
        } else {
            return false;
        }
    }

    //funcion set del nombre de usuario
    public function setNombre_usuario($value)
    {
        if (Validator::validateAlphabetic($value, 1, 50)) {
            $this->nombre_usuario = $value;
            return true;
        } else {
            return false;
        }
    }

    //funcion set del apellido del usuario
    public function setApellido_usuario($value)
    {
        if (Validator::validateAlphabetic($value, 1, 50)) {
            $this->apellido_usuario = $value;
            return true;
        } else {
            return false;
        }
    }

    //funcion set del campo usuario
    public function setUsuario($value)
    {
        if (Validator::validateAlphabetic($value, 1, 50)) {
            $this->usuario = $value;
            return true;
        } else {
            return false;
        }
    }

    //funcion set del campo clave
    public function setClave_usuario($value)
    {
        if (Validator::validatePassword($value)) {
            $this->clave_usuario = password_hash($value, PASSWORD_DEFAULT);
            return true;
        } else {
            return false;
        }
    }

    //funcion set del campo estado del usuario
    public function setEstado_usuario($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->estado_usuario = $value;
            return true;
        } else {
            return false;
        }
    }

    //funcion set del campo tipo de usuario
    public function setIdtipo_usuario($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idtipo_usuario = $value;
            return true;
        } else {
            return false;
        }
    }


    /*
    *   Métodos para obtener valores de los atributos.
    */
    //funcion get del campo usuario
    public function getId_usuario()
    {
        return $this->id_usuario;
    }

    //funcion get del campo nombre
    public function getNombre_usuario()
    {
        return $this->nombre_usuario;
    }

    //funcion get del campo apellido
    public function getApellido_usuario()
    {
        return $this->apellido_usuario;
    }

    //funcion get del campo usuario
    public function getUsuario()
    {
        return $this->usuario;
    }

    //funcion get del campo clave
    public function getClave_usuario()
    {
        return $this->clave_usuario;
    }
    
    //funcion get del campo estado del usuario
    public function getEstado_usuario()
    {
        return $this->estado_usuario;
    }

    //funcion get del campo tipo usuario
    public function getIdtipo_usuario()
    {
        return $this->idtipo_usuario;
    }
}
