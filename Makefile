SHELL := /bin/bash

EXEC_PHP :=

##
## Проект
## ------

vendor: composer.json composer.lock ## Собрать vendor
	$(EXEC_PHP) composer install
	$(EXEC_PHP) touch vendor

##
## Контроль качества кода
## ----------------------

rector-fix: vendor ## Запустить исправление PHP кода при помощи Rector (https://getrector.org)
	$(EXEC_PHP)  vendor-bin/rector/vendor/bin/rector process
.PHONY: rector-fix

##
## Контроль зависимостей
## ----------------------

# -----------------------

help:
	@awk ' \
		BEGIN {RS=""; FS="\n"} \
		function printCommand(line) { \
			split(line, command, ":.*?## "); \
        	printf "\033[32m%-28s\033[0m %s\n", command[1], command[2]; \
        } \
		/^[0-9a-zA-Z_-]+: [0-9a-zA-Z_-]+\n[0-9a-zA-Z_-]+: .*?##.*$$/ { \
			split($$1, alias, ": "); \
			sub(alias[2] ":", alias[2] " (" alias[1] "):", $$2); \
			printCommand($$2); \
			next; \
		} \
		$$1 ~ /^[0-9a-zA-Z_-]+: .*?##/ { \
			printCommand($$1); \
			next; \
		} \
		/^##(\n##.*)+$$/ { \
			gsub("## ?", "\033[33m", $$0); \
			print $$0; \
			next; \
		} \
	' $(MAKEFILE_LIST) && printf "\033[0m"
.PHONY: help
.DEFAULT_GOAL := help
