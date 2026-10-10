PHP ?= php
COMPOSER ?= composer

.PHONY: phpstan

phpstan:
	cd phpstan && $(COMPOSER) install --no-interaction --no-progress --prefer-dist
	$(PHP) phpstan/vendor/bin/phpstan analyse -c phpstan/phpstan.neon.dist
