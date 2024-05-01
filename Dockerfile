FROM alpine:3.19.1

RUN apk add sudo
RUN apk add libc6-compat
RUN apk add tcpdump
RUN apk add net-tools
RUN apk add bash
RUN apk add nginx
RUN apk add php
RUN apk add curl
RUN apk add vim
RUN apk add nano
RUN apk add wget

WORKDIR /
RUN addgroup -S openarena && adduser -S openarena -G openarena -s /bin/bash
USER openarena
RUN mkdir -p /home/openarena/openarena
RUN mkdir -p /home/openarena/.openarena/baseoa

COPY --chown=openarena:openarena . /home/openarena/openarena
WORKDIR /home/openarena/.openarena/baseoa
RUN ln -s ../../openarena/baseoa/maps_ctf.cfg maps_ctf.cfg
RUN ln -s ../../openarena/baseoa/maps_dm.cfg maps_dm.cfg
RUN ln -s ../../openarena/server.cfg server.cfg
RUN ln -s ../../openarena/serverdm.cfg serverdm.cfg

WORKDIR /home/openarena/

USER root
COPY index.html /var/www/localhost

# Last standing server port
EXPOSE 27960/udp

# Capture the flagg
EXPOSE 27961/udp

# nginx
EXPOSE 80/tcp

ENTRYPOINT ["/home/openarena/openarena/start-server.sh"]
CMD ["/home/openarena/openarena/server.sh"]
#CMD ["nginx", "-g", "daemon off;"]