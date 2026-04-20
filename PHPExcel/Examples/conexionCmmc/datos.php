<?php
 class DatosGraficas extends Conexion {
    public function datosPaises($ids){
        $sql = "SELECT pp.pais, count(*) as total
            FROM socios as s 
            INNER JOIN paises as pp ON pp.id=s.pais_id WHERE s.id IN ($ids) group by pp.pais";
            $sentencia = $this->conexion_db->prepare($sql);
            $sentencia->execute(array());
            $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
            return $resultado;
    }
    public function datosCategorias($ids){
        $sql = "SELECT c.categoria, count(*) as total
            FROM socios as s 
            INNER JOIN categorias as c on s.categoria_id=c.id WHERE s.id IN ($ids)  group by c.categoria";
            $sentencia = $this->conexion_db->prepare($sql);
            $sentencia->execute(array());
            $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
            return $resultado;
    }
    public function datosNacionalidad($ids){
        $sql = "SELECT n.nacionalidad, COUNT(*) as total FROM socios as s 
        inner join nacionalidades as n on n.id=s.nacionalidad_id WHERE s.id IN ($ids) group by n.nacionalidad";
            $sentencia = $this->conexion_db->prepare($sql);
            $sentencia->execute(array());
            $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
            return $resultado;
    }
    public function datosInstituto($ids){
        $sql = "SELECT institucion_hospitalaria, COUNT(*) AS total FROM socios WHERE id IN ($ids) and institucion_hospitalaria != '' AND institucion_hospitalaria != '-Select state-' GROUP BY institucion_hospitalaria";
            $sentencia = $this->conexion_db->prepare($sql);
            $sentencia->execute(array());
            $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
            return $resultado;
    }
    public function datosInstitutoA($ids){
        $sql = "SELECT institucion_academica, COUNT(*) AS total FROM socios WHERE id IN ($ids) and institucion_academica != '' GROUP BY institucion_academica";
            $sentencia = $this->conexion_db->prepare($sql);
            $sentencia->execute(array());
            $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
            return $resultado;
    }
    public function datosEstatusTesis($ids){
        $sql = "SELECT estatus_tesis, COUNT(*) AS total FROM socios WHERE id IN ($ids) and estatus_tesis != '' GROUP BY estatus_tesis";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute(array());
        $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $resultado;
    }
    public function datosEstatusUni($ids){
        $sql = "SELECT estatus_titulo_uni, COUNT(*) AS total FROM socios WHERE id IN ($ids) and estatus_titulo_uni != '' GROUP BY estatus_titulo_uni";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute(array());
        $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $resultado;
    }
    public function datosEspecialidad(){
        $date = date('Y-m-d');
        $sql = "SELECT especialidad, COUNT(*) as total FROM datos_certificados WHERE estatus = 'Vigente' AND fecha_fin >= '$date' GROUP BY especialidad";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute(array());
        $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $resultado;
    }
    public function datosEdad($ids){
        $dia = date('d');
        $mes = date('m');
        $sql = "SELECT YEAR(CURDATE())-YEAR(fec_nacimiento) + IF(DATE_FORMAT(CURDATE(),'%$mes-%$dia') > DATE_FORMAT(fec_nacimiento,'%m-%d'), 0 , -1 ) AS edad, COUNT(*) AS total FROM socios WHERE id IN ($ids) GROUP BY edad";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute(array());
        $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $resultado;
    }
    public function datosEstado($ids){
        $sql = "SELECT e.estado, COUNT(*) AS total FROM socios AS s LEFT JOIN estados AS e ON s.estado_id=e.id WHERE s.estado_id!=0 AND s.id IN ($ids) GROUP BY e.estado";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute(array());
        $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $resultado;
    }


 }