<html>
<head><title>HSP PostgreSQL with php Template</title></head>
<body>

<?php
$conn = "host=localhost dbname=hsp_db user=postgres";
$link = pg_connect($conn);

  if (!$link) {
    die('fail'.pg_last_error());
  }

  print('Connected. <br>');

  $result = pg_query('SELECT * FROM hangai order by id2 desc');
  for ($i=0;$i<pg_num_rows($result);$i++){
		$rows=pg_fetch_array($result,NULL,PGSQL_ASSOC);
		print($rows['year']);
		print($rows['month']);
		print($rows['day']);
		print($rows['hour']);
		print($rows['min']);
		print('Temperature: ');
		print($rows['Temperature']);
		print(', Humidity: ');
		print($rows['Humidity']);
		print('<br>');
		}
		
  
$close_flag = pg_close($link);

if ($close_flag){
    print('Closed. <br>');
}

?>
</body>
</html>
