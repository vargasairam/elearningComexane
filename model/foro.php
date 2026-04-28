<?php
class ForoResidentes extends Conexion
{
    public function __construct()
    {
        parent::__construct();
        $this->setTabla("e26_foro_residentes");
    }

    public function getVideosForo() {
        $sql = "SELECT * FROM e26_foro_residentes fr ORDER BY fr.fecha_hora_inicio DESC";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute();
        $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $resultado;
    }

    public function getVideoForoById($id_video) {
        $sql = "SELECT * FROM e26_foro_residentes fr WHERE fr.id = :id_video";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute([
            ':id_video' => $id_video
        ]);
        $resultado = $sentencia->fetch(PDO::FETCH_OBJ);
        return $resultado;
    }

    public function sesionVista($sesion_id, $usuario_id){
        $sql = "SELECT count(*) as visto, minutos as tiempo, id FROM e26_progreso_sesionM WHERE socio_id = " . $usuario_id . " and sesion_id = " . $sesion_id;
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute();
        $resultado = $sentencia->fetch(PDO::FETCH_OBJ);
        return $resultado;
    }

}
