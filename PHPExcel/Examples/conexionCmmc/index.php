<?php
require 'config.php';
require 'conexion.php';
require 'datos.php';
require 'socio.php';

error_reporting(E_ALL);
ini_set('display_errors', false);
ini_set('display_startup_errors', false);

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

require_once dirname(__FILE__) . '/../../Classes/PHPExcel.php';

$S = new Socio;
    $DG = new DatosGraficas;
    $socios = $S->getSociosAll();
    $sf=0;
    $sm=0;
    $p=1;
    $array=[];
    $arrayIds=[];
    $coutSi=0;
    $coutNo=0;
    foreach($socios as $socio){
        $datos_cert=$S->getCertificadoUltimo($socio->id);
        if($datos_cert && $datos_cert->fecha_fin >= date('Y-m-d')){
            $coutSi++;
            array_push($arrayIds,$socio->id);
            if($socio->sexo=='F'){
                $sf++;
            }elseif($socio->sexo=='M'){
                $sm++;
            }
        }else{
            $coutNo++;
        }
    }
   $arrayIds = implode(", ", $arrayIds);

$objPHPExcel = new PHPExcel();
$objWorksheet = $objPHPExcel->getActiveSheet()->setTitle('Certificados');
$objWorksheet->fromArray(
	array(
		array('Concepto',	'Cantidad'),
		array('Certificado',   $coutSi),
		array('No Certificado',   $coutNo),
	)
);
$dataSeriesLabels1 = array(
	new PHPExcel_Chart_DataSeriesValues('String', 'Certificados!$B$1', NULL, 1),	//	2011
);
$xAxisTickValues1 = array(
	new PHPExcel_Chart_DataSeriesValues('String', 'Certificados!$A$2:$A$3', NULL, 2),	//	Q1 to Q4
);
$dataSeriesValues1 = array(
	new PHPExcel_Chart_DataSeriesValues('Number', 'Certificados!$B$2:$B$3', NULL, 2),
);
$series1 = new PHPExcel_Chart_DataSeries(
	PHPExcel_Chart_DataSeries::TYPE_PIECHART,				// plotType
	NULL,			                                        // plotGrouping (Pie charts don't have any grouping)
	range(0, count($dataSeriesValues1)-1),					// plotOrder
	$dataSeriesLabels1,										// plotLabel
	$xAxisTickValues1,										// plotCategory
	$dataSeriesValues1										// plotValues
);

$layout1 = new PHPExcel_Chart_Layout();
$layout1->setShowVal(false);
$layout1->setShowPercent(TRUE);

$plotArea1 = new PHPExcel_Chart_PlotArea($layout1, array($series1));

$legend1 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);

$title1 = new PHPExcel_Chart_Title('Certificados');

$chart1 = new PHPExcel_Chart(
	'chart1',
	$title1,		
	$legend1,		
	$plotArea1,		
	true,			
	0,				
	NULL,			
	NULL			
);

$chart1->setTopLeftPosition('A5');
$chart1->setBottomRightPosition('E15');

//	Add the chart to the worksheet
$objWorksheet->addChart($chart1);


$objPHPExcel->getSheetCount();//cuenta las pestañas

$positionInExcel=1;//esto es para que ponga la nueva pestaña al principio

$objPHPExcel->createSheet($positionInExcel);//creamos la pestaña
$objWorksheet2 = $objPHPExcel->setActiveSheetIndex($positionInExcel)->setTitle('Sexo');
$objWorksheet2->fromArray(
	array(
		array('Concepto',	'Cantidad'),
		array('Masculino',   $sm),
		array('Femenino',   $sf),
	)
);

$dataSeriesLabels2 = array(
	new PHPExcel_Chart_DataSeriesValues('String', 'Sexo!$B$1', NULL, 1),	//	2011
);
$xAxisTickValues2 = array(
	new PHPExcel_Chart_DataSeriesValues('String', 'Sexo!$A$2:$A$3', NULL, 2),	//	Q1 to Q4
);
$dataSeriesValues2 = array(
	new PHPExcel_Chart_DataSeriesValues('Number', 'Sexo!$B$2:$B$3', NULL, 2),
);
$series2 = new PHPExcel_Chart_DataSeries(
	PHPExcel_Chart_DataSeries::TYPE_PIECHART,				// plotType
	NULL,			                                        // plotGrouping (Pie charts don't have any grouping)
	range(0, count($dataSeriesValues2)-1),					// plotOrder
	$dataSeriesLabels2,										// plotLabel
	$xAxisTickValues2,										// plotCategory
	$dataSeriesValues2										// plotValues
);

$layout2 = new PHPExcel_Chart_Layout();
$layout2->setShowVal(false);
$layout2->setShowPercent(TRUE);

$plotArea2 = new PHPExcel_Chart_PlotArea($layout2, array($series2));

$legend2 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);

$title2 = new PHPExcel_Chart_Title('Sexo');

$chart2 = new PHPExcel_Chart(
	'chart1',
	$title2,		
	$legend2,		
	$plotArea2,		
	true,			
	0,				
	NULL,			
	NULL			
);

$chart2->setTopLeftPosition('A5');
$chart2->setBottomRightPosition('E15');

//	Add the chart to the worksheet
$objWorksheet2->addChart($chart2);



$objPHPExcel->getSheetCount();//cuenta las pestañas
$objPHPExcel->createSheet(2);
$objWorksheet3 = $objPHPExcel->setActiveSheetIndex(2)
            ->setTitle('Edades')
            ->setCellValue('A1', 'Concepto')
            ->setCellValue('B1', 'Cantidad');
$edades = $DG->datosEdad($arrayIds);
$j=1;
$i=0;
foreach($edades as $edad){
	if($edad->edad >=21){
		$j++;
		$i++;
		$objWorksheet3=$objPHPExcel->getActiveSheet()->SetCellValue('A'.$j, $edad->edad);
		$objWorksheet3=$objPHPExcel->getActiveSheet()->SetCellValue('B'.$j, $edad->total);
	}
}

$k=3;

$dataSeriesLabels = array(
	new PHPExcel_Chart_DataSeriesValues('String', 'Edades!$B$1', NULL, 1),	//	2011
);
$xAxisTickValues2 = array(
	new PHPExcel_Chart_DataSeriesValues('String', 'Edades!$A$2:$A$'.$j, NULL, $i),	//	Q1 to Q4
);
$dataSeriesValues2 = array(
	new PHPExcel_Chart_DataSeriesValues('Number', 'Edades!$B$2:$B$'.$j, NULL, $i),
);
$series2 = new PHPExcel_Chart_DataSeries(
	PHPExcel_Chart_DataSeries::TYPE_PIECHART,				// plotType
	NULL,			                                        // plotGrouping (Pie charts don't have any grouping)
	range(0, count($dataSeriesValues2)-1),					// plotOrder
	$dataSeriesLabels2,										// plotLabel
	$xAxisTickValues2,										// plotCategory
	$dataSeriesValues2										// plotValues
);

$layout2 = new PHPExcel_Chart_Layout();
$layout2->setShowVal(false);
$layout2->setShowPercent(TRUE);

$plotArea2 = new PHPExcel_Chart_PlotArea($layout2, array($series2));

$legend2 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);

$title2 = new PHPExcel_Chart_Title('Edades');

$chart2 = new PHPExcel_Chart(
	'chart1',
	$title2,		
	$legend2,		
	$plotArea2,		
	true,			
	0,				
	NULL,			
	NULL			
);

$chart2->setTopLeftPosition('A'.$j+1);
$chart2->setBottomRightPosition('E'.$j+10);

//	Add the chart to the worksheet
$objWorksheet3->addChart($chart2);


$objPHPExcel->getSheetCount();//cuenta las pestañas
$objPHPExcel->createSheet(3);
$objWorksheet3 = $objPHPExcel->setActiveSheetIndex(3)
            ->setTitle('Paises')
            ->setCellValue('A1', 'Concepto')
            ->setCellValue('B1', 'Cantidad');
$paises = $DG->datosPaises($arrayIds);
$j=1;
$i=0;
foreach($paises as $pais){
    $j++;
    $i++;
    $objWorksheet3=$objPHPExcel->getActiveSheet()->SetCellValue('A'.$j, $pais->pais);
    $objWorksheet3=$objPHPExcel->getActiveSheet()->SetCellValue('B'.$j, $pais->total);
}

$k=3;

$dataSeriesLabels = array(
	new PHPExcel_Chart_DataSeriesValues('String', 'Paises!$B$1', NULL, 1),	//	2011
);
$xAxisTickValues2 = array(
	new PHPExcel_Chart_DataSeriesValues('String', 'Paises!$A$2:$A$'.$j, NULL, $i),	//	Q1 to Q4
);
$dataSeriesValues2 = array(
	new PHPExcel_Chart_DataSeriesValues('Number', 'Paises!$B$2:$B$'.$j, NULL, $i),
);
$series2 = new PHPExcel_Chart_DataSeries(
	PHPExcel_Chart_DataSeries::TYPE_PIECHART,				// plotType
	NULL,			                                        // plotGrouping (Pie charts don't have any grouping)
	range(0, count($dataSeriesValues2)-1),					// plotOrder
	$dataSeriesLabels2,										// plotLabel
	$xAxisTickValues2,										// plotCategory
	$dataSeriesValues2										// plotValues
);

$layout2 = new PHPExcel_Chart_Layout();
$layout2->setShowVal(false);
$layout2->setShowPercent(TRUE);

$plotArea2 = new PHPExcel_Chart_PlotArea($layout2, array($series2));

$legend2 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);

$title2 = new PHPExcel_Chart_Title('Paises');

$chart2 = new PHPExcel_Chart(
	'chart1',
	$title2,		
	$legend2,		
	$plotArea2,		
	true,			
	0,				
	NULL,			
	NULL			
);

$chart2->setTopLeftPosition('A'.$j+1);
$chart2->setBottomRightPosition('E'.$j+10);

//	Add the chart to the worksheet
$objWorksheet3->addChart($chart2);


$objPHPExcel->getSheetCount();//cuenta las pestañas
$objPHPExcel->createSheet(4);
$objWorksheet3 = $objPHPExcel->setActiveSheetIndex(4)
            ->setTitle('Estados')
            ->setCellValue('A1', 'Concepto')
            ->setCellValue('B1', 'Cantidad');
$estados = $DG->datosEstado($arrayIds);
$j=1;
$i=0;
foreach($estados as $estado){
    $j++;
    $i++;
    $objWorksheet3=$objPHPExcel->getActiveSheet()->SetCellValue('A'.$j, $estado->estado);
    $objWorksheet3=$objPHPExcel->getActiveSheet()->SetCellValue('B'.$j, $estado->total);
}

$k=3;

$dataSeriesLabels = array(
	new PHPExcel_Chart_DataSeriesValues('String', 'Estados!$B$1', NULL, 1),	//	2011
);
$xAxisTickValues2 = array(
	new PHPExcel_Chart_DataSeriesValues('String', 'Estados!$A$2:$A$'.$j, NULL, $i),	//	Q1 to Q4
);
$dataSeriesValues2 = array(
	new PHPExcel_Chart_DataSeriesValues('Number', 'Estados!$B$2:$B$'.$j, NULL, $i),
);
$series2 = new PHPExcel_Chart_DataSeries(
	PHPExcel_Chart_DataSeries::TYPE_PIECHART,				// plotType
	NULL,			                                        // plotGrouping (Pie charts don't have any grouping)
	range(0, count($dataSeriesValues2)-1),					// plotOrder
	$dataSeriesLabels2,										// plotLabel
	$xAxisTickValues2,										// plotCategory
	$dataSeriesValues2										// plotValues
);

$layout2 = new PHPExcel_Chart_Layout();
$layout2->setShowVal(false);
$layout2->setShowPercent(TRUE);

$plotArea2 = new PHPExcel_Chart_PlotArea($layout2, array($series2));

$legend2 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);

$title2 = new PHPExcel_Chart_Title('Estados');

$chart2 = new PHPExcel_Chart(
	'chart1',
	$title2,		
	$legend2,		
	$plotArea2,		
	true,			
	0,				
	NULL,			
	NULL			
);

$chart2->setTopLeftPosition('A'.$j+1);
$chart2->setBottomRightPosition('E'.$j+10);

//	Add the chart to the worksheet
$objWorksheet3->addChart($chart2);



$objPHPExcel->getSheetCount();//cuenta las pestañas
$objPHPExcel->createSheet(5);
$objWorksheet3 = $objPHPExcel->setActiveSheetIndex(5)
            ->setTitle('Nacionalidades')
            ->setCellValue('A1', 'Concepto')
            ->setCellValue('B1', 'Cantidad');
$nacinalidades = $DG->datosNacionalidad($arrayIds);
$j=1;
$i=0;
foreach($nacinalidades as $nacionalidad){
    $j++;
    $i++;
    $objWorksheet3=$objPHPExcel->getActiveSheet()->SetCellValue('A'.$j, $nacionalidad->nacionalidad);
    $objWorksheet3=$objPHPExcel->getActiveSheet()->SetCellValue('B'.$j, $nacionalidad->total);
}

$k=3;

$dataSeriesLabels = array(
	new PHPExcel_Chart_DataSeriesValues('String', 'Nacionalidades!$B$1', NULL, 1),	//	2011
);
$xAxisTickValues2 = array(
	new PHPExcel_Chart_DataSeriesValues('String', 'Nacionalidades!$A$2:$A$'.$j, NULL, $i),	//	Q1 to Q4
);
$dataSeriesValues2 = array(
	new PHPExcel_Chart_DataSeriesValues('Number', 'Nacionalidades!$B$2:$B$'.$j, NULL, $i),
);
$series2 = new PHPExcel_Chart_DataSeries(
	PHPExcel_Chart_DataSeries::TYPE_PIECHART,				// plotType
	NULL,			                                        // plotGrouping (Pie charts don't have any grouping)
	range(0, count($dataSeriesValues2)-1),					// plotOrder
	$dataSeriesLabels2,										// plotLabel
	$xAxisTickValues2,										// plotCategory
	$dataSeriesValues2										// plotValues
);

$layout2 = new PHPExcel_Chart_Layout();
$layout2->setShowVal(false);
$layout2->setShowPercent(TRUE);

$plotArea2 = new PHPExcel_Chart_PlotArea($layout2, array($series2));

$legend2 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);

$title2 = new PHPExcel_Chart_Title('Nacionalidades');

$chart2 = new PHPExcel_Chart(
	'chart1',
	$title2,		
	$legend2,		
	$plotArea2,		
	true,			
	0,				
	NULL,			
	NULL			
);

$chart2->setTopLeftPosition('A'.$j+1);
$chart2->setBottomRightPosition('E'.$j+10);

//	Add the chart to the worksheet
$objWorksheet3->addChart($chart2);




$objPHPExcel->getSheetCount();//cuenta las pestañas
$objPHPExcel->createSheet(6);
$objWorksheet3 = $objPHPExcel->setActiveSheetIndex(6)
            ->setTitle('InstitucionesHos')
            ->setCellValue('A1', 'Concepto')
            ->setCellValue('B1', 'Cantidad');
$instituciones = $DG->datosInstituto($arrayIds);
$j=1;
$i=0;
foreach($instituciones as $institucion){
    $j++;
    $i++;
    $objWorksheet3=$objPHPExcel->getActiveSheet()->SetCellValue('A'.$j, $institucion->institucion_hospitalaria);
    $objWorksheet3=$objPHPExcel->getActiveSheet()->SetCellValue('B'.$j, $institucion->total);
}

$k=3;

$dataSeriesLabels = array(
	new PHPExcel_Chart_DataSeriesValues('String', 'InstitucionesHos!$B$1', NULL, 1),	//	2011
);
$xAxisTickValues2 = array(
	new PHPExcel_Chart_DataSeriesValues('String', 'InstitucionesHos!$A$2:$A$'.$j, NULL, $i),	//	Q1 to Q4
);
$dataSeriesValues2 = array(
	new PHPExcel_Chart_DataSeriesValues('Number', 'InstitucionesHos!$B$2:$B$'.$j, NULL, $i),
);
$series2 = new PHPExcel_Chart_DataSeries(
	PHPExcel_Chart_DataSeries::TYPE_PIECHART,				// plotType
	NULL,			                                        // plotGrouping (Pie charts don't have any grouping)
	range(0, count($dataSeriesValues2)-1),					// plotOrder
	$dataSeriesLabels2,										// plotLabel
	$xAxisTickValues2,										// plotCategory
	$dataSeriesValues2										// plotValues
);

$layout2 = new PHPExcel_Chart_Layout();
$layout2->setShowVal(false);
$layout2->setShowPercent(TRUE);

$plotArea2 = new PHPExcel_Chart_PlotArea($layout2, array($series2));

$legend2 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);

$title2 = new PHPExcel_Chart_Title('Instituciones Hospitalarias');

$chart2 = new PHPExcel_Chart(
	'chart1',
	$title2,		
	$legend2,		
	$plotArea2,		
	true,			
	0,				
	NULL,			
	NULL			
);

$chart2->setTopLeftPosition('A'.$j+1);
$chart2->setBottomRightPosition('E'.$j+10);

//	Add the chart to the worksheet
$objWorksheet3->addChart($chart2);



$objPHPExcel->getSheetCount();//cuenta las pestañas
$objPHPExcel->createSheet(7);
$objWorksheet3 = $objPHPExcel->setActiveSheetIndex(7)
            ->setTitle('InstitucionesAca')
            ->setCellValue('A1', 'Concepto')
            ->setCellValue('B1', 'Cantidad');
$institucionesA = $DG->datosInstitutoA($arrayIds);
$j=1;
$i=0;
foreach($institucionesA as $institucionA){
    $j++;
    $i++;
    $objWorksheet3=$objPHPExcel->getActiveSheet()->SetCellValue('A'.$j, $institucionA->institucion_academica);
    $objWorksheet3=$objPHPExcel->getActiveSheet()->SetCellValue('B'.$j, $institucionA->total);
}

$k=3;

$dataSeriesLabels = array(
	new PHPExcel_Chart_DataSeriesValues('String', 'InstitucionesAca!$B$1', NULL, 1),	//	2011
);
$xAxisTickValues2 = array(
	new PHPExcel_Chart_DataSeriesValues('String', 'InstitucionesAca!$A$2:$A$'.$j, NULL, $i),	//	Q1 to Q4
);
$dataSeriesValues2 = array(
	new PHPExcel_Chart_DataSeriesValues('Number', 'InstitucionesAca!$B$2:$B$'.$j, NULL, $i),
);
$series2 = new PHPExcel_Chart_DataSeries(
	PHPExcel_Chart_DataSeries::TYPE_PIECHART,				// plotType
	NULL,			                                        // plotGrouping (Pie charts don't have any grouping)
	range(0, count($dataSeriesValues2)-1),					// plotOrder
	$dataSeriesLabels2,										// plotLabel
	$xAxisTickValues2,										// plotCategory
	$dataSeriesValues2										// plotValues
);

$layout2 = new PHPExcel_Chart_Layout();
$layout2->setShowVal(false);
$layout2->setShowPercent(TRUE);

$plotArea2 = new PHPExcel_Chart_PlotArea($layout2, array($series2));

$legend2 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);

$title2 = new PHPExcel_Chart_Title('Instituciones Academicas');

$chart2 = new PHPExcel_Chart(
	'chart1',
	$title2,		
	$legend2,		
	$plotArea2,		
	true,			
	0,				
	NULL,			
	NULL			
);

$chart2->setTopLeftPosition('A'.$j+1);
$chart2->setBottomRightPosition('E'.$j+10);

//	Add the chart to the worksheet
$objWorksheet3->addChart($chart2);



$objPHPExcel->getSheetCount();//cuenta las pestañas
$objPHPExcel->createSheet(8);
$objWorksheet3 = $objPHPExcel->setActiveSheetIndex(8)
            ->setTitle('TESIS')
            ->setCellValue('A1', 'Concepto')
            ->setCellValue('B1', 'Cantidad');
$tesiss = $DG->datosEstatusTesis($arrayIds);
$j=1;
$i=0;
foreach($tesiss as $tesis){
    $j++;
    $i++;
    $objWorksheet3=$objPHPExcel->getActiveSheet()->SetCellValue('A'.$j, $tesis->estatus_tesis);
    $objWorksheet3=$objPHPExcel->getActiveSheet()->SetCellValue('B'.$j, $tesis->total);
}

$k=3;

$dataSeriesLabels = array(
	new PHPExcel_Chart_DataSeriesValues('String', 'TESIS!$B$1', NULL, 1),	//	2011
);
$xAxisTickValues2 = array(
	new PHPExcel_Chart_DataSeriesValues('String', 'TESIS!$A$2:$A$'.$j, NULL, $i),	//	Q1 to Q4
);
$dataSeriesValues2 = array(
	new PHPExcel_Chart_DataSeriesValues('Number', 'TESIS!$B$2:$B$'.$j, NULL, $i),
);
$series2 = new PHPExcel_Chart_DataSeries(
	PHPExcel_Chart_DataSeries::TYPE_PIECHART,				// plotType
	NULL,			                                        // plotGrouping (Pie charts don't have any grouping)
	range(0, count($dataSeriesValues2)-1),					// plotOrder
	$dataSeriesLabels2,										// plotLabel
	$xAxisTickValues2,										// plotCategory
	$dataSeriesValues2										// plotValues
);

$layout2 = new PHPExcel_Chart_Layout();
$layout2->setShowVal(false);
$layout2->setShowPercent(TRUE);

$plotArea2 = new PHPExcel_Chart_PlotArea($layout2, array($series2));

$legend2 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);

$title2 = new PHPExcel_Chart_Title('Estatus Tesis');

$chart2 = new PHPExcel_Chart(
	'chart1',
	$title2,		
	$legend2,		
	$plotArea2,		
	true,			
	0,				
	NULL,			
	NULL			
);

$chart2->setTopLeftPosition('A'.$j+1);
$chart2->setBottomRightPosition('E'.$j+10);

//	Add the chart to the worksheet
$objWorksheet3->addChart($chart2);



$objPHPExcel->getSheetCount();//cuenta las pestañas
$objPHPExcel->createSheet(9);
$objWorksheet3 = $objPHPExcel->setActiveSheetIndex(9)
            ->setTitle('EstatusTitulacion')
            ->setCellValue('A1', 'Concepto')
            ->setCellValue('B1', 'Cantidad');
$unis = $DG->datosEstatusUni($arrayIds);
$j=1;
$i=0;
foreach($unis as $uni){
    $j++;
    $i++;
    $objWorksheet3=$objPHPExcel->getActiveSheet()->SetCellValue('A'.$j, $uni->estatus_titulo_uni);
    $objWorksheet3=$objPHPExcel->getActiveSheet()->SetCellValue('B'.$j, $uni->total);
}

$k=3;

$dataSeriesLabels = array(
	new PHPExcel_Chart_DataSeriesValues('String', 'EstatusTitulacion!$B$1', NULL, 1),	//	2011
);
$xAxisTickValues2 = array(
	new PHPExcel_Chart_DataSeriesValues('String', 'EstatusTitulacion!$A$2:$A$'.$j, NULL, $i),	//	Q1 to Q4
);
$dataSeriesValues2 = array(
	new PHPExcel_Chart_DataSeriesValues('Number', 'EstatusTitulacion!$B$2:$B$'.$j, NULL, $i),
);
$series2 = new PHPExcel_Chart_DataSeries(
	PHPExcel_Chart_DataSeries::TYPE_PIECHART,				// plotType
	NULL,			                                        // plotGrouping (Pie charts don't have any grouping)
	range(0, count($dataSeriesValues2)-1),					// plotOrder
	$dataSeriesLabels2,										// plotLabel
	$xAxisTickValues2,										// plotCategory
	$dataSeriesValues2										// plotValues
);

$layout2 = new PHPExcel_Chart_Layout();
$layout2->setShowVal(false);
$layout2->setShowPercent(TRUE);

$plotArea2 = new PHPExcel_Chart_PlotArea($layout2, array($series2));

$legend2 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);

$title2 = new PHPExcel_Chart_Title('Estatus Titulación');

$chart2 = new PHPExcel_Chart(
	'chart1',
	$title2,		
	$legend2,		
	$plotArea2,		
	true,			
	0,				
	NULL,			
	NULL			
);

$chart2->setTopLeftPosition('A'.$j+1);
$chart2->setBottomRightPosition('E'.$j+10);

//	Add the chart to the worksheet
$objWorksheet3->addChart($chart2);



$objPHPExcel->getSheetCount();//cuenta las pestañas
$objPHPExcel->createSheet(10);
$objWorksheet3 = $objPHPExcel->setActiveSheetIndex(10)
            ->setTitle('Especialidad')
            ->setCellValue('A1', 'Concepto')
            ->setCellValue('B1', 'Cantidad');
$especialidades = $DG->datosEspecialidad($arrayIds);
$j=1;
$i=0;
foreach($especialidades as $especialidad){
    $j++;
    $i++;
    $objWorksheet3=$objPHPExcel->getActiveSheet()->SetCellValue('A'.$j, $especialidad->especialidad);
    $objWorksheet3=$objPHPExcel->getActiveSheet()->SetCellValue('B'.$j, $especialidad->total);
}

$k=3;

$dataSeriesLabels = array(
	new PHPExcel_Chart_DataSeriesValues('String', 'Especialidad!$B$1', NULL, 1),	//	2011
);
$xAxisTickValues2 = array(
	new PHPExcel_Chart_DataSeriesValues('String', 'Especialidad!$A$2:$A$'.$j, NULL, $i),	//	Q1 to Q4
);
$dataSeriesValues2 = array(
	new PHPExcel_Chart_DataSeriesValues('Number', 'Especialidad!$B$2:$B$'.$j, NULL, $i),
);
$series2 = new PHPExcel_Chart_DataSeries(
	PHPExcel_Chart_DataSeries::TYPE_PIECHART,				// plotType
	NULL,			                                        // plotGrouping (Pie charts don't have any grouping)
	range(0, count($dataSeriesValues2)-1),					// plotOrder
	$dataSeriesLabels2,										// plotLabel
	$xAxisTickValues2,										// plotCategory
	$dataSeriesValues2										// plotValues
);

$layout2 = new PHPExcel_Chart_Layout();
$layout2->setShowVal(false);
$layout2->setShowPercent(TRUE);

$plotArea2 = new PHPExcel_Chart_PlotArea($layout2, array($series2));

$legend2 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);

$title2 = new PHPExcel_Chart_Title('Especialidad');

$chart2 = new PHPExcel_Chart(
	'chart1',
	$title2,		
	$legend2,		
	$plotArea2,		
	true,			
	0,				
	NULL,			
	NULL			
);

$chart2->setTopLeftPosition('A'.$j+1);
$chart2->setBottomRightPosition('E'.$j+10);

//	Add the chart to the worksheet
$objWorksheet3->addChart($chart2);

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="graficacion.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->setIncludeCharts(TRUE);
$objWriter->save('php://output');

