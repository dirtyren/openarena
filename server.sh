#!/bin/bash

# log rotate and level shuffle
echo "0     5       *       *       *       /home/openarena/openarena/restart.sh" >> /etc/crontabs/root

crond
nginx -g "daemon off;"
