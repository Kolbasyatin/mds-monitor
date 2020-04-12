.DEFAULT_GOAL := all

dockerfolder := .docker
dockerc := docker-compose -f $(dockerfolder)/docker-compose.yml

all: docker_build vendors_install server_start

docker_build:
	@$(dockerc) build

vendors_install:
	@$(dockerc) run php composer install

server_start:
	@$(dockerc) run php bin/console server run