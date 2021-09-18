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
	$x = $rows['id2'];
	$y = $rows['Temperature'];
	$z = $rows['Humidity'];
	$data[] = array('',$x,$y,$z);
  }
$close_flag = pg_close($link);
/////////////////////////////////////////////////////////////////

$plot = new PHPlot(800, 600);
$plot->SetImageBorderType('plain');

$plot->SetPlotType('linepoints');
$plot->SetPointSize(10);
$plot->SetDataType('data-data');
$plot->SetDataValues($data);

$legend = ['Temperature','Humidity'];
$plot->SetLegend($legend);

$linewidth = [5,5];
$plot->SetLineWidths($linewidth);
//$plot->SetLineColor('red');

$plot->SetFont('y_label',1,100);

# Main plot title:
$plot->SetTitle('Temperature in this room');

# Make sure Y axis starts at 0:
$plot->SetPlotAreaWorld(130000, 0, NULL, NULL);

$plot->DrawGraph();
