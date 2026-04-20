<?php

class AlumnoFacturacion extends Conexion
{

    public function __construct()
    {
        parent::__construct();
        $this->setTabla('alumno_facturacion');
    }

    /**
     * Obtener datos de facturación
     * @param $alumnoId
     * @param false $toArray obtener un array
     * @return false|array|object
     */
    public function obtener($alumnoId, $toArray = false)
    {
        $select_sql = 'SELECT id, rfc, razon_social, estado, codigo_postal, uso_de_cfdi, regimen_fiscal, municipio, colonia, calle, pais FROM e26_alumno_facturacion'
            . ' WHERE alumno_id = :alumno_id';
        $sentencia = $this->conexion_db->prepare($select_sql);
        if (!$sentencia->execute(array('alumno_id' => $alumnoId))) {
            return false;
        }
        if ($sentencia->rowCount() == 0) {
            return false;
        }
        if ($toArray) {
            return $sentencia->fetch(PDO::FETCH_ASSOC);
        }
        return $sentencia->fetchObject();
    }

    /**
     * Crear datos de facturación
     * @param integer $alumnoId
     * @param array $campos
     * @return false|string
     */
    public function crear($alumnoId, array $campos)
    {
        $campos['alumno_id'] = $alumnoId;
        $insert_sql = 'INSERT INTO alumno_facturacion (`' . implode('`, `', array_keys($campos)) . '`)'
            . " VALUES(:" . implode(", :", array_keys($campos)) . ")";
        $sentencia = $this->conexion_db->prepare($insert_sql);
        if (!$sentencia->execute($campos)) {
            return false;
        }
        $campos['id'] = (integer) $this->conexion_db->lastInsertId();
        return $campos;
    }

    /**
     * Actualizar datos de facturación por alumno
     * @param integer $alumnoId
     * @param array $campos
     * @return bool
     */
    public function modificarAlumno($alumnoId, array $campos)
    {
        return $this->modificar('alumno_id', $alumnoId, $campos);
    }

    /**
     * Actualizar datos de facturación
     * @param integer $id
     * @param array $campos
     * @return bool
     */
    public function modificarFacturacion($id, array $campos)
    {
        return $this->modificar('id', $id, $campos);
    }

    /**
     * Actualizar datos de facturación dinamico
     * @param string $campoId Nombre del campo clave
     * @param integer $valorId Valor del campo clave
     * @param array $campos
     * @return bool
     */
    // private function modificar($campoId = 'id', $valorId, array $campos)
    // {
    //     $fields = array();
    //     foreach (array_keys($campos) as $campo) {
    //         $fields[] = "`$campo` = :$campo";
    //     }
    //     $update_sql = 'UPDATE alumno_facturacion SET' . implode(', ', $fields)
    //         . " WHERE `$campoId` = :$campoId";
    //     $campos[$campoId] = $valorId;
    //     $sentencia = $this->conexion_db->prepare($update_sql);
    //     if (!$sentencia->execute($campos)) {
    //         return false;
    //     }
    //     return true;
    // }

    public function usoDeCFDi()
    {
        return array(
            'G01' => 'Adquisición de Mercancías',
            'G02' => 'Devoluciones, Descuentos o Bonificaciones',
            'G03' => 'Gastos en General',
            'I01' => 'Construcciones',
            'I02' => 'Mobiliario y Equipo de Oficina por Inversiones',
            'I03' => 'Equipo de Transporte',
            'I04' => 'Equipo de Cómputo y Accesorios',
            'I05' => 'Dados, Troqueles, Moldes, Matrices y Herramental',
            'I06' => 'Comunicaciones Telefónicas',
            'I07' => 'Comunicaciones Satelitales',
            'I08' => 'Otra Maquinaria y Equipo',
            'D01' => 'Honorarios Médicos, Dentales y Gastos Hospitalarios',
            'D02' => 'Gastos Médicos por Incapacidad o Discapacidad',
            'D03' => 'Gastos Funerales',
            'D04' => 'Donativos',
            'D05' => 'Intereses Reales Efectivamente Pagados por Créditos Hipotecarios (Casa Habitación)',
            'D06' => 'Aportaciones Voluntarias al SAR',
            'D07' => 'Primas por Seguros de Gastos Médicos',
            'D08' => 'Gastos de Transportación Escolar Obligatoria',
            'D09' => 'Depósitos en Cuentas para el Ahorro, Primas que tengan como Base Planes de Pensiones',
            'D10' => 'Pagos por Servicios Educativos (Colegiaturas)',
            'P01' => 'Por Definir',
        );
    }

    public function TieneDatosFactura($id){
        $sql = "SELECT COUNT(*) AS cuenta FROM e26_alumno_facturacion WHERE alumno_id = :id";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute([
            ':id'=>$id
        ]);
        $resultado = $sentencia->fetch(PDO::FETCH_OBJ);
        if($resultado->cuenta>0){
            return true;
        }
        return false;
    }

    public function GetFacturaUsuario($id){
        $sql = "SELECT * FROM e26_alumno_facturacion WHERE alumno_id = :id";
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute([
            ':id'=>$id
        ]);
        $resultado = $sentencia->fetch(PDO::FETCH_OBJ);
        return $resultado;
    }

}