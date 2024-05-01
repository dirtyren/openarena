#!/usr/bin/php
<?php

	$configFile = "/home/openarena/openarena/server.cfg-tmpl";
	$realFile = "/home/openarena/openarena/server.cfg";
	$conf = file_get_contents($configFile);
	$confArray = explode("\n", $conf);

	$levels = array();
	$levels[]="speedyctf";
	$levels[]="oasago2";
	$levels[]="bubctf1";
	$levels[]="letgo_02";
	$levels[]="pul1ctf";
	$levels[]="ps37ctf3";
	$levels[]="letgo_01";
	$levels[]="ctf_gate1";
	$levels[]="am_thornish";

	shuffle($levels);

	$levelIndex = 0;
	$changeInConf = array();
	$totalLevels = count($levels);
	foreach ($levels as $level) {
		$levelIndex++;
		//		set d1 "map speedyctf; set nextmap vstr d2"
		$nextLevel = $levelIndex + 1;
		if ($totalLevels+1 == $nextLevel) {
			$nextLevel=1;
		}
		$tmpLine = 'set d'.$levelIndex.' "map '.$level.'; set nextmap vstr d'.$nextLevel.'"';
		$changeInConf[] = $tmpLine;
	}
	$changeInConf[] = 'wait';
	$changeInConf[] = 'vstr d1// start loop at d1';
	$changeInConf[] = '//';

	// generate new conf
	$newConf = array();
	foreach ($confArray as $line) {
		if (strstr($line, 'set c1 ')) {
			break;
		}
		$newConf[] = $line;
	}

	$finalConf = array_merge($newConf, $changeInConf);

	$newFile = implode("\n",$finalConf);

	file_put_contents($realFile, $newFile);
	sleep(2);
?>
