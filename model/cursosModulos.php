<?php
class CursosModulos extends Conexion
{
    public function __construct()
    {
        parent::__construct();
        $this->setTabla("e26_modulos_cursos");
    }

    public function getModulosCurso($id_curso) {
		$sql = "SELECT * FROM e26_modulos_cursos WHERE id_curso = :id_curso";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute([
			':id_curso' => $id_curso
		]);
		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
		return $resultado;
	}

    public function getModuloById($id_modulo) {
        $sql = "SELECT * FROM e26_modulos_cursos WHERE id = :id_modulo";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute([
            ':id_modulo' => $id_modulo
        ]);
        $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $resultado;
    }
}
