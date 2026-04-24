<?php
class SesionMensual extends Conexion
{
    public function __construct()
    {
        parent::__construct();
        $this->setTabla("e_conferencias");
    }

    public function getSesionesMensualesByUsuario($id_usuario) {
        $f_actual = date("Y-m-d H:i:s");
        $sql = "SELECT ec.* FROM sesionesasistentes sa LEFT JOIN e_conferencias ec on sa.sesion_id = ec.id WHERE sa.socio_id = :id_socio AND 
        ec.fecha_hora_inicio > :f_actual ORDER BY ec.fecha_hora_inicio ASC";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute([
            ':id_socio' => $id_usuario,
            ':f_actual' => $f_actual
        ]);
        $resultado = $sentencia->fetch(PDO::FETCH_OBJ);
        return $resultado;
    }
}
