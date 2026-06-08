<?php

require_once("phpjasperxml-master/vendor/autoload.php");

use simitsdk\phpjasperxml\PHPJasperXML;

$filename = "reportes/Prueba.jrxml";

$config = [
    'driver' => 'mysql',
    'host'   => 'localhost',
    'user'   => 'root',
    'pass'   => '',
    'name'   => 'cuartob'
];

$report = new PHPJasperXML();

$report->load_xml_file($filename)
       ->setDataSource($config)
       
       ->SetTitle("Reporte Jasper")
       ->export('Pdf');
        
?>