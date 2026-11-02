PHP ?= php
COMPOSER ?= composer

.PHONY: phpstan

phpstan:
	cd phpstan && $(COMPOSER) install --no-interaction --no-progress --prefer-dist --ignore-platform-req=ext-webrtc
	$(PHP) phpstan/vendor/bin/phpstan analyse -c phpstan/phpstan.neon.dist
