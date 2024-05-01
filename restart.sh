#!/bin/sh

cd /home/openarena/openarena
./openarena-conf-generator.php
./openarena-conf-generator-ctf.php
./start-server.sh

