<?php
class Alumno extends Conexion
{

    public function __construct()
    {
        parent::__construct();
        $this->setTabla("e26_alumnos");
    }

    public function login($email, $password)
    {
        $sql = "SELECT count(id_socio) as registrado, id_socio, nombre, apellidop, apellidom, email FROM socios WHERE email=:email AND contrasena=:password and id_categoria != 3 and id_categoria != 0";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->bindParam(':email', $email);
        $sentencia->bindParam(':password', $password);
        $sentencia->execute();
        $resultado = $sentencia->fetch(PDO::FETCH_OBJ);
        return $resultado;
    }
   
    public function getAlumnoById($id) {
		$sql = "SELECT a.id, a.nombre, a.email, a.password, a.fecha_registro, a.telefono, a.apellidop, a.apellidom, a.prefijo, a.n_constancia, e.estado, c.nombrecategoria, a.categoria_id /*,cd.descuento, cd.codigo*/
			FROM socios as s
			INNER JOIN e26_estados as e on e.id = a.estado_id 
			INNER JOIN categorias as c on c.id_categoria = a.categoria_id 
			WHERE a.id=" . $id;
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
		return $resultado;
	}

	public function GetCursosPagados($id) {
		$sql = "SELECT ca.*, c.titulo, c.descripcion, c.precio, c.poster FROM e26_cursos_alumnos ca LEFT JOIN e26_pagos_cursos pc on ca.id_pago = pc.id LEFT JOIN e26_cursos c ON ca.id_curso = c.id WHERE pc.id_alumno = :id and pc.status = 'PAGADO'";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute([
			':id'=>$id
		]);
		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
		return $resultado;
	}

    public function alumnoById($id) {
        $sql = "SELECT * FROM e26_alumnos WHERE id=:id";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->bindParam(':id', $id);
        $sentencia->execute();
        $resultado = $sentencia->fetch(PDO::FETCH_OBJ);
        return $resultado;
    }

	public function validarCurso($id, $id_curso) {
		$sql = "SELECT COUNT(*) as disponible, c.titulo, c.descripcion, c.precio, c.poster FROM e26_cursos_alumnos ca LEFT JOIN e26_pagos_cursos pc on ca.id_pago = pc.id LEFT JOIN e26_cursos c ON ca.id_curso = c.id WHERE pc.id_alumno = :id and pc.status = 'PAGADO' and ca.id_curso = :id_curso";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute([
			':id'=>$id,
			':id_curso'=>$id_curso
		]);
		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
		return $resultado;
	}

	public function hema($email)
    {
        $sql = "SELECT * FROM e26_alumnos WHERE email='$email'";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute(array());
        $resultado = $sentencia->fetch(PDO::FETCH_OBJ);
        return $resultado;
    }

    public function tienePermisos($usuario)
	{
		$sql = "SELECT count(id) as pagado FROM inscripciones WHERE alumno_id=" . $usuario . " and (estatus='PAGADO' or estatus='BECADO') and fecha_pago >= '2025-01-01 00:00:00' AND hema_2024=1 and pago_beca=1";
		/* echo $sql; */
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
		return $resultado->pagado;
	}

    public function validarBecado($email)
	{
		$sql = "SELECT * FROM aceptados WHERE email like '%".trim($email)."%' order by categoria_id asc LIMIT 1";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
		return $resultado;
	}

    public function existeM($id, $modulo)
	{
		$sql = "SELECT * FROM pagos_modulos WHERE id_socio=$id AND modulo=$modulo";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
		return $resultado;
	}

    public function getPagoByAlumno2024($id)
	{
		$sql = "SELECT * FROM inscripciones WHERE alumno_id=" . $id . " ";
		//echo $sql;
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
		return $resultado;
	}

    public function validarCodigo($codigo)
	{
		$sql = "SELECT *, count(id) as existe FROM codigos WHERE codigo like '".$codigo."' AND usado_por =0 AND disponible = 1 LIMIT 1";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
		return $resultado;
	}

	public function emailRepetido($email)
	{
		$sql = "SELECT count(*) as repetido, id FROM e26_alumnos WHERE email like :email ";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->bindParam(':email', $email);
		$sentencia->execute();
		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
		return $resultado;
	}

	public function existePagoModulo($id) {
		$sql = "SELECT COUNT(*) AS cuenta FROM pagos_modulos WHERE id_socio=:id AND status = 'PAGADO'";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute([
			':id'=>$id
		]);
		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
		$response = false;
		if($resultado->cuenta>0){
			$response = true;
		}
		return $response;
	}

    public function modulP($id)
    {
        $sql = "SELECT * FROM pagos_modulos WHERE id_socio = :id 	AND status='PAGADO'";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->bindParam(':id', $id, PDO::PARAM_INT);
        $sentencia->execute();
        $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);

        return $resultado;
    }
    public function load($usuario, $rol)
    {
        $sql = "SELECT * FROM alumnos WHERE id=" . $usuario;
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute(array());
        $resultado = $sentencia->fetch(PDO::FETCH_OBJ);
        return $resultado;
    }

	public function GetCategoria($id){
		$sql = 'SELECT c.id_categoria, c.nombrecategoria
			FROM e26_alumnos a
			LEFT JOIN categorias c ON c.id_categoria = a.categoria_id
			WHERE a.id = :id';
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute([
			':id'=>$id
		]);
        $resultado = $sentencia->fetch(PDO::FETCH_OBJ);
        return $resultado;
	}

	public function getAlumnos_2024()
	{

		$sql = "SELECT DISTINCT a.id, a.nombre, a.categoria_id, a.email, a.fecha_registro, a.telefono, a.apellidos, a.prefijo, a.beca,
			c.categoria, p.pais, e.estado, 
			a.estado_id, a.hema_2024,
			i.estatus, i.fecha_pago, i.observaciones, i.monto,
			f.razon_social, f.rfc, ef.estado as estadof, f.codigo_postal, f.regimen_fiscal, f.uso_de_cfdi,
			f.municipio as municipiof, pf.pais as paisf, f.colonia as coloniaf, f.calle as callef
		FROM alumnos as a 
		LEFT JOIN estados as e ON e.id = a.estado_id 
		LEFT JOIN categorias as c ON c.id = a.categoria_id 
		LEFT JOIN paises as p ON p.id = a.pais_id 
		LEFT JOIN alumno_facturacion as f ON f.alumno_id = a.id
		LEFT JOIN paises AS pf ON f.pais = pf.id
		LEFT JOIN inscripciones as i on i.alumno_id=a.id 
		LEFT JOIN estados as ef ON ef.id = f.estado 
		WHERE    1 AND a.restringir = 0 group by a.id;";

		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute();
		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
		return $resultado;
	}

    public function getModulosPagados($id)
	{
		$sql = "SELECT * FROM  pagos_modulos  WHERE status='PAGADO' AND id_socio=" . $id . " GROUP BY modulo";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
		return $resultado;
	}

	public function becas2024()
	{
		$sql = "SELECT * FROM `aceptados`";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute();
		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
		return $resultado;
	}

	public function ver($codigo)
	{
		$sql = "SELECT * FROM `becas2024` where codigo = '$codigo' and usado_por!=0";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute();
		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
		return $resultado;
	}

	public function getAlumnos_2024_Reporte()
	{

		$sql = "SELECT DISTINCT a.id, a.nombre, a.categoria_id, a.email, a.fecha_registro, a.telefono, a.apellidos, a.prefijo, a.beca,
			c.categoria, p.pais, e.estado, 
			a.estado_id, a.hema_2024,
			i.estatus, i.fecha_pago, i.observaciones, i.monto,
			f.razon_social, f.rfc, ef.estado as estadof, f.codigo_postal, f.regimen_fiscal, f.uso_de_cfdi,
			f.municipio as municipiof, pf.pais as paisf, f.colonia as coloniaf, f.calle as callef
		FROM alumnos as a 
		LEFT JOIN estados as e ON e.id = a.estado_id 
		LEFT JOIN categorias as c ON c.id = a.categoria_id 
		LEFT JOIN paises as p ON p.id = a.pais_id 
		LEFT JOIN alumno_facturacion as f ON f.alumno_id = a.id
		LEFT JOIN paises AS pf ON f.pais = pf.id
		LEFT JOIN inscripciones as i on i.alumno_id=a.id 
		LEFT JOIN estados as ef ON ef.id = f.estado 
		WHERE a.email NOT LIKE '%jc-innovation.com%'";

		/* $sql = "SELECT DISTINCT id, nombre, categoria_id, email, fecha_registro, telefono, apellidos,
		categoria,pais, estado,
		razon_social, rfc, codigo_postal, regimen_fiscal, uso_de_cfdi
		FROM (($sql1) UNION ($sql2)) AS emails_unidos"; */

		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute();
		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
		return $resultado;
	}

	public function UsuarioTieneBeca($id)
	{
		$sql = "SELECT COUNT(*) AS existe FROM codigos WHERE usado_por = :id";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute([
			':id'=>$id
		]);
		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
		if($resultado->existe>0){
			return true;
		}
		return false;
	}

	public function validarBecadoVistaSubirSocio($email,$categoria)
	{
		$sql = "SELECT * FROM aceptados WHERE email like '%".trim($email)."%' AND categoria = :categoria LIMIT 1";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute([
			':categoria'=>$categoria
		]);
		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
		return $resultado;
	}
}
