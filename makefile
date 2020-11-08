UID := $(shell id -u)
GID := $(shell id -g)

start:
	export _UID="${UID}" \
        && export _GID="${GID}" \
        && time docker-compose run --rm --no-deps --user="${UID}:${GID}" composer \
        && docker-compose up -d --build --remove-orphans nginx

stop:
	export _UID="${UID}" \
            && export _GID="${GID}" \
            && time docker-compose stopls -l

down:
	export _UID="${UID}" \
        && export _GID="${GID}" \
		&& time docker-compose down

psalm:
	./vendor/bin/psalm
