<?php
class Pregunta extends Conexion
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getAllPreguntas($modulo)
	{
		$sql = "SELECT p.comentario as pregunta, p.fecha_hora, concat(a.nombre, ' ', a.apellidos) as nombre,p.activo,p.id FROM comentarios as p INNER JOIN alumnos as a ON a.id=p.usuario_id WHERE p.modulo_id=" . $modulo . " order by p.fecha_hora desc";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetchALL(PDO::FETCH_OBJ);
		$sentencia->closeCursor();
		return $resultado;
	}
	public function getEstadisticas($modulo)
	{
		$sql = "SELECT t.fecha_hora_inicio as fecha_hora, concat(u.nombre, ' ',u.apellidos) as nombre, u.email,u.telefono,u.prefijo,
		u.id,c.categoria,p.pais,e.estado FROM alumnos as u
		INNER JOIN progresos_transmision as t on u.id=t.usuario_id
		LEFT JOIN estados as e on e.id=u.estado_id
		LEFT JOIN paises as p on p.id=u.pais_id
		LEFT JOIN categorias as c on c.id=u.categoria_id
		WHERE  t.modulo_id=" . $modulo . "  order by t.fecha_hora_inicio desc ";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetchALL(PDO::FETCH_OBJ);
		$sentencia->closeCursor();
		return $resultado;
	}
	public function getModulo($id)
	{
		$sql = "SELECT * from modulos WHERE id_modulo=$id ";
		//echo $sql;
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
		$sentencia->closeCursor();
		return $resultado;
	}
	public function getEstadisticasBymoduloPago($modulo, $fe_incio, $fe_fin)
	{
		$sql = "SELECT count(*) as minutos, t.fecha_hora_inicio as fecha_hora, concat(u.nombre, ' ',u.apellidos) as nombre, u.email,   
		u.id FROM alumnos as u
		INNER JOIN progresos_transmision_modulo as t on u.id=t.usuario_id
		WHERE  t.fecha_hora_inicio>='$fe_incio' AND  t.fecha_hora_inicio <='$fe_fin '  AND t.modulo_id=" . $modulo . "  group by t.usuario_id order by t.fecha_hora_inicio desc ";
		//echo $sql;
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetchALL(PDO::FETCH_OBJ);
		$sentencia->closeCursor();
		return $resultado;
	}



	public function getEstadisticasBymodulo($fe_incio, $fe_fin, $usuario)
	{
		$sql = "SELECT SUM(tiempo) as minutos FROM alumnos as u
		INNER JOIN progresos_transmision_modulo as t on u.id=t.usuario_id
		WHERE  t.fecha_hora_inicio>='$fe_incio' AND  t.fecha_hora_inicio <='$fe_fin ' and t.usuario_id=" . $usuario;
		//echo $sql;
		/* $sql = "SELECT SUM(tiempo) as minutos FROM alumnos as u
		LEFT JOIN progresos_transmision_modulo as t on u.id=t.usuario_id
		WHERE t.modulo_id=$mod_id and t.usuario_id=".$usuario; */
		//echo $sql;
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
		$sentencia->closeCursor();
		return $resultado->minutos;
	}

	public function getLugar($id)
	{
		$sql = "SELECT  e.estado as estado FROM alumnos as u
		INNER JOIN estados as e ON u.estado_id=e.id WHERE u.id=" . $id;
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetchALL(PDO::FETCH_OBJ);
		$sentencia->closeCursor();
		return $resultado;
	}

	public function getEstadisticasCompletos($modulo)
	{
		$sql = "SELECT u.id,t.fecha_hora_inicio as fecha_hora, concat(u.nombre, ' ',u.apellidos) as nombre, u.email,  t.tiempo
		FROM usuarios as u
		INNER JOIN progresos_transmision as t on u.id=t.usuario_id
		LEFT JOIN paises as p on p.id=u.pais
		WHERE  t.modulo_id=" . $modulo . " order by t.fecha_hora_inicio desc ";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetchALL(PDO::FETCH_OBJ);
		$sentencia->closeCursor();
		return $resultado;
	}

	public function getAllComentarios($modulo)
	{
		$sql = "SELECT c.comentario, concat(s.nombre,' ',s.apellidos) as realizo, c.fecha_hora FROM comentarios as c
		INNER JOIN usuarios as s on c.usuario_id = s.id
		WHERE c.modulo_id =" . $modulo;
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetchALL(PDO::FETCH_OBJ);
		$sentencia->closeCursor();
		return $resultado;
	}

	public function getEstadisticasByPais($sesion)
	{

		$sql = "SELECT p.pais, count(*) as total
		FROM usuarios as u
		INNER JOIN progresos_transmision as t ON u.id=t.usuario_id
		INNER JOIN paises as p ON p.id=u.pais

		WHERE t.modulo_id=" . $sesion . "  group by p.id order by total desc";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
		$sentencia->closeCursor();
		return $resultado;
	}

	public function getEstadisticasByPaisV($id)
	{
		$sql = "SELECT p.pais, count(p.id) as total FROM alumnos as u INNER JOIN paises as p ON u.pais_id=p.id INNER JOIN progresos_transmision as t ON u.id=t.usuario_id where t.modulo_id=" . $id . " group by p.id";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetchALL(PDO::FETCH_OBJ);
		$sentencia->closeCursor();
		return $resultado;
	}

	public function getEstadisticasByEstadosV($id)
	{
		$sql = "SELECT e.estado, count(e.id) as total FROM alumnos as u INNER JOIN estados as e ON u.estado_id=e.id INNER JOIN progresos_transmision as t ON u.id=t.usuario_id where t.modulo_id=" . $id . " group by e.id";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetchALL(PDO::FETCH_OBJ);
		$sentencia->closeCursor();
		return $resultado;
	}
	//FUNCION PARA OBTENER EL TIEMPO DE VIDEOS CLASES
	public function VideosGrabados($id_user)
	{
		$sql = "SELECT SUM(minutos) as minutos FROM progresos_videos_clases 
		WHERE usuario_id= $id_user ";
		//echo $sql;
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
		$sentencia->closeCursor();
		return $resultado->minutos;
	}

	//FUNCIONES PARA OBTENER DATOS DE EN VIVO-ONDEMAND
	public function moduleOnline($id_user, $mod)
	{
		$sql = "SELECT tiempo FROM progresos_transmision as p
		WHERE p.usuario_id= $id_user AND p.modulo_id=$mod";
		//echo $sql;
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
		$sentencia->closeCursor();
		return $resultado->tiempo;
	}
	public function moduleOndemand($user_id, $modulo, $duracion)
	{
		$sql = "SELECT v.id, v.duracion as duracion, p.minutos as visto, p.completo FROM `progresos_videos` AS p INNER JOIN videos as v ON v.id=p.video_id where usuario_id=" . $user_id . " AND v.modulo_id=" . $modulo . " AND fecha_hora_inicio>='2024-02-24 00:00:00'";

		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
		$sentencia->closeCursor();
		$minutos = 0;

		foreach ($resultado as $vistas) {
			if ($vistas->completo) {
				$minutos = $minutos + $vistas->duracion;
			} else {
				$minutos = $minutos + $vistas->visto;
			}
		}

		$porcentaje = ($minutos * 100) / $duracion;
		// $porcentaje = number_format($porcentaje, 2);
		$porcentaje = (float) $porcentaje;
		if ($porcentaje >= 100) {
			$porcentaje = 100;
		}
		return $porcentaje;
	}
}
