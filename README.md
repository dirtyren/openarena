# Openarena

Openarena docker image build

   This repository can also be used to play da game, as it contains de extra levels used by the server
and the clients for Windows, Linux and Mac X86.

This is the docker build for the Openarena Server.

To build it
* make build

To run locally Openarena Server just run
* docker run -p 27960:27960/udp -p 27961:27961/udp openarena/openarena:v0.8.8
** port 27960 is the Last Man Standing server
** port 27961 is the Capture the Flah

If you want to run is in backgroup and have it restart in case it stops use this
* docker run -d --restart unless-stopped -p 27960:27960/udp -p 27961:27961/udp openarena/openarena:v0.8.8

You can also download the built image from docker hub
* docker pull alessandroren/openarena

and run it
* docker run -d --restart unless-stopped -p 27960:27960/udp -p 27961:27961/udp alessandroren/openarena:v0.8.8


The container will everyday rotate the game logs, shuffle the levels and restart the server.

There is a nginx listening on port 80 for maybe future use, show the server status, player using it and gamer stats in general.