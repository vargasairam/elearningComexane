<?php
class Socios extends Conexion
{
    public function __construct()
    {
        parent::__construct();
        $this->setTabla("socios");
    }

    public function busqSocioByCorreo($busqueda) {
        $sql = "SELECT * FROM socios s WHERE email = :email";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute([
            ':email' => $busqueda
        ]);
        $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $resultado;
    }

    public function emailRepetido($email, $curp)
	{
		$sql = "SELECT count(*) as repetido, id_socio FROM socios WHERE email = :email AND curp = :curp";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->bindParam(':email', $email);
		$sentencia->bindParam(':curp', $curp);
		$sentencia->execute();
		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
		return $resultado;
	}

    public function getAlumnoById($id) {
		$sql = "SELECT s.id_socio, s.nombre, s.email, s.estado, s.contrasena, s.celular, s.apellidop, s.apellidom, s.prefijotxt, s.nombreconstancia, c.nombrecategoria, s.id_categoria /*,cd.descuento, cd.codigo*/
			FROM socios as s
			INNER JOIN categorias as c on c.id_categoria = s.id_categoria 
			WHERE s.id_socio=" . $id;
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
		return $resultado;
	}

    public function alumnoById($id) {
        $sql = "SELECT * FROM socios WHERE id_socio=:id";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->bindParam(':id', $id);
        $sentencia->execute();
        $resultado = $sentencia->fetch(PDO::FETCH_OBJ);
        return $resultado;
    }
}
