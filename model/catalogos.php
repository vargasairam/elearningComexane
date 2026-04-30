<?php
class Catalogos extends Conexion
{

    public function __construct()
    {
        parent::__construct();
        $this->setTabla("categorias");
    }

    public function GetCategoriasNombres(){
        $sql = "SELECT id_categoria, nombrecategoria AS nombre_categoria, es_socio FROM categorias";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute();
        $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $resultado;
    }

    public function GetCategoriasNSocio(){
        $sql = "SELECT id_categoria, nombrecategoria AS nombre_categoria, es_socio, nombre_elearning FROM categorias WHERE es_socio = 0 AND id_categoria IN (12, 14, 17, 21, 22)";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute();
        $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $resultado;
    }

    public function GetPrefijosActivos(){
        $sql = "SELECT id,descripcion AS prefijo FROM prefijos WHERE activo = 1 ORDER BY orden ASC";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute();
        $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $resultado;
    }

    public function GetPaises(){
        $sql = "SELECT * FROM paises";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute();
        $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $resultado;
    }

    public function GetEstadosByIdPais($id){
        $sql = "SELECT * FROM e26_estados WHERE pais_id = :id";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute([
            ':id' => $id
        ]);
        $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $resultado;
    }

    public function GetTipoProductos(){
        $sql = "SELECT * FROM e26_tipoProducto";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute();
        $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $resultado;
    }

    public function getCursos(){
        $sql = "SELECT c.*, tp.tipoProducto AS tipo_producto FROM e26_cursos c LEFT JOIN e26_tipoProducto tp ON c.id_tipoProducto = tp.id";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute();
        $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $resultado;
    }

    public function GetTipoProductoById($id){
        $sql = "SELECT * FROM e26_tipoProducto WHERE id = :id";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute([
            ':id' => $id
        ]);
        $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $resultado;
    }

    public function getCursoById($id){
        $sql = "SELECT * FROM e26_cursos WHERE id = :id";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute([
            ':id' => $id
        ]);
        $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $resultado;
    }

    public function getCursosActivos(){
        $sql = "SELECT * FROM e26_cursos WHERE activo = 0 AND habilitado = 0";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute();
        $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $resultado;
    }

    public function GetCursosCarrito($id){
        $sql = "SELECT cc.id, cc.id_curso, c.titulo, c.descripcion, c.precio, COUNT(cc.id) AS cantidad  FROM e26_cursos_carrito cc INNER JOIN e26_cursos c ON cc.id_curso = c.id WHERE cc.id_alumno = :id GROUP BY cc.id_curso, c.titulo, c.descripcion, c.precio;";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute([
            ':id' => $id
        ]);
        $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $resultado;
    }

    public function GetSesiones(){
        $f_actual = date("Y-m-d H:i:s");
        $sql = "SELECT * FROM e_conferencias WHERE fecha_hora_inicio > :f_actual ORDER BY fecha_hora_inicio DESC";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute([
            ':f_actual' => $f_actual
        ]);
        $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $resultado;
    }

    public function GetSesionesAll(){
        $f_actual = date("Y-m-d H:i:s");
        $sql = "SELECT * FROM e_conferencias ORDER BY id DESC";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute();
        $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $resultado;
    }

    public function getSesionById($id){
        $sql = "SELECT * FROM e_conferencias WHERE id = :id";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute([
            ':id' => $id
        ]);
        $resultado = $sentencia->fetch(PDO::FETCH_OBJ);
        return $resultado;
    }

    public function getModulosCurso($id_curso){
        $sql = "SELECT * FROM e26_modulos_cursos WHERE id_curso = :id_curso";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute([
            ':id_curso' => $id_curso
        ]);
        $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $resultado;
    }

    public function getVideosCurso($id_curso){
        $sql = "SELECT * FROM e26_videos_cursos WHERE id_curso = :id_curso";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute([
            ':id_curso' => $id_curso
        ]);
        $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $resultado;
    }



    /*public function GetEstadosByIdPais(){
        $sql = "SELECT * FROM estado";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute();
        $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $resultado;
    }*/

    public function GetModulos(){
        $sql = "SELECT * FROM cat_modulos WHERE activo = 1";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute();
        $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $resultado;
    }
    public function GetModulosAll(){
        $sql = "SELECT * FROM cat_modulos";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute();
        $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $resultado;
    }

    public function GetModuloById($id){
        $sql = "SELECT * FROM cat_modulos WHERE activo = 1 AND id = :id";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute([
            ':id'=>$id
        ]);
        $resultado = $sentencia->fetch(PDO::FETCH_OBJ);
        return $resultado;
    }

    public function GetModulosFecha($id = 0){
        $sql = "SELECT 
            CASE 
                WHEN NOW() < fecha_hr_inicio THEN false
                ELSE true
            END AS activar, fecha_inicio_texto
        FROM modulos";

        if($id != 0){
            $sql .= " WHERE id= :id";
        }

        $sentencia = $this->conexion_db->prepare($sql);

        if($id != 0){
            $sentencia->execute([
                ':id'=>$id
            ]);
            $resultado = $sentencia->fetch(PDO::FETCH_OBJ);
        }else{
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
        }
        
        
        return $resultado;
    }

    public function GetModuloEnvivo($id){
        $sql = "SELECT *,CASE 
                WHEN NOW() < fecha_hora_inicio THEN false
                ELSE true
            END AS activar FROM conferencias WHERE id = :id";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute([
            ':id'=>$id
        ]);
        $resultado = $sentencia->fetch(PDO::FETCH_OBJ);
        return $resultado;
    }

    public function GetRegimenFiscal(){
        $sql = "SELECT * FROM e_regimenesfiscales";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute();
        $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $resultado;
    }

    public function GetCFDI($regimen){
        $sql = "SELECT * FROM e_cfdi WHERE ids_regimenes like '%".$regimen."%'";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute();
        $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $resultado;
    }

    public function GetCFDIAll(){
        $sql = "SELECT * FROM e_cfdi ";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute();
        $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $resultado;
    }
    
}
