<?php
class Constancia extends Conexion
{
    public function __construct()
    {
        parent::__construct();
        $this->setTabla("alumnos");
    }
}
