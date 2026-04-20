<?php
class Encuesta extends Conexion {

	public function __construct() {
		parent::__construct();
		$this->setTabla("alumnos");
	}
    public function preguntas($tema){
		$sql = "SELECT * FROM encuesta_2024 WHERE tema = :tema";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->bindParam(':tema', $tema, PDO::PARAM_INT);
		$sentencia->execute();
		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
		return $resultado;
	}
	public function preguntasId($tema){
		$sql = "SELECT * FROM encuesta_2024 WHERE id_tema = :tema";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->bindParam(':tema', $tema, PDO::PARAM_INT);
		$sentencia->execute();
		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
		return $resultado;
	}
	public function temaV($tema){
		$sql = "SELECT * FROM temas2024 WHERE id = :tema ";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->bindParam(':tema', $tema, PDO::PARAM_INT);
		$sentencia->execute();
		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
		return $resultado;
	}
	public function veremailt($email,$tema){
		$sql = "SELECT * FROM formulario WHERE email ='$email' and tema='$tema'";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->bindParam(':tema', $tema, PDO::PARAM_INT);
		$sentencia->execute();
		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
		return $resultado;
	}
	public function validarTID($tema){
		$sql = "SELECT * FROM temas2024 WHERE tema ='$tema'";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->bindParam(':tema', $tema, PDO::PARAM_INT);
		$sentencia->execute();
		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
		return $resultado;
	}
	public function temaID($tema){
		$sql = "SELECT * FROM temas2024 WHERE id =$tema";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->bindParam(':tema', $tema, PDO::PARAM_INT);
		$sentencia->execute();
		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
		return $resultado;
	}
	public function veremail($tema){
		$sql = "SELECT * FROM formulario WHERE email ='$tema'";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->bindParam(':tema', $tema, PDO::PARAM_INT);
		$sentencia->execute();
		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
		return $resultado;
	}
	public function VAli($tema){
		$sql = "SELECT * FROM encuesta_2024 WHERE tema = :tema AND (op_1 IS NULL OR op_1 = '')";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->bindParam(':tema', $tema, PDO::PARAM_INT);
		$sentencia->execute();
		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
		return $resultado;
	}

    public function resp($tema, $pregunta){
		$sql = "SELECT tema,pregunta,op_1,op_2,op_3,op_4,op_5,op_6,op_7,op_8,op_9,op_10 FROM encuesta_2024 WHERE tema = :tema AND pregunta = :pregunta";
		/* echo $sql; */
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->bindParam(':tema', $tema, PDO::PARAM_INT);
        $sentencia->bindParam(':pregunta', $pregunta, PDO::PARAM_INT);
		$sentencia->execute();
		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
		return $resultado;
	}

    public function tema(){
		$sql = "SELECT DISTINCT tema,id_tema FROM encuesta_2024";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->bindParam(':tema', $tema, PDO::PARAM_INT);
		$sentencia->execute();
		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
		return $resultado;
	}
	public function time($tema){
		$sql = "SELECT DISTINCT tema, fecha_hr_fin FROM encuesta_2024 where tema='$tema'";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->bindParam(':tema', $tema, PDO::PARAM_INT);
		$sentencia->execute();
		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
		return $resultado;
	}
	public function deleteTeam($tema){
		$sql = "DELETE FROM encuesta_2024 where tema='$tema'";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->bindParam(':tema', $tema, PDO::PARAM_STR);
		$sentencia->execute();
	}
	public function countRP($tema){
		$sql = "SELECT id,pregunta, op_1,op_2,op_3,op_4,op_5,op_6,op_7,op_8,op_9,op_10
				FROM encuesta_2024
				WHERE tema =  :tema GROUP BY pregunta";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->bindParam(':tema', $tema, PDO::PARAM_INT);
		$sentencia->execute();
		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
		return $resultado;
	}
	public function opcionesP($tema){
		$sql = "SELECT id,pregunta,respuesta,
					COUNT(respuesta) AS total_r
				FROM `formulario` 
				WHERE tema  =  '$tema' GROUP BY respuesta";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->bindParam(':tema', $tema, PDO::PARAM_INT);
		$sentencia->execute();
		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
		return $resultado;
	}
	
}
?>