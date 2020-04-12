.DEFAULT_GOAL := all
.PHONY: all docker_build vendors_install server_start

dockerfolder := .docker
dockerc := docker-compose -f $(dockerfolder)/docker-compose.yml

all: docker_build vendors_install server_start

docker_build:
	@$(dockerc) build

vendors_install:
	@$(dockerc) run --rm php composer install --no-interaction

server_start:
	@$(dockerc) run php bin/console server run

cli:
	@$(dockerc) run --rm php fish