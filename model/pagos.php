<?php
class Pagos extends Conexion
{
    public function __construct()
    {
        parent::__construct();
        $this->setTabla("e26_pagos_cursos");
    }

    
}
