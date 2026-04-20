<?php

/**
 * Clase para conectar con la base de datos
 */
class Conexion
{
    protected $conexion_db;
    private $tabla;

    public function __construct()
    {
        try {
            $this->conexion_db = new PDO(
                "mysql:host=" . DB_HOST . ";port=3307;dbname=" . DB_NAME,
                DB_USER,
                DB_PASS
            );
            $this->conexion_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conexion_db->exec("SET NAMES utf8");
            return $this->conexion_db;
        } catch (PDOException $e) {
            echo "❌ Error en la línea " . $e->getLine() . ": " . $e->getMessage();
            $this->conexion_db = null;
        }
    }


    public function setTabla($tabla)
    {
        $this->tabla = $tabla;
    }

    public function insertar($campos, $valores)
    {
        if (count($campos) != count($valores)) {
            echo "No coinciden columnas";
            exit;
            return false;
        } else {
            $str_campos = implode(",", $campos);
            $str_valores = "";
            for ($i = 0; $i < count($campos); $i++) {
                $str_valores .= ":" . $campos[$i] . ", ";
            }
            $str_valores = substr($str_valores, 0, strlen($str_valores) - 2);
            $sentencia = $this->conexion_db->prepare("INSERT INTO " . $this->tabla . " (" . $str_campos . ") VALUES (" . $str_valores . ")");
            $datos = array();
            for ($i = 0; $i < count($campos); $i++) {
                $datos[':' . $campos[$i]] = $valores[$i];
            }
            if ($sentencia->execute($datos)) {
                return $this->conexion_db->LastInsertId();
            } else {
                return false;
            }
        }
    }

    public function actualizar($campos, $valores, $condicion)
    {
        if (count($campos) != count($valores)) {
            echo "No coinciden columnas";
            exit;
            return false;
        } else {
            $str_campos = "";
            for ($i = 0; $i < count($campos); $i++) {
                $str_campos .= $campos[$i] . "=:" . $campos[$i] . ", ";
            }
            $str_campos = substr($str_campos, 0, strlen($str_campos) - 2);
            $sentencia = $this->conexion_db->prepare("UPDATE " . $this->tabla . " SET " . $str_campos . " WHERE " . $condicion);
            $datos = array();
            for ($i = 0; $i < count($valores); $i++) {
                $datos[':' . $campos[$i]] = $valores[$i];
            }
            if ($sentencia->execute($datos)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function eliminar($condicion)
    {
        $sentencia = $this->conexion_db->prepare("DELETE FROM " . $this->tabla . " WHERE " . $condicion);
        return $sentencia->execute();
    }

    public function sanitizar($cadena)
    {
        $no_permitidas = array("á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "ñ", "À", "Ã", "Ì", "Ò", "Ù", "Ã™", "Ã ", "Ã¨", "Ã¬", "Ã²", "Ã¹", "ç", "Ç", "Ã¢", "ê", "Ã®", "Ã´", "Ã»", "Ã‚", "ÃŠ", "ÃŽ", "Ã”", "Ã›", "ü", "Ã¶", "Ã–", "Ã¯", "Ã¤", "«", "Ò", "Ã", "Ã„", "Ã‹");
        $permitidas = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "n", "N", "A", "E", "I", "O", "U", "a", "e", "i", "o", "u", "c", "C", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "u", "o", "O", "i", "a", "e", "U", "I", "A", "E");
        $texto = str_replace($no_permitidas, $permitidas, $cadena);
        return $texto;
    }

    public function __destruct()
    {
        $this->conexion_db = null;
    }
}
