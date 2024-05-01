#!/usr/bin/php
<?php
$hostname = trim($argv[1]);

$cmd = "/usr/local/bin/qstat -json -P  -q3s ".$hostname;

$logPlayersOnlineTotal = "/var/local/src/openareana_count.lock";

$output = array();
$ret = 0;
$run = exec ($cmd, $output, $ret);

$json = implode("", $output);
if ($json == NULL || empty($json)) {
	print "No return from ".$hostname."\n";
	exit(3);
}
$data = json_decode($json);
$q3s = $data[0];
if ($q3s->status != "online") {
	$msg = $q3s->name." is ".$q3s->status;
	exit(2);
}

$message = "\n".$q3s->name." online - Server address ".$q3s->address."\n";
$message .= "   Map ".$q3s->map;

$connected_players = "";
$onlinePlayers = 0;
foreach ($q3s->players as $player) {
	$connected_players .= "\t".$player->name."\n";
	$onlinePlayers++;
}
$oldLogged = file_get_contents($logPlayersOnlineTotal);
if ($oldLogged === false) {
	$oldLogged = 0;
}

if ( $onlinePlayers > 0 ) {
	$message.="   Connected players $onlinePlayers\n";
	$message.= $connected_players;
}
else {
	$message.= "  No players connected\n";
}
file_put_contents($logPlayersOnlineTotal, $onlinePlayers);
if ((int)$oldLogged != $onlinePlayers) {
	print $message;
	sendDiscord($message);
}
exit(0);

$msg = $q3s->name." is ".$q3s->status.". Running map ".$q3s->map.". Players ".$q3s->numplayers;
$perfdata = "players=".$q3s->numplayers.";;;0;".$q3s->maxplayers;
$perfdata .=" ping=".$q3s->ping."ms";

print "$msg | $perfdata\n";

function  sendDiscord($message) {
    $data = ['content' => $message];
    $options = [
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/json',
            'content' => json_encode($data)
        ]
    ];

    $context = stream_context_create($options);
    $result = file_get_contents('https://discordapp.com/api/webhooks/XYZ', false, $context);
}

