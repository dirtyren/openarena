#!/bin/bash

BASE_DIR="/home/openarena/openarena"
LOG="game.log"
LOGDM="gamedm.log"

ps -e -o pid,user,comm | grep "openaren" | tr -s " " | cut -f2 -d" " | xargs kill -9

cd $BASE_DIR
/bin/rm -f game.log
/bin/cp -f gamedm.log gameanalytics.log
/bin/chmod 666 gameanalytics.log
/bin/rm -f gamedm.log
/bin/rm -f /home/openarena/.openarena/baseoa/game.log
/bin/rm -f /home/openarena/.openarena/baseoa/gamedm.log
/bin/rm -f /home/openarena/.openarena/baseoa/qconsole.log
#./oa_ded.i386 +set dedicated 2 +exec server.cfg  >>$LOG 2>>$LOG &
#su openarena -c "./oa_ded.i386 +exec server.cfg +set net_ip 192.168.10.1  >>$LOG 2>>$LOG &"
#su openarena -c "./oa_ded.i386 +exec server.cfg  >>$LOG 2>>$LOG &"
su openarena -c "./oa_ded.x86_64 +set dedicated 2 +set net_port 27960 +set g_gametype 3 +exec serverdm.cfg  >>$LOGDM 2>>$LOGDM &"
su openarena -c "./oa_ded.x86_64 +set dedicated 2 +set net_port 27961 +exec server.cfg  >>$LOG 2>>$LOG &"

# Switch to the main container `CMD`.
exec "$@"
