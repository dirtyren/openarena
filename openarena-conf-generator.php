#!/usr/bin/php
<?php

	$configFile = "/home/openarena/openarena/serverdm.cfg-tmpl";
	$realFile = "/home/openarena/openarena/serverdm.cfg";
	$conf = file_get_contents($configFile);
	$confArray = explode("\n", $conf);

	$levels = array();
	$levels[]="speedyctf";
	$levels[]="aggressor";
	$levels[]="oasago2";
	$levels[]="pxlfan";
	$levels[]="bubctf1";
	$levels[]="oa_shine";
	#$levels[]="letgo_02";
	$levels[]="suspended";
	//$levels[]="pul1ctf";
	$levels[]="wrackdm17";
	$levels[]="ps37ctf3";
	$levels[]="czest1tourney";
	#$levels[]="letgo_01";
	$levels[]="oa_dm5";
	$levels[]="ctf_gate1";
	$levels[]="am_thornish";
	$levels[]="oa_rpg3dm2";
	$levels[]="am_thornish";
	$levels[]="ce1m7";
	//$levels[]="oa_koth2";
	//$levels[]="sleekgrinder";
	$levels[]="oa_shouse";
	//$levels[]="hctf1";
	$levels[]="dm6ish";
	$levels[]="oa_dm7";
	//$levels[]="oacmpdm1";
	$levels[]="oacmpdm2";
	$levels[]="oacmpdm3";
	$levels[]="oacmpdm4";
	$levels[]="oacmpdm5";
	//$levels[]="oacmpdm6";
	$levels[]="oacmpdm7";
	$levels[]="oacmpdm8";
	$levels[]="oacmpdm9";
	//$levels[]="oacmpdm10";
	//$levels[]="oacmpctf1";
	//$levels[]="oacmpctf2";
	//$levels[]="oacmpctf3";

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
		if (strstr($line, 'set d1 ')) {
			break;
		}
		$newConf[] = $line;
	}

	$finalConf = array_merge($newConf, $changeInConf);

	$newFile = implode("\n",$finalConf);

	file_put_contents($realFile, $newFile);
	sleep(2);

?>
