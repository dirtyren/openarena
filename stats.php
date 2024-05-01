#!/usr/bin/php
<?php
$logfile = "/home/openarena/openarena/gameanalytics.log";
$logfile = "/home/alessandro/openarena/gameanalytics.log";
$findme = "PlayerScore:";

$playerPoints = array();

$handle = @fopen($logfile, "r");
if ($handle) {
    while (($buffer = fgets($handle, 4096)) !== false) {
        $pos2 = stripos($buffer, $findme);
        if ($pos2 === false) {
        	continue;
        }
		$keywords = preg_split("/[ :]+/", $buffer);
		if (isset($playerPoints[$keywords[3]])) {
			$playerPoints[$keywords[3]]++;
		}
		else {
			$playerPoints[$keywords[3]] = 1;
		}

    }
    fclose($handle);
}
else {
	print "File not found, probably already processed\n";
	exit(0);
}

$msg = '';
$perfdata = '';
foreach ($playerPoints as $key => $value) {
	// print $key." ".$value."\n";
	if ($msg == '')
		$msg .= $key." ".$value;
	else
		$msg .= " / ".$key." ".$value;

	$perfdata.="'".$key."'"."=".$value." ";
}
if ($msg == '') {
	print "No games played since last logrotate\n";
}
else {
	print $msg." | ".$perfdata."\n";	
}

$objDateTime = new DateTime('NOW');
$dateString =  $objDateTime->format('Y-m-d-H:i:s');

$logfileBkp = "/home/openarena/openarena/oldlogs/gameanalytics.log-".$dateString;
copy($logfile, $logfileBkp);
unlink($logfile);
exit(0);
