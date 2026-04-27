<?php



class Transmision extends Conexion {

    public function __construct() {
        parent::__construct();
        $this->setTabla("alumnos");
    }

    public function videoVista($video_id, $usuario_id){
        $sql = "SELECT count(*) as visto, minutos as tiempo, id FROM e26_progreso_videos WHERE socio_id = " . $usuario_id . " and video_id = " . $video_id;
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute(array());
        $resultado = $sentencia->fetch(PDO::FETCH_OBJ);
        return $resultado;
    }


    /* FUNCIONES AMEH */ 
    public function getTransmision()

    {
        $sql = "SELECT *,count(id) as existe FROM e26_conferencias
                WHERE  estatus = 1  
                ORDER BY id asc LIMIT 1;";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute();
        $resultado = $sentencia->fetch(PDO::FETCH_OBJ);
        return $resultado;
    }

    public function visualizadoLive($usuario_id, $modulo_id)

    {

        $sql = "SELECT * FROM progresos_transmision WHERE usuario_id=:usuario_id AND modulo_id=:modulo_id";

        $sentencia = $this->conexion_db->prepare($sql);

        $sentencia->bindParam(':usuario_id', $usuario_id);

        $sentencia->bindParam(':modulo_id', $modulo_id);

        $sentencia->execute();

        $resultado = $sentencia->fetch(PDO::FETCH_OBJ);

        return $resultado;
    }

    public function modulofin($id)

    {

        $sql = "SELECT * FROM modulos as m inner join pagos_modulos as pm on pm.modulo = m.id_modulo WHERE pm.status='PAGADO' AND pm.id_socio=" . $id;

        $sentencia = $this->conexion_db->prepare($sql);

        $sentencia->execute(array());

        $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);

        return $resultado;
    }

    public function getCategoria($id)

    {

        $sql = "SELECT categoria_id FROM alumnos as a WHERE a.id=" . $id;



        $sentencia = $this->conexion_db->prepare($sql);

        $sentencia->execute(array());

        $resultado = $sentencia->fetch(PDO::FETCH_OBJ);

        return $resultado;
    }

    public function transmisionVista($modulo_id, $usuario_id)

    {

        $sql = "SELECT count(*) as visto, tiempo, id FROM progresos_transmision WHERE usuario_id=" . $usuario_id . " and modulo_id=" . $modulo_id;

        $sentencia = $this->conexion_db->prepare($sql);

        $sentencia->execute(array());

        $resultado = $sentencia->fetch(PDO::FETCH_OBJ);

        return $resultado;
    }
}
