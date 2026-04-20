<?php
error_reporting(E_ALL & ~E_DEPRECATED & ~E_WARNING & ~E_NOTICE);
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
    include 'config/config.php';
    require 'core/conexion.php';
require 'model/helper.php';
require 'model/alumno.php';

$A = new Alumno();
//if(isset($_POST["export_data"])) {

require_once './PHPExcel/PHPExcel.php';

$objPHPExcel = new PHPExcel();
$H = new Helper();
$objDrawing = new PHPExcel_Worksheet_Drawing();
// Set document properties
$objPHPExcel->getProperties()->setCreator("JC-INNOVATION")
                             ->setLastModifiedBy("JC-INNOVATION")
                             ->setTitle("Office 2007 XLSX Test Document")
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                             ->setKeywords("Office 2007 openxml php")
                             ->setCategory("Categoria");

// Add some data
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(11);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(33);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(30);


$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '#')
            ->setCellValue('B1', 'ID_usuario') //
            ->setCellValue('C1', 'Nombre')
            ->setCellValue('D1', 'Apellidos')
            ->setCellValue('E1', 'Email')

            ->setCellValue('F1', 'Categoría')
            ->setCellValue('G1', 'País')    //
            ->setCellValue('H1', 'Estado')
            ->setCellValue('I1', 'Teléfono')

            ->setCellValue('J1', 'Estatus')
            ->setCellValue('K1', 'Observaciones')
            ->setCellValue('L1', 'Módulos') //
            ->setCellValue('M1', 'Monto')   //
            ->setCellValue('N1', 'Fecha de registro')
            ->setCellValue('O1', 'Fecha de pago')
            ->setCellValue('P1', 'Datos fiscales');

            $headerStyle = array(
                    'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb'=>'8e1009'),
                ),
                    'font' => array(
                    'bold' => true,
                    'color' => array('rgb'=>'FFFFFF')
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                )
            );
            
            
            #esta linea aplica un estilo al fondo, yo la utilizo para los titulos de las columnas.
$objPHPExcel->getActiveSheet()->getStyle('A1:P1')->applyFromArray($headerStyle);
// $data = $A->getAlumnos_2024_E();
// $data = $A->getAlumnos_2024();
$data = $A->getAlumnos_2024_Reporte();
$i=0;
$j=1;

foreach($data as $dat){
    $i++;
    $j++;
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$j,$i);
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$j, $dat->id);
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$j, $dat->nombre);
    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$j, $dat->apellidos);
    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$j, $dat->email);

    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$j, $dat->categoria);
    
    
    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$j, $dat->pais);
    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$j, $dat->estado);
    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$j, $dat->telefono);


    if($dat->estatus=="PAGADO" || $dat->estatus=="BECADO"){
        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$j, $dat->estatus);
    }else{
        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$j, 'Pendiente');
    }

    $objPHPExcel->getActiveSheet()->SetCellValue('K'.$j, $dat->observaciones);

    $modulos = $A->getModulosPagados($dat->id);
    $total = 0;
    $text_modulos = "";
    $separador = "";
    foreach ($modulos as $modulo) {
        $total=$total+$dat->monto;
        $text_modulos.=$separador.$modulo->modulo;
        $separador=", ";
    }
    $objPHPExcel->getActiveSheet()->SetCellValue('L'.$j, $text_modulos);

    if($total>0){
        $objPHPExcel->getActiveSheet()->SetCellValue('M'.$j, $total);
    }else{
        $objPHPExcel->getActiveSheet()->SetCellValue('M'.$j, $dat->monto);
    }
 
    $objPHPExcel->getActiveSheet()->SetCellValue('N'.$j, $dat->fecha_registro);
    $objPHPExcel->getActiveSheet()->SetCellValue('O'.$j, $dat->fecha_pago);

    if($dat->rfc){
        $objPHPExcel->getActiveSheet()->SetCellValue('P'.$j, 'RFC:' .$dat->rfc.", Razon social: ".$dat->razon_social.", CP: ".$dat->codigo_postal.", Estado: ".$dat->estadof.", Uso de CFDI: ".$dat->uso_de_cfdi);
    }

    
}
$objPHPExcel->getActiveSheet()->getStyle('A2:T'.$j)
    ->getAlignment()->setWrapText(true);    
    
$objPHPExcel
    ->getActiveSheet()
    ->getStyle('A2:T'.$j)
    ->getNumberFormat()
    ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
$objPHPExcel->getActiveSheet()->getStyle('A2:T'.$j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Control');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

//limpiamos buffers
while (ob_get_level()) {
    ob_end_clean();
}

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-Disposition: attachment;filename="Control.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
file_put_contents('debug.txt', 'OK antes de generar');
$objWriter->save('php://output');
exit;