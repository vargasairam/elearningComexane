<?php
class Usuario extends Conexion
{
    public function __construct()
    {
        parent::__construct();
        $this->setTabla("usuarios");
    }

    public function login($email, $password) {
        $sql = "SELECT count(id) as registrado, id, nombre, apellidos, email FROM usuarios WHERE email=:email AND password=:password";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->bindParam(':email', $email);
        $sentencia->bindParam(':password', $password);
        $sentencia->execute();
        $resultado = $sentencia->fetch(PDO::FETCH_OBJ);
        return $resultado;
    }

    public function getUsuarioById($id) {
		$sql = "SELECT u.id, u.nombre, u.email, u.rol, u.apellidos
			FROM usuarios as u
			WHERE u.id=" . $id;
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
		return $resultado;
	}
}
