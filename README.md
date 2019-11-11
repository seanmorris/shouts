![avatar](https://avatars3.githubusercontent.com/u/640101?s=80&v=4)

# ShoutApi

https://github.com/seanmorris/shouts

![seanmorris-shoutapi](https://img.shields.io/badge/seanmorris-shoutapi-darkred?style=for-the-badge) [![Travis](https://img.shields.io/travis/seanmorris/shouts?style=for-the-badge)](https://travis-ci.org/seanmorris/shouts/) ![Size badge](https://img.shields.io/github/languages/code-size/seanmorris/shouts?style=for-the-badge)

## Demo

The ShoutApi is available at http://35.225.68.215.xip.io/, and will become available at http://shout.seanmorr.is/ as soon as the DNS propagates. It is currently running on Kubernetes under GKE on Google Cloud.

## Tests

[![Travis](https://img.shields.io/travis/seanmorris/shouts?style=flat-square)](https://travis-ci.org/seanmorris/shouts/)

ShoutApi tests are run on push to github by travis CI. Output is available here: https://travis-ci.org/seanmorris/shouts.

Tests can be run locally in a similar fashion to starting a development instance. The third command is where it diverges.

```bash
$ make dependencies # pull the composer depenencies
$ make build        # build your images locally
$ make test         # run the tests
```

## Dependencies

All the dependencies, their versions & configurations are handled by docker. You'll only need a few tools listed below to actually interact with the project. There's no need to search the web for the right version of a given dependency to run the project.

The following technologies are used under the hood:

* Apache & mod_rewrite
* PHP 7.3
* Pecl
* Redis
* Redis extension for PHP

### Development (docker-compose)

Development dependencies are Docker, Docker-Compose & Make. Installation instructions are available at the following links:

* https://docs.docker.com/install/
* https://docs.docker.com/compose/install/
* https://tecadmin.net/install-development-tools-on-debian/

### Production (kubernetes)

The production deployment targets standard Kubernetes clusters. You'll need Make, Kubectl, and a target such as MiniKube, Google GKE, or Amazon EKS.

* https://kubernetes.io/docs/tasks/tools/install-minikube/
* https://kubernetes.io/docs/tasks/tools/install-kubectl/
* https://tecadmin.net/install-development-tools-on-debian/

See your Kubernetes vendor documentation to set up Kubectt to utilize your cluster.

## Deployment

### Development

Simply clone the project and navigate to the directory. Run the following commands to get everything up and running:

```bash
$ make dependencies # pull the composer depenencies
$ make build        # build your images locally
$ make start        # start the project
```

You can also use this in place of the last command to start the project in the foreground:

```bash
$ make start-fg     # start the project in the foreground
```

Stop the project services with one command:

```bash
$ make stop
```

Once thats done, navigate to http://localhost in your browser.

### Production

First, set up your Kubernetes cluster & configure kubectl to use it. Once that's done you can apply your services to the cluster easily:

```bash
$ make cluster-apply
```

Take the project down from the cluster like so:


```bash
$ make cluster-delete
```

## Packaging

Run the following command to create a `.tar.gz` file of the entire project:

```bash
$ make pack
```
