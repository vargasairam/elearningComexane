<?php
class Congreso extends Conexion
{
    public function __construct()
    {
        parent::__construct();
        $this->setTabla("dias");
    }

    public function getAllDias($anio)
    {
        $sql = "SELECT * FROM dias where fecha like'%$anio%'";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute(array());
        $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $resultado;
    }
    public function getxDias($anio)
    {
        $sql = "SELECT * FROM modulos where id_modulo = '$anio' GROUP BY id_modulo";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute(array());
        $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $resultado;
    }
}
