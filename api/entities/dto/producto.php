<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/producto_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad PRODUCTO.
*/
class Producto extends ProductoQueries
{
    // Declaración de atributos (propiedades).
    protected $id_producto = null;
    // protected $id_valo = null;
    protected $id_categoria = null;
    protected $nombre_producto = null;
    protected $descripcion = null;
    protected $precio = null;
    protected $imagen = null;
    protected $estado_producto = null;
    protected $id_usuario = null;
    protected $id_talla = null;
    protected $imgcarucel = null;
    protected $ruta = '../../imagenes/productos/';
    protected $rutaCarrusel = '../../images/carrucelp/';


    /*
    *   Métodos para validar y asignar valores de los atributos. 13 campos
    */
    public function setid_producto($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_producto = $value;
            return true;
        } else {
            return false;
        }
    }

    // public function setid_valo($value)
    // {
    //     if (Validator::validateNaturalNumber($value)) {
    //         $this->id_valo = $value;
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    public function setNombre($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->nombre_producto = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDescripcion($value)
    {
        if (Validator::validateString($value, 1, 550)) {
            $this->descripcion = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setPrecio($value)
    {
        if (Validator::validateMoney($value)) {
            $this->precio = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCategoria($value)
    {
        if (Validator::validateNaturalNumber($value, 1, 250)) {
            $this->id_categoria = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setImagen($file)
    {
        if (Validator::validateImageFile($file, 500, 500)) {
            $this->imagen =  Validator::getFileName();
            return true;
        } else {
            return false;
        }
    }

    public function setEstadoProducto($value)
    {
        if (Validator::validateNaturalNumber($value, 1, 250)) {
            $this->estado_producto = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setUsuario($value)
    {
        if (Validator::validateNaturalNumber($value, 1, 250)) {
            $this->id_usuario = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTalla($value)
    {
        if (Validator::validateNaturalNumber($value, 1, 250)) {
            $this->id_talla = $value;
            return true;
        } else {
            return false;
        }
    }


    public function setimagencarrusel($value)
    {
        if (Validator::validateNaturalNumber($value, 1, 250)) {
            $this->imgcarucel = $value;
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
        return $this->id_producto;
    }

    public function getNombre()
    {
        return $this->nombre_producto;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getPrecio()
    {
        return $this->precio;
    }


    public function getCategoria()
    {
        return $this->id_categoria;
    }

    public function getImagen()
    {
        return $this->imagen;
    }

    public function getEstadoProducto()
    {
        return $this->estado_producto;
    }


    public function getUsuario()
    {
        return $this->id_usuario;
    }

    public function getTalla()
    {
        return $this->id_talla;
    }

    public function getImagenC()
    {
        return $this->imgcarucel;
    }

    public function getRuta()
    {
        return $this->ruta;
    }

    public function getRutaCarrucel()
    {
        return $this->rutaCarrusel;
    }
}
