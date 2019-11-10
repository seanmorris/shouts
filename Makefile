.PHONY: build dependencies update-dependencies clean start start-fg stop restart push pull cluster-apply cluster-delete

DOCKER_EMAIL ?=sean@seanmorr.is
HOST         ?=localhost
REPO         ?=gcr.io/shout-api-258623
REPO_CREDS   ?=gcr-json-key
TAG          ?=latest
PROJECT      ?=letgo_shout
TARGET       ?=development
YML_FILE     ?=infra/compose/base.yml
YML_FILE     ?=infra/compose/${TARGET}.yml
COMPOSE      ?=export REPO=${REPO} TAG=${TAG} TARGET=${TARGET} \
	&& docker-compose -f ${YML_FILE} -p ${PROJECT}

build:
	${COMPOSE} build

dependencies:
	docker run --rm \
		-v `pwd`/app:/app \
		composer install --ignore-platform-reqs \
			--no-interaction \
			--prefer-source

update-dependencies:
	docker run --rm \
		-v `pwd`/app:/app \
		composer update --ignore-platform-reqs \
			--no-interaction \
			--prefer-source

clean:
	@ rm -rfv ./app/vendor/

start:
	${COMPOSE}  up -d

start-fg:
	${COMPOSE}  up

stop:
	${COMPOSE} down

restart:
	${COMPOSE} down \
	&& ${COMPOSE} up -d

restart-fg:
	${COMPOSE} down \
	&& ${COMPOSE} up

push:
	${COMPOSE} push

pull:
	${COMPOSE} pull

cluster-credetials:
	cat ./.gcr_secret.json
	kubectl delete secret gcr-json-key \
	; kubectl create secret docker-registry gcr-json-key \
		--docker-server=https://gcr.io \
		--docker-username=_json_key \
		--docker-password="$$(cat ./.gcr_secret.json)" \
		--docker-email=${DOCKER_EMAIL}

cluster-apply:
	export EXTERNAL_IP=${EXTERNAL_IP} REPO=${REPO} HOST=${HOST} REPO_CREDS=${REPO_CREDS} TAG=${TAG} \
	&& cat infra/k8s/backend.deployment.yml | envsubst | kubectl apply -f - \
	&& cat infra/k8s/backend.service.yml    | envsubst | kubectl apply -f - \
	&& cat infra/k8s/backend.ingress.yml    | envsubst | kubectl apply -f -

cluster-delete:
	@ export EXTERNAL_IP=${EXTERNAL_IP} \
	; kubectl delete ingress backend \
	; kubectl delete deployment,service backend