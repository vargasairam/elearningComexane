<?php

class Videos extends Conexion

{

    public function __construct()

    {

        parent::__construct();
    }

    public function getVideosByRangoDay($modulo, $search = "", $tipo = "ondemand")
    {
        $busqueda = "";
        if ($search != "") {
            $textoabuscarsplit = str_word_count($search, 1);
            $busqueda .= " and (titulo LIKE '%" . $textoabuscarsplit[0] . "%' ";
            for ($i = 1; $i < str_word_count($search); $i++) {
                $busqueda .= " and titulo LIKE '%" . $textoabuscarsplit[$i] . "%' ";
            }
            $busqueda .= " ) ";
            $textoabuscarsplit = str_word_count($search, 1);
            $busqueda .= "  or (tema LIKE '%" . $textoabuscarsplit[0] . "%' ";
            for ($i = 1; $i < str_word_count($search); $i++) {
                $busqueda .= " and tema LIKE '%" . $textoabuscarsplit[$i] . "%' ";
            }
            $busqueda .= " ) ";
        }
        $complemento_tipo = "";
        $complemento_tipo = " and tipo='" . $tipo . "' ";
        $sql = "SELECT * FROM videos WHERE modulo_id=" . $modulo .  $busqueda . " " . $complemento_tipo . " order by fecha_hora_inicio asc";
        // echo $sql;
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute(array());
        $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $resultado;
    }

    public function getProgresoVideo($video, $ususario, $minutos)

    {

        $sql = "SELECT count(id) as progreso, minutos, completo FROM progresos_videos WHERE video_id=" . $video . " and usuario_id=" . $ususario;

        $sentencia = $this->conexion_db->prepare($sql);

        $sentencia->execute(array());

        $resultado = $sentencia->fetch(PDO::FETCH_OBJ);

        $progreso = 0;

        if ($resultado->progreso) {

            if ($resultado->completo) {

                $progreso = 100;
            } else {

                $progreso = ($resultado->minutos / $minutos) * 100;

                if ($progreso >= 95) {

                    $progreso = 100;
                }
            }
        } else {

            $resultado->completo = 0;

            $resultado->minutos = 0;
        }

        $resultado->progreso = ceil($progreso);

        return $resultado;
    }

    public function getVideoById($id)

    {

        $sql = "SELECT *  FROM videos WHERE id=" . $id;

        $sentencia = $this->conexion_db->prepare($sql);

        $sentencia->execute(array());

        $resultado = $sentencia->fetch(PDO::FETCH_OBJ);

        return $resultado;
    }

    public function getEventoEnVivo($id)

    {

        $sql = "SELECT c.*, cm.nombre AS nombreModulo

            FROM conferencias c 

            LEFT JOIN cat_modulos cm ON c.id = cm.id

            WHERE c.id=" . $id;

        $sentencia = $this->conexion_db->prepare($sql);

        $sentencia->execute(array());

        $resultado = $sentencia->fetch(PDO::FETCH_OBJ);

        return $resultado;
    }

    public function getProgresoEnVivo($modulo, $alumno, $hora_inicio = "0000-00-00 00:00:00", $hora_fin = "0000-00-00 00:00:00", $duracion = 0)

    {

        $sql = "SELECT COUNT(DISTINCT(DATE_FORMAT(t.fecha_hora_inicio, '%Y-%m-%d %H:%i'))) as visto, SUM(t.tiempo) as tiempo, min(t.fecha_hora_inicio) as fecha_hora, max(t.fecha_hora_inicio) as fecha_hora_fin 

	FROM progresos_transmision_modulo as t

	WHERE  t.modulo_id=" . $modulo . "    and t.usuario_id=" . $alumno;



        $sentencia = $this->conexion_db->prepare($sql);

        $sentencia->execute(array());

        $resultado = $sentencia->fetch(PDO::FETCH_OBJ);

        $sentencia->closeCursor();



        if ($resultado->visto >= $duracion) {

            $resultado->visto = $duracion;
        }



        $porcentaje = ($resultado->visto * 100) / $duracion;

        $porcentaje = ($porcentaje);

        if ($porcentaje >= 100) {

            $porcentaje = 100;
        }



        return [

            'porcentaje' => $porcentaje,

            'minutos_visto' => $resultado->visto,

        ];
    }

    public function getVideosByModulo($modulo = 0, $tipo = "ondemand")

    {





        $complemento_tipo = " and tipo='" . $tipo . "' ";



        $sql = "SELECT * FROM videos WHERE modulo_id=" . $modulo . " " . $complemento_tipo . " order by fecha_hora_inicio asc, tema ASC";

        // echo $sql;

        $sentencia = $this->conexion_db->prepare($sql);

        $sentencia->execute(array());

        $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);

        return $resultado;
    }

    function calcularProgresoVideos($modulo, $al, $tipoVideo = 'ondemand')

    {

        global $V; // Asegúrate de que $V es accesible en el contexto de la función



        $videos = $V->getVideosByModulo($modulo, $tipoVideo);

        $total_minutos = 0;



        $total_progreso = 0;

        $total_videos = count($videos);

        $total_minutos_modulo = 0;

        $progreso = 0;

        foreach ($videos as $video) {



            $resultado = $V->getProgresoVideo($video->id, $al->id, $video->duracion);

            $total_minutos_modulo += $video->duracion;

            if ($resultado->progreso >= 100) {

                $total_minutos += $video->duracion;

                $progreso = 100;

                $total_progreso += 100;
            } else {

                if ($resultado->minutos >= $video->duracion) {

                    $total_minutos += $video->duracion;

                    $progreso = 100;

                    $total_progreso += 100;
                } else {

                    $total_minutos += $resultado->minutos;

                    $progreso = $resultado->progreso;

                    $total_progreso += $resultado->progreso;
                }
            }
        }

        if ($total_progreso > 0) {

            $porcentaje_on_demand = $total_progreso / $total_videos;
        } else {

            $porcentaje_on_demand = 0;
        }



        return [

            'total_minutos_modulo' => $total_minutos_modulo,

            'porcentaje_visualizado' => $porcentaje_on_demand,

            'minutos_visualizados' => $total_minutos,

        ];
    }

    public function getVideoCount($id)

    {

        $sql = "SELECT count(id) as total  FROM videos WHERE modulo_id=" . $id;

        $sentencia = $this->conexion_db->prepare($sql);

        $sentencia->execute(array());

        $resultado = $sentencia->fetch(PDO::FETCH_OBJ);

        return $resultado;
    }
}
