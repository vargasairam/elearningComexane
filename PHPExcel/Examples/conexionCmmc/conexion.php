<?php
/**
* Clase para conectar con la base de datos
*/
class Conexion
{
	protected $conexion_db;
	private $tabla;

	public function __construct()
	{
		try {
			$this->conexion_db = new PDO("mysql:host=".host."; dbname=".db, usuario, password);
			$this->conexion_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->conexion_db->exec("SET CHARACTER SET utf8");
			return $this->conexion_db;
		} catch (PDOException $e) {
			echo "Error en la linea ".$e->getLine().": ".$e->getMessage();
		}
	}

	public function setTabla($tabla){
		$this->tabla=$tabla;
	}

	public function insertar($campos,$valores){
		if(count($campos) != count($valores))
		{ 
			echo "No coinciden columnas";
			exit;
			return false;
		}else{
			$str_campos=implode(",",$campos);
			$str_valores="";
			for ($i=0; $i < count($campos) ; $i++) { 
				$str_valores.=":".$campos[$i].", ";
			}
			$str_valores = substr ($str_valores, 0, strlen($str_valores) - 2);
			$sentencia=$this->conexion_db->prepare("INSERT INTO ".$this->tabla." (".$str_campos.") VALUES (".$str_valores.")");
			$datos=array();
			for ($i=0; $i < count($campos) ; $i++) { 
				$datos[':'.$campos[$i]]=$valores[$i];
			}
			if ($sentencia->execute($datos)){
				return $this->conexion_db->LastInsertId();
			}else{
				return false;
			}
		}
	}


	public function actualizar($campos,$valores, $condicion){
		if(count($campos) != count($valores))
		{ 
			echo "No coinciden columnas";
			exit;
			return false;
		}else{
			$str_campos="";
			for ($i=0; $i < count($campos) ; $i++) { 
				$str_campos.=$campos[$i]."=:".$campos[$i].", ";
			}
			$str_campos = substr ($str_campos, 0, strlen($str_campos) - 2);
			$sentencia=$this->conexion_db->prepare("UPDATE ".$this->tabla." SET ".$str_campos." WHERE ".$condicion);
			$datos=array();
			for ($i=0; $i < count($valores) ; $i++) { 
				$datos[':'.$campos[$i]]=$valores[$i];
			}
			if ($sentencia->execute($datos)){
				return true;
			}else{
				return false;
			}
		}
	}

	public function eliminar($condicion){
		$sentencia = $this->conexion_db->prepare("DELETE FROM ".$this->tabla." WHERE ".$condicion);
		return $sentencia->execute();
	}

	public function __destruct()
	{
		$this->conexion_db=null;
	}
}
?>