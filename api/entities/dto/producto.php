<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/producto_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad PRODUCTO.
*/
class producto extends ProductoQueries
{
    // Declaración de atributos (propiedades).
    protected $id_producto = null;
    protected $nombre_producto = null;
    protected $descripcion = null;
    protected $precio = null;
    protected $id_categoria = null;
    protected $editorial = null;
    protected $estado_producto = null;
    protected $id_usuario = null;
    protected $id_autor = null;
    protected $porcentaje_descuento = null;
    protected $isbn = null;
    protected $imagen = null;
    protected $ruta = '../../images/productos/';
    protected $stock = null;


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

    public function setNombre($value)
    {
        if (Validator::validateString($value, 1, 50)) {
            $this->nombre_producto = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDescripcion($value)
    {
        if (Validator::validateString($value, 1, 250)) {
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
        if (Validator::validateString($value, 1, 250)) {
            $this->id_categoria = $value;
            return true;
        } else {
            return false;
        }
    }

    public function seteditorial($value)
    {
        if (Validator::validateString($value, 1, 250)) {
            $this->editorial = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setId_usuario($value)
    {
        if (Validator::validateString($value, 1, 250)) {
            $this->id_usuario = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setidautor($value)
    {
        if (Validator::validateString($value, 1, 250)) {
            $this->id_autor = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setPorcentaje_descuento($value)
    {
        if (Validator::validateString($value, 1, 250)) {
            $this->porcentaje_descuento = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setisbn($value)
    {
        if (Validator::validateString($value, 1, 250)) {
            $this->isbn = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setstock($value)
    {
        if (Validator::validateString($value, 1, 250)) {
            $this->stock = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setImagen($file)
    {
        if (Validator::validateImageFile($file, 500, 500)) {
            $this->imagen = Validator::getFileName();
            return true;
        } else {
            return false;
        }
    }
    
    
    public function setEstado($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->estado_producto = $value;
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

    public function getImagen()
    {
        return $this->imagen;
    }

    public function getCategoria()
    {
        return $this->id_categoria;
    }

    public function getEstado()
    {
        return $this->estado_producto;
    }
    public function getEditorial()
    {
        return $this->editorial;
    }
    public function getId_usuario()
    {
        return $this->id_usuario;
    }
    public function getAutor()
    {
        return $this->id_autor;
    }
    public function getPorcentaje_descuento()
    {
        return $this->porcentaje_descuento;
    }
    public function getIsbn()
    {
        return $this->isbn;
    }
    public function getStok()
    {
        return $this->stock;
    }
    public function getRuta()
    {
        return $this->ruta;
    }
        
}
