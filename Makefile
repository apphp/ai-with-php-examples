
# Colors
GRAY := \033[1;30m
GREEN := \033[0;32m
YELLOW := \033[1;33m
RED := \033[33;31m
DARKCYAN := \033[33;36m
NC := \033[0m
remove_vendor := rm -Rf vendor/; rm composer.lock;
# get uname
UNAME := $(shell uname)
# On Win 'docker-compose' | Mac 'docker compose'
docker := $(if $(filter $(UNAME), Linux), docker-compose, docker compose)

## -------------------------------------------------
## COMMON
## -------------------------------------------------
hello: app-hello info
help: app-help
all-commands: app-help

check-you-sure:
	@echo -n "${RED}Are you sure? $(MSG)${NC} [Y/n] " && read ans && [ $${ans:-N} = Y ]
## Messages
message-docker-init:
	$(eval MSG=All Docker containers will be deleted!)
message-docker-rebuild:
	$(eval MSG=All Docker containers will be deleted!)
message-composer-install:
	$(eval MSG=The 'vendor/' directory and 'composer.lock' file will be removed!)

app-help: info-docker

app-hello:
	@echo ""
	@echo "${YELLOW}---------------------------------------------------${NC}"
	@echo "${YELLOW}Hello, Boss! I'm Lucy! What would you like to do?${NC}"
	@echo "${YELLOW}---------------------------------------------------${NC}"

info:
	@echo "${GREEN}info-docker${NC} \t\t - list of commands for Docker"
	@echo "${GREEN}info-general${NC} \t\t - list of general commands"
	@echo "${GREEN}info-composer${NC} \t\t - list of commands for Composer"
	@echo "${GREEN}info-tests${NC} \t\t - list of commands for tests"
	@echo "${GREEN}info-linters${NC} \t\t - list of commands for linters"


## -------------------------------------------------
## DOCKER
## -------------------------------------------------
info-docker:
	@echo ""
	@echo "${GRAY}# -------------------------------------------------"
	@echo "# DOCKER"
	@echo "# -------------------------------------------------${NC}"
	@echo "${GREEN} init${NC} \t\t\t - perform full initialization of docker"
	@echo "${GREEN} up${NC} \t\t\t - run docker containers"
	@echo "${GREEN} down${NC} \t\t\t - down docker containers"
	@echo "${GREEN} rebuild${NC} \t\t - rebuild docker containers"
	@echo "${GREEN} ps${NC} \t\t\t - show running docker containers"

init: docker-commands-init
up: docker-up docker-ps
down: docker-down
rebuild: docker-commands-rebuild
ps: docker-ps

docker-commands-init:
	make message-docker-init check-you-sure docker-down docker-pull docker-build-pull docker-up docker-ps composer-install
docker-ps:
	$(docker) ps
	@echo "${GREEN}Website: http://localhost:8088${NC}"
docker-up:
	$(docker) up -d
docker-down:
	$(docker) down -v --remove-orphans
docker-pull:
	$(docker) pull
docker-build-pull:
	$(docker) build --pull
docker-commands-rebuild:
	make message-docker-rebuild check-you-sure docker-down docker-rebuild
docker-rebuild:
	$(docker) up --build -d


## -------------------------------------------------
## GENERAL
## -------------------------------------------------
info-general:
	@echo "${GREEN} bash${NC} \t\t\t - start bash in container"

# Bash: example: make exe c="pwd && ls -al ."
bash:
	$(docker) exec app /bin/bash -c "bash"


## -------------------------------------------------
## COMPOSER
## -------------------------------------------------
info-composer:
	@echo ""
	@echo "${GRAY}# -------------------------------------------------"
	@echo "# COMPOSER"
	@echo "# -------------------------------------------------${NC}"
	@echo "${GREEN} composer-install${NC} \t - install the defined dependencies"
	@echo "${GREEN} composer-update${NC} \t - initially install the defined dependencies. Ex.: 'make composer-update args=-vvv'"
	@echo "${GREEN} composer-dump${NC} \t\t - re-generate the vendor/autoload.php file"
	@echo "${GREEN} composer-du${NC} \t\t - alias for composer-dump command"

composer-install: message-composer-install check-you-sure composer-install-command composer-dump
composer-install-command:
	$(docker) exec app /bin/bash -c "$(remove_vendor) composer install $(args)"

composer-update: composer-update-command composer-dump
composer-update-command:
	$(docker) exec app /bin/bash -c "composer update $(args)"

composer-du: composer-dump
composer-dump:
	$(docker) exec app /bin/bash -c "composer dump-autoload --quiet --optimize --classmap-authoritative $(args)"


## -------------------------------------------------
## TESTS
## -------------------------------------------------
info-tests:
	@echo ""
	@echo "${GRAY}# -------------------------------------------------"
	@echo "# TESTS"
	@echo "# -------------------------------------------------${NC}"
	@echo "${GREEN} tests${NC} \t\t\t - run all tests"
	@echo "${GREEN} tests-coverage{NC} \t\t\t - run all tests with coverage"
	@echo "${GREEN} test${NC} \t\t\t - run specific test"

tests: app-tests
tests-coverage: app-tests-coverage
test: app-test

app-tests:
	$(docker) exec app /bin/bash -c "composer tests"

app-tests-coverage:
	$(docker) exec app /bin/bash -c "composer tests:coverage"

app-test:
	$(docker) exec app /bin/bash -c "composer test $(name)"


## -------------------------------------------------
## LINTERS & FIXERS
## -------------------------------------------------
info-linters:
	@echo ""
	@echo "${GRAY}# -------------------------------------------------"
	@echo "# LINTERS"
	@echo "# -------------------------------------------------${NC}"
	@echo "${GREEN} phplint${NC} \t\t - run PHP linter"
	@echo "${GREEN} phplint-log${NC} \t\t - run PHP linter with log"
	@echo "${GREEN} phpcs-check${NC} \t\t - run PHP CS fixer in check mode"
	@echo "${GREEN} phpcs-check-diff${NC} \t - run PHP CS fixer in check mode with difference"
	@echo "${GREEN} phpcs-fix${NC} \t\t - run PHP CS fixer in fix mode"
	@echo "${GREEN} psalm${NC} \t\t\t - run Psalm static code analyzer"
	@echo "${GREEN} psalm-click${NC} \t\t\t - run Psalm-clickable static code analyzer"
	@echo "${GREEN} psalm-help${NC} \t\t - run Psalm help info static code analyzer"
	@echo "${GREEN} psalm-report${NC} \t\t - run Psalm help info static code analyzer with creating report"
	@echo "${GREEN} psalm-fix${NC} \t\t - run Psalm static code analyze in fix mode"
	@echo "${GREEN} check${NC} \t\t - run all linters and check"
	@echo "${GREEN} check-fix${NC} \t\t - run all checks in fix mode"

phplint: app-phplint
phplint-log: app-phplint-log
phpcs: app-phpcs-check
phpcs-diff: app-phpcs-check-diff
phpcs-fix: app-phpcs-fix
psalm: app-psalm
psalm-click: app-psalm-clickable
psalm-help: app-psalm-help
psalm-report: app-psalm-report
psalm-fix: app-psalm-fix
check: phplint psalm phpcs
check-fix: phpcs-fix psalm-fix phpcs-fix

app-phplint:
	@echo "Run PHPLint${NC}"
	$(docker) exec app /bin/bash -c "composer php-lint"
app-phplint-log:
	$(docker) exec app /bin/bash -c "composer php-lint-with-log"
app-phpcs-check:
	@echo "Run PHP CS Check${NC}"
	$(docker) exec app /bin/bash -c "composer php-cs-check"
app-phpcs-check-diff:
	$(docker) exec app /bin/bash -c "composer php-cs-check-diff"
app-phpcs-fix:
	$(docker) exec app /bin/bash -c "composer php-cs-fix"
app-psalm:
	@echo "Run Psalm${NC}"
	$(docker) exec app /bin/bash -c "composer php-psalm"
app-psalm-clickable:
	@echo "Run Psalm Clickable"
	$(docker) exec app /bin/bash -c "composer php-psalm-clickable"
app-psalm-help:
	$(docker) exec app /bin/bash -c "composer php-psalm-help"
app-psalm-report:
	$(docker) exec app /bin/bash -c "composer php-psalm-with-report"
app-psalm-fix:
	$(docker) exec app /bin/bash -c "composer php-psalm-fix"
