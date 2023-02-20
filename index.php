<?php
/**
 * User: Alex Under
 * Date: 02/04/2019
 * Time: 12:26 PM
 */

require_once 'lib/config/tcpdf_config.php';
require __DIR__ . '/vendor/autoload.php';


use Solo\DataProvider;
use Solo\SoloReport;


$dataProvider = new DataProvider();
$data = $dataProvider->get();

//$report_name = __DIR__ . '/solo_report.pdf';
$report_name =  'solo_report.pdf';
$output_mode = 'I'; // I - inline, D - download, F - save local file
$report_destination = 'online';// online/print
$report = new SoloReport($report_name, $output_mode, $data, $report_destination);