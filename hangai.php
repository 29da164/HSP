<html>
  <body>
  <?php
    $conn="host=localhost dbname=hsp_db user=postgres";
    $link=pg_connect($conn);
    if(!$link){
    die('Connection fail'.pq_last_error());
    }
    print('Connected<br>');
    $id = 1;
    $y = date("y");
    $m = date("m");
    $d = date("d");
    $h = date("h");
    $i = date("i");
    $tempC =$_POST["temp"];
    $humid =$_POST["humi"]; 
    $sql = "insert into hangai values(".$id.",'".$y."','".$m."','".$d."','".$h."','".$i."',".$tempC.",".$humid.")";
    $result = pg_query($sql);
    print($sql);
    if($result){
    die('insert fail'.pg_last_error());
    }
    $close_flag = pg_close($link);
    if($close_flag){
    print('Closed<br>');
    }
  ?>
  </body>
</html>
