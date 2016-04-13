<?php
	/* TEST WHETHER A SITE IS RESPONDING */
	
	$i = 1;
	while ($i <= 5) {
		echo $i++;
	
		sleep(1);
	
		$f1 = 'http://www.google.fi';
		$file_headers = @get_headers($f1);
		$paivays = date('Y-m-d H:i:s'); 
	
		if($file_headers[0] == 'HTTP/1.0 200 OK') {
	  	echo $paivays. " google.fi OK";
			}
			else {
				echo $paivays. " google.fi does not exist<br>";
				/*
			  $fp = fopen('log.txt', 'a');
				fwrite($fp, $paivays. ' google.fi does not exist');
				fclose($fp);
			  */ 
	   }
	}

?>
