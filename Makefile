.PHONY: help build up start down destroy stop restart logs logs-api ps login-timescale login-api db-shell

env:
	mv /src/.env.example /src/.env
build:
	docker compose build
up:
	chmod 644 ./docker/volume/init.sql
	docker compose up -d
down:
	docker compose down
logs:
	docker compose  logs --tail=100 -f $(c)
ps:
	docker ps -a