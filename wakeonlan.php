<html>
    <head>
    <link href="styles/style.css" rel="stylesheet">
    </head>
    <body>
        <p> fukuda <br> </p>
        <?php
		$output=null;
		$retval=null;
		exec('wakeonlan 4c:36:4e:b0:c4:e7', $output, $retval);
		echo "Returned with status $retval and output:\n";
		print_r($output);
		?>
    </body>
</html>

