#!/usr/bin/make

NAME = "openarena"
VERSION="v0.8.8"

all: dev hub prod

info:
	@echo "${NAME} version: ${VERSION}"

clean:
	@echo "Cleaning up distutils stuff"

# Local Docker build / push
build:
	DOCKER_BUILDKIT=1
	docker build --no-cache . --platform linux/amd64 -t ${NAME}/${NAME}:${VERSION}

push: build
	docker tag ${NAME}/${NAME}:${VERSION} ${GLOBOARTIFACTORY}/${NAME}/${NAME}:${VERSION}
	docker push ${GLOBOARTIFACTORY}/${NAME}/${NAME}:${VERSION}