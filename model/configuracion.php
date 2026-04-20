<?php
class Configuracion extends Conexion
{
    public function __construct()
    {
        parent::__construct();
        $this->setTabla("configuracion");
    }
    public function getConfiguracion()
    {
        $sql = "SELECT  *
        FROM e26_configuracion 
        WHERE id=1 limit 1";
        $sentencia = $this->conexion_db->prepare($sql);
        // $sentencia->bindParam(':email', $email);
        $sentencia->execute();
        $resultado = $sentencia->fetch(PDO::FETCH_OBJ);
        return $resultado;
    }
}
