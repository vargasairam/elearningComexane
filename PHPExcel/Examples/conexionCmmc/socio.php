<?php
 class Socio extends Conexion {
 	public function __construct() {
 		parent::__construct();
 		$this->setTabla("socios");
 	}

 	public function login($email, $password) {
 		$sql = "SELECT count(*) as registrado, email, id FROM socios WHERE email=:email AND password=:password AND activo=1";
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->bindParam(':email', $email);
 		$sentencia->bindParam(':password', $password);
 		$sentencia->execute();
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		return $resultado;
 	}

 	public function emailRepetido($email) {
 		$sql = "SELECT count(*) as repetido FROM socios WHERE email like '" . $email . "' AND activo=1";
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		if ($resultado->repetido) {
 			return true;
 		} else {
 			return false;
 		}
 	}
	 public function curpRepetido($curp) {
		$sql = "SELECT count(id) as repetido FROM socios WHERE curp='" . $curp . "' LIMIT 1";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
		return $resultado->repetido;
	}
 	public function isRFCDuplicado($rfc) {
 		$sql = "SELECT count(id) as repetido FROM socios WHERE rfc='" . $rfc . "' LIMIT 1";
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		return $resultado->repetido;
 	}

 	public function rfcAsignado($dato_id, $socio_id) {
 		$sql = "SELECT count(*) as asignado FROM socios_facturacion WHERE socio_id=" . $socio_id . " AND datos_id=" . $dato_id;
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		if ($resultado->asignado) {
 			return true;
 		} else {
 			return false;
 		}
 	}

 	public function getAllDatosFacturacion($socio) {
 		$sql = "SELECT sf.socio_id, df.id, sf.descripcion, sf.principal, df.rfc FROM datos_facturacion as df INNER JOIN socios_facturacion as sf ON sf.datos_id=df.id WHERE sf.socio_id=" . $socio;
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
 		return $resultado;
 	}

 	public function numsocioRepetido($numsocio) {
 		$sql = "SELECT count(*) as repetido FROM socios WHERE numsocio='" . $numsocio . "' AND numsocio!='PENDIENTE' AND activo=1";
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		if ($resultado->repetido) {
 			return true;
 		} else {
 			return false;
 		}
 	}

 	public function load($socio) {
 		$sql = "SELECT * FROM socios WHERE id=" . $socio;
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		return $resultado;
 	}
 	public function getSocios() {
 		$sql = "SELECT * FROM socios ";
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
 		return $resultado;
 	}

 	public function getAllSocios() {
 		$sql = "SELECT  s.id, s.nombre, s.apellidop, s.apellidom, s.email, s.password, s.curp, s.fec_nacimiento, s.sexo, s.activo, c.categoria, s.numsocio, dc.especialidad, dc.certificado  FROM socios as s INNER JOIN categorias as c on s.categoria_id=c.id LEFT JOIN datos_certificados as dc on s.id=dc.socio_id WHERE s.activo=1";
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
 		return $resultado;
 	}

	public function getValidarActualizacion($socio,$inicio,$tipo) {
		$sql = "SELECT * FROM datos_actualizacion_socio WHERE socio_id=$socio and id_inicio=$inicio and tipo_dato=$tipo and fecha_hora > DATE_SUB(NOW(),INTERVAL '4-6' YEAR_MONTH)";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
		return $resultado;
	}

	public function getValidarPermisoAutorizado($socio,$certificado) {
		$sql = "SELECT * FROM datos_permiso_socio WHERE socio_id=$socio and certificado_id=$certificado and autorizado=1";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
		return $resultado;
	}

	public function getValidarPermiso($socio,$certificado) {
		$sql = "SELECT * FROM datos_permiso_socio WHERE socio_id=$socio and certificado_id=$certificado";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
		return $resultado;
	}

 	public function getCategorias() {
 		$sql = "SELECT * FROM categorias";
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
 		return $resultado;
 	}

 	public function getCategoriasNoSocio() {
 		$sql = "SELECT * FROM categorias WHERE es_socio=0 and id!=7";
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
 		return $resultado;
 	}

 	public function getSocioById($id) {
 		$sql = "SELECT  s.id, s.prefijo, s.nombre, s.apellidop, s.apellidom, s.email, s.password, s.curp, s.fec_nacimiento, s.sexo, s.activo, c.categoria, s.numsocio, c.es_socio, s.referencia, s.categoria_id, dp.especialidad, dp.ced_profesional, dp.ced_especialidad, dp.subespecialidad, dp.institucion, dp.anio_ingreso, dd.calle, dd.numint, dd.numext, s.institucion_academica, s.institucion_hospitalaria, dd.colonia, dd.delomun, dd.cp, dd.estado_id, dd.pais_id, s.nacionalidad_id,s.especialidad_certificacion, r.referencia FROM socios as s INNER JOIN categorias as c on s.categoria_id=c.id INNER JOIN datos_profesionales as dp ON s.id=dp.socio_id INNER JOIN datos_direcciones as dd ON dd.socio_id=s.id LEFT JOIN referencias as r ON r.usado_por=s.id WHERE s.id=" . $id;
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		return $resultado;
 	}

 	public function getDatosGenerales($socio) {
 		$sql = "SELECT s.id, s.prefijo, s.nombre, s.apellidop, s.apellidom, s.email, s.password, s.curp, s.fec_nacimiento, s.sexo, s.activo, s.categoria_id, s.numsocio, s.referencia, s.nacionalidad_id, s.pais_id, s.estado_id, s.telefono, s.telefono_emer, s.notas, s.celular, s.cedpro, s.cedesp, s.cedsub, s.hospital, s.institucion_academica, s.institucion_hospitalaria,  s.fecha_egreso, p.pais, n.nacionalidad, c.categoria, s.rfc, s.nombre_constancia, s.pais_id, s.nacionalidad_id, s.forma_certificacion, s.fecha_certificacion, s.fecha_certificacion_fin, s.especialidad_certificacion, s.nom_uni_cursada, s.nom_prof_curso_espec, s.email_prof_curso_espec, s.year_residencia_curso_espec, s.periodo_curso_espec, s.year_fin_curso_espec, s.estatus_tesis, s.estatus_titulo_uni, s.antes_exam_cmmc, s.num_antes_exam_cmmc, r.referencia
 		FROM socios as s INNER JOIN categorias as c on s.categoria_id=c.id INNER JOIN nacionalidades as n ON n.id=s.nacionalidad_id INNER JOIN paises as p ON p.id=s.pais_id LEFT JOIN referencias as r ON r.usado_por=s.id WHERE s.id=" . $socio;
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		return $resultado;
 	}

 	public function getDirecciones($socio) {
 		$sql = "SELECT * FROM datos_direcciones WHERE socio_id=" . $socio;
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		return $resultado;
 	}
	 public function getSociosAll() {
		$sql = "SELECT s.id, s.prefijo, s.nombre, s.apellidop, s.apellidom, s.email, s.password, s.curp, s.fec_nacimiento, s.sexo, s.activo, c.categoria, s.numsocio, c.es_socio, s.referencia, s.categoria_id, s.nacionalidad_id, pp.pais, n.pais as nacionalidad, s.telefono, s.notas FROM socios as s 
		INNER JOIN categorias as c on s.categoria_id=c.id 
		INNER JOIN paises as pp ON pp.id=s.pais_id 
		INNER JOIN paises as n ON n.id=s.nacionalidad_id";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
		return $resultado;
	}
 	public function getReporteGral() {
 		$sql = "SELECT  s.id, s.prefijo, s.nombre, s.apellidop, s.apellidom, s.email, s.password, s.curp, s.fec_nacimiento, s.sexo, s.activo, c.categoria, s.numsocio, c.es_socio, s.referencia, s.categoria_id, dp.especialidad, dp.ced_profesional, dp.ced_especialidad, dp.subespecialidad, dp.institucion, dp.anio_ingreso, dd.calle, dd.numint, dd.numext, dd.colonia, dd.delomun, dd.cp, dd.estado_id, dd.pais_id, s.nacionalidad_id, e.estado, pp.pais, n.pais as nacionalidad, r.region, p.anios_academico, p.ultimo_pago, p.cuotas_pagadas, p.adeudo, p.an2019, p.an2018, p.an2017, p.an2016, p.an2015, p.an2014, p.an2013, p.an2012, p.an2011, p.an2010, p.an2009, p.an2008, p.an2007, p.an2006, p.an2005, p.an2004, p.an2003, p.an2002, p.an2001, p.an2000, p.an1999, p.an1998, p.an1997, p.an1996, p.an1995, p.an1994, p.total, s.telefono, s.notas, s.asistencia, s.asistencia2
 		FROM socios as s
 		INNER JOIN categorias as c on s.categoria_id=c.id
 		INNER JOIN datos_profesionales as dp ON s.id=dp.socio_id
 		INNER JOIN datos_direcciones as dd ON dd.socio_id=s.id
 		INNER JOIN datos_pagos as p ON p.socio_id=s.id
 		INNER JOIN estados as e ON e.id=dd.estado_id
 		INNER JOIN paises  as pp ON pp.id=dd.pais_id
 		INNER JOIN paises  as n ON n.id=s.nacionalidad_id
 		LEFT JOIN  regiones as r ON r.id=s.region_id
 		WHERE c.es_socio=1 ";
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
 		return $resultado;
 	}

 	public function getConsultorio($id) {
 		$sql = "SELECT  * FROM datos_consultorios  WHERE socio_id=" . $id;
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		return $resultado;
 	}

 	public function getInstituciones($id) {
 		$sql = "SELECT  * FROM datos_instituciones  WHERE socio_id=" . $id;
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
 		return $resultado;
 	}

 	public function getInstitucionesBySocio($id) {
 		$sql = "SELECT  * FROM datos_instituciones  WHERE socio_id=" . $id . " LIMIT 1";
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		return $resultado;
 	}

 	public function getAcademias($id) {
 		$sql = "SELECT  * FROM datos_academias  WHERE socio_id=" . $id;
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
 		return $resultado;
 	}

 	public function getEstudios($id) {
 		$sql = "SELECT  * FROM datos_estudios  WHERE socio_id=" . $id;
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
 		return $resultado;
 	}

 	public function getDatosFacturacion($socio) {
 		$sql = "SELECT count(*) as existe, e.estado, sf.descripcion, df.id, df.razon_social, df.rfc, df.calle, df.numext, df.numint, df.colonia, df.cp, df.delomun, df.estado_id, df.email  FROM socios_facturacion as sf INNER JOIN datos_facturacion as df on sf.datos_id=df.id  INNER JOIN estados as e ON e.id=df.estado_id WHERE sf.principal=1 AND sf.socio_id=" . $socio . " LIMIT 1";
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		return $resultado;
 	}

 	public function getSociosByCampo($variable, $campo) {
 		$sql = "SELECT s.id, s.nombre, s.apellidop, s.apellidom, c.categoria, s.email, s.numsocio, c.es_socio, s.categoria_id FROM socios as s INNER JOIN categorias as c on s.categoria_id=c.id WHERE ";
 		$esgafete = false;
 		if (is_numeric($variable)) {
 			$socio = $this->getIdSocioGafete($variable, "gafetes2018");

 			if ($socio->existe) {
 				if ($socio->socio_id > 0) {
 					$variable = $socio->socio_id;
 					$campo = "numsocio";
 				} else {
 					$variable = "0";
 					$campo = "numsocio";
 				}
 			} else {
 				$variable = 0;
 				$campo = "numsocio";
 			}
 		}

 		if ($campo == "numsocio") {
 			$sql .= " s.id=" . $variable . " ";
 		} elseif ($campo == "email") {
 			$sql .= " s.email='" . $variable . "' ";
 		} elseif ($campo == "curp") {
 			$sql .= " s.curp='" . $variable . "' ";
 		} else {
 			$textoabuscarsplit = str_word_count($variable, 1);
 			$sql .= " CONCAT(s.apellidop ,' ', s.apellidom ,' ',s.nombre) LIKE '%" . $textoabuscarsplit[0] . "%'";
 			for ($i = 1; $i < str_word_count($variable); $i++) {
 				$sql .= " and CONCAT(s.apellidop ,' ',s.apellidom , ' ',s.nombre) LIKE '%" . $textoabuscarsplit[$i] . "%'";
 			}
 		}

 		$sql .= "  ORDER BY s.nombre, s.apellidop, s.apellidom";
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
 		return $resultado;
 	}

 	public function getEventosByCategoria($categoria, $anual) {
 		$sql = "SELECT * FROM eventos WHERE " . $categoria . "=1 AND anualidad=" . $anual . " order by anio desc";
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
 		return $resultado;
 	}

 	public function eventoRegistradoCompleto($socio_id, $evento = "") {
 		$sql = "SELECT count(*) as registro_completo FROM " . $evento . " WHERE estatus!='PENDIENTE' AND  estatus!='CANCELADO' AND  estatus!='REVISION DE COMPROBANTE' AND socio_id=" . $socio_id;
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		return $resultado->registro_completo;
 	}

 	public function asistenciaEvento($evento, $socio_id) {
 		$sql = "SELECT count(id) as registrado FROM " . $evento . " WHERE socio_id=" . $socio_id;
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		return $resultado->registrado;
 	}

 	public function getGafeteBySocio($socio_id, $evento) {
 		$sql = "SELECT id FROM " . $evento . " WHERE socio_id=" . $socio_id;
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		return $resultado->id;
 	}

 	public function getInfoGafete($gafete, $evento) {
 		$sql = "SELECT  g.id, g.nombre, g.email,g.socio_id,g.beca,g.fecha_hora,g.especialidad,g.usuario_id,g.motivo,g.cena,g.apellidop,g.apellidom, e.estado  FROM " . $evento . " as g LEFT JOIN estados as e on e.id=g.estado WHERE g.id=" . $gafete;
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		return $resultado;
 	}

 	public function getIdSocioGafete($gafete, $evento) {
 		$sql = "SELECT count(g.id) as existe, g.socio_id FROM " . $evento . " as g  WHERE g.socio_id>0 and g.id=" . $gafete;
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		return $resultado;
 	}

 	public function constancias($evento) {
 		$sql = "SELECT * FROM " . $evento;
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
 		return $resultado;
 	}

 	public function eventoPagado($socio_id, $conceptos, $evento = "") {
 		$sql = "SELECT count(*) as pagado FROM detalles_factura as df INNER JOIN facturas as f ON f.id=df.factura_id WHERE f.estatus=1 AND f.socio_id=" . $socio_id . " AND df.concepto_id in (" . $conceptos . ")";
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		if ($resultado->pagado) {
 			return true;
 		} elseif ($evento != "") {
 			if ($this->getEventoAnteriorPagado($socio_id, $evento)) {
 				return true;
 			} else {
 				return false;
 			}
 		} else {
 			return false;
 		}
 	}

 	public function getEventoAnteriorPagado($socio_id, $evento) {
 		$sql = "SELECT count(*) as pagado FROM datos_pagos WHERE socio_id=" . $socio_id . " AND an" . $evento . "=0;";
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		if ($resultado->pagado) {
 			return true;
 		} else {
 			return false;
 		}
 	}

 	public function existeEmail($email) {
 		$sql = "SELECT count(*) as existe FROM socios WHERE email like '" . $email . "' AND activo=1";
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		if ($resultado->existe) {
 			return true;
 		} else {
 			return false;
 		}
 	}

 	public function getSaldo($socio) {
 		$sql = "SELECT total FROM datos_pagos WHERE socio_id=" . $socio;
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		return $resultado->total;
 	}

	public function getFechaCerfect(){
		$sql = "SELECT * FROM fecha_certificacion WHERE estatus = 1";
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		return $resultado;
	}

	public function getBuscarMasivo($certificado, $socio){
		$sql = "SELECT * FROM recordatorio_vigencia WHERE certificado_id = $certificado AND socio_id = $socio";
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		return $resultado;
	}

	public function getIdGroupByAll() {
		$sql = "SELECT * FROM datos_certificados GROUP BY socio_id ORDER BY socio_id";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
		return $resultado;
	}

 	public function getCertificados($socio) {
 		$sql = "SELECT * FROM datos_certificados WHERE socio_id=" . $socio . " AND estatus_certificado = 1 order by fecha_inicio desc ";
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
 		return $resultado;
 	}

	public function getCertificadosDesc($socio) {
		$sql = "SELECT * FROM datos_certificados WHERE socio_id=" . $socio . " AND estatus_certificado = 1 order by fecha_inicio desc limit 1";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
		return $resultado;
	}
	public function getCertificadosMeses($socio, $dia) {
		$sql = "SELECT TIMESTAMPDIFF(MONTH, '$dia', fecha_fin) AS meses FROM datos_certificados WHERE socio_id=" . $socio . " AND estatus_certificado = 1 order by fecha_inicio desc limit 1";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
		return $resultado;
	}
	public function getCertificadosDescFin($socio) {
		$sql = "SELECT * FROM datos_certificados WHERE socio_id=" . $socio . " AND estatus_certificado = 1 order by fecha_fin desc limit 1";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
		return $resultado;
	}

 	public function getCertificado($socio) {
 		$sql = "SELECT count(id) as tiene, certificado FROM datos_certificados WHERE socio_id=" . $socio . " LIMIT 1";
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		return $resultado->certificado;
 	}

 	public function getCertificadoUltimo($socio) {
 		$sql = "SELECT * FROM datos_certificados WHERE socio_id=" . $socio . " order by fecha_inicio desc LIMIT 1";
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		return $resultado;
 	}

 	public function becaBecadoEvento($socio, $evento) {
 		$sql = "SELECT count(*) as becado FROM becas as b INNER JOIN laboratorios as l ON l.id=b.laboratorio_id WHERE l.evento_id=" . $evento . " AND b.socio_id=" . $socio;
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		return $resultado->becado;
 	}

 	public function getDatosPagosAnteriores($socio) {
 		$sql = "SELECT * FROM datos_pagos WHERE socio_id=" . $socio;
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		return $resultado;
 	}

 	public function getStatus($socio) {
 		$sql = "SELECT se.estatus_id as id, e.estatus, se.fecha_hora FROM socios_estatus as se INNER JOIN estatus as e on e.id=se.estatus_id WHERE se.actual=1 and se.socio_id=" . $socio;
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		return $resultado;
 	}
 	public function getForma($socio) {
 		$sql = "SELECT f.id, f.forma FROM socios as s INNER JOIN formas_certificacion as f on f.id=s.forma_certificacion WHERE s.id=" . $socio;
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		return $resultado;
 	}

 	public function direccionRegistrada($socio) {
 		$sql = "SELECT count(id) as registrado FROM datos_direcciones WHERE socio_id=" . $socio;
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		return $resultado->registrado;
 	}

 	public function consultorioRegistrado($socio) {
 		$sql = "SELECT count(id) as registrado FROM datos_consultorios WHERE socio_id=" . $socio;
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		return $resultado->registrado;
 	}

 	public function institucionRegistrada($socio) {
 		$sql = "SELECT count(id) as registrado FROM datos_instituciones WHERE socio_id=" . $socio;
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		return $resultado->registrado;
 	}

 	public function academiaRegistrada($socio) {
 		$sql = "SELECT count(id) as registrado FROM datos_academias WHERE socio_id=" . $socio;
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		return $resultado->registrado;
 	}

 	public function estudioRegistrado($socio) {
 		$sql = "SELECT count(id) as registrado FROM datos_estudios WHERE socio_id=" . $socio;
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		return $resultado->registrado;
 	}

 	public function documentoRegistrado($socio) {
 		$sql = "SELECT count(id) as registrado FROM datos_documentacion WHERE socio_id=" . $socio;
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		return $resultado->registrado;
 	}

 	public function getTablaPuntaje() {
 		$sql = "SELECT * FROM puntajes ";
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
 		return $resultado;
 	}

 	public function getTablaDocumentos($categoria) {
 		$sql = "SELECT * FROM documentos_puntaje WHERE categoria_id=" . $categoria;
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
 		return $resultado;
 	}

	public function getDocCVAll() {
		$sql = "SELECT * FROM puntos_socios";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
		return $resultado;
	}

	public function getSedes() {
		$sql = "SELECT * FROM sedes WHERE activo = 1 ORDER BY id ASC";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
		return $resultado;
	}
	public function getSedesByDatos() {
		$sql = "SELECT * FROM datos_permiso_socio AS dps INNER JOIN sedes AS sd ON dps.sede = sd.sede AND sd.activo=1 AND socio_id = 677";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
		return $resultado;
	}
	public function getInicioSolicitudAll() {
		$sql = "SELECT * FROM inicio_proceso WHERE proceso = 1 AND fecha_hora > DATE_SUB(NOW(),INTERVAL '4-6' YEAR_MONTH) order by fecha_hora asc";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
		return $resultado;
	}
	public function getInicioSolicitud($socio) {
		$sql = "SELECT * FROM inicio_proceso WHERE id_socio = $socio AND proceso = 1 AND fecha_hora > DATE_SUB(NOW(),INTERVAL '4-6' YEAR_MONTH)";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
		return $resultado;
	}

	public function confirmacionInicio($inicio) {
		$sql = "SELECT * FROM solicitudes WHERE id_inicio = $inicio";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
		return $resultado;
	}

 	public function getMisdocumentos($socio,$id_inicio) {
 		$sql = "SELECT ps.id, ps.aceptado, c.categoria, dp.documento, ps.ruta, ps.fecha_hora , ps.puntos_presentados, ps.puntos_avalados, concat(u.nombre, ' ', u.apellidos) as autoriza
 		FROM puntos_socios as ps
 		INNER JOIN documentos_puntaje as dp on dp.id=ps.documento_id
 		INNER JOIN puntajes as c on c.id=dp.categoria_id
 		LEFT JOIN usuarios as u on u.id=ps.autorizado_por
 		WHERE ps.socio_id=" . $socio . " and ps.id_inicio =".$id_inicio." and ps.fecha_hora > DATE_SUB(NOW(),INTERVAL '4-6' YEAR_MONTH)";
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
 		return $resultado;
 	}
//  MODIFICADO EL 04 DE MARZO DE 2020
 	public function getPuntosPresentadosByCategoria($categoria, $socio, $inicio) {
 		$sql = "SELECT sum(ps.puntos_presentados) as total FROM puntos_socios as ps INNER JOIN documentos_puntaje as dp on dp.id=ps.documento_id INNER JOIN puntajes as c on c.id=dp.categoria_id WHERE ps.socio_id=" . $socio . " and ps.id_inicio=".$inicio." and c.id=" . $categoria . " and ps.fecha_hora > DATE_SUB(NOW(),INTERVAL '4-6' YEAR_MONTH)";
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		if ($resultado) {
 			return $resultado->total;
 		} else {
 			return 0;
 		}
 	}

 	public function getPuntosAvaladosByCategoria($categoria, $socio, $inicio) {
 		$sql = "SELECT sum(ps.puntos_avalados) as total FROM puntos_socios as ps INNER JOIN documentos_puntaje as dp on dp.id=ps.documento_id INNER JOIN puntajes as c on c.id=dp.categoria_id WHERE ps.socio_id=" . $socio . "  and ps.id_inicio=".$inicio." and c.id=" . $categoria;
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		if ($resultado) {
 			return $resultado->total;
 		} else {
 			return 0;
 		}
 	}

 	public function recuperarPassword($email) {
 		$sql = "SELECT * FROM socios WHERE email like '" . $email . "' AND activo=1 LIMIT 1";
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		return $resultado;
 	}

 	public function getSolcitudesBySocio($socio_id) {
 		$sql = "SELECT s.id, s.socio_id, s.especialidad, s.fecha_creacion, s.estatus, f.forma as proceso, s.sede, s.fecha_confirmacion, s.folio, f.forma FROM solicitudes as s INNER JOIN formas_certificacion as f on f.id=s.forma WHERE s.socio_id=" . $socio_id . " order by s.fecha_creacion desc";
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
 		return $resultado;
 	}

 	public function getSolcitudesBySocioEspecialidad($socio_id, $especialidad) {
 		$sql = "SELECT * FROM solicitudes WHERE socio_id=" . $socio_id . " and especialidad like '" . $especialidad . "' and (estatus!='Finalizado' and estatus!='No Aprobado') ";
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
 		return $resultado;
 	}

 	public function getSolicitudById($solicitud) {
 		$sql = "SELECT s.id, s.socio_id, s.especialidad, s.fecha_creacion, s.estatus, f.forma as proceso, s.sede, s.folio FROM solicitudes as s INNER JOIN formas_certificacion as f on f.id=s.forma WHERE s.id=" . $solicitud;
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		return $resultado;
 	}

 	public function getTotalSolicitudes($sede) {
 		$sql = "SELECT count(id) as total FROM solicitudes WHERE estatus='Confirmada' and sede='" . $sede . "' ";
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		return $resultado->total;
 	}

 	public function getTotalSolicitudesPendientes($sede, $especialidad="") {
 		$sql = "SELECT count(id) as total FROM solicitudes WHERE estatus='Confirmada' and sede='" . $sede . "' and especialidad like '" . $especialidad . "' ";
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		return $resultado->total;
 	}

 	public function checkRevision($documento, $socio) {
 		$sql = "SELECT r.id as revisado, r.fecha_hora, concat(u.nombre,' ',u.apellidos) as revisor, r.estatus, r.documento_id FROM revisiones as r LEFT JOIN usuarios as u on r.usuario_id=u.id WHERE r.socio_id=" . $socio . " and r.documento_id=" . $documento . " order by r.fecha_hora desc LIMIT 1";
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetch(PDO::FETCH_OBJ);
 		return $resultado;
 	}
 	public function ReporteAll() {
 		$sql = "SELECT s.prefijo, s.nombre, s.apellidop, s.apellidom, s.institucion_academica, s.institucion_academica, s.hospital, s.hospital, s.rfc, s.curp, s.cedpro, s.fec_nacimiento, naci.nacionalidad, estado.estado, datosd.delomun, s.sexo, datosc.fecha_registro, datosc.fecha_inicio, datosc.fecha_fin, datosc.certificado, datosc.libro, datosc.foja, datosc.presidente, datosc.responsable, s.email, datosc.especialidad FROM socios as s INNER JOIN nacionalidades as naci ON s.nacionalidad_id = naci.id INNER JOIN datos_direcciones as datosd ON s.id = datosd.socio_id INNER JOIN estados as estado ON datosd.estado_id = estado.id INNER JOIN datos_certificados as datosc ON s.id = datosc.socio_id WHERE s.id=3";
 		$sentencia = $this->conexion_db->prepare($sql);
 		$sentencia->execute(array());
 		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
 		return $resultado;
 	}

 }

?>