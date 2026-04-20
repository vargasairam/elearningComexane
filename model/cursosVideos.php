<?php
class CursosVideos extends Conexion
{
    public function __construct()
    {
        parent::__construct();
        $this->setTabla("e26_videos_cursos");
    }

    public function getVideosCurso($id_curso) {
		$sql = "SELECT * FROM e26_videos_cursos WHERE id_curso = :id_curso";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute([
			':id_curso' => $id_curso
		]);
		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
		return $resultado;
	}

    public function getVideoById($id_video) {
        $sql = "SELECT * FROM e26_videos_cursos WHERE id = :id_video";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute([
            ':id_video' => $id_video
        ]);
        $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $resultado;
    }

    public function getVideosModulo($id_curso, $id_modulo) {
		$sql = "SELECT * FROM e26_videos_cursos WHERE id_curso = :id_curso AND id_modulo = :id_modulo";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute([
			':id_curso' => $id_curso,
			':id_modulo' => $id_modulo
		]);
		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
		return $resultado;
	}
}
