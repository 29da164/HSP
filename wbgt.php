<?php
# $Id: lines1.php 1001 2011-08-08 02:22:55Z lbayuk $
# PHPlot Example: Simple line graph
require_once './PHPlot/phplot/phplot.php';

$conn = "host=localhost dbname=hsp_db user=postgres";
$link = pg_connect($conn);

  if (!$link) {
    die('fail'.pg_last_error());
  }

  //print('Connected. <br>');

/////////////////////////////////////////////////////////////////

  $result = pg_query('SELECT * FROM hangai where id2 > 130000 order by id2 desc');
  for($i=0;$i<pg_num_rows($result);$i++){
	$rows = pg_fetch_array($result,NULL,PGSQL_ASSOC);
	//$x = $rows['day'].$rows['hour'].$rows['min'];
	$x = $rows['id2'];
	$y = $rows['Temperature'];
	$z = $rows['Humidity'];
	$wbgt = ($z -20)*(($y -40)*($y - 40)*(-0.00025) + 0.185) + 11/15*($y -25) +17.8;
	$data[] = array('',$x,$wbgt);
  }
$close_flag = pg_close($link);
/////////////////////////////////////////////////////////////////

$plot = new PHPlot(800, 600);
$plot->SetImageBorderType('plain');

$plot->SetPlotType('linepoints');
$plot->SetPointSize(10);
$plot->SetDataType('data-data');
$plot->SetDataValues($data);
$plot->SetPlotAreaWorld(NULL,15,NULL,45);

$legend = ['WBGT value'];
$plot->SetLegend($legend);

$linewidth = [5];
$plot->SetLineWidths($linewidth);
$plot->SetDataColors('purple');

$plot->SetBgImage('./wbgt.png','scale');
$plot->SetTitle('WBGT value');
$plot->SetPlotAreaWorld(130000, 15, NULL, 40);

$plot->DrawGraph();
