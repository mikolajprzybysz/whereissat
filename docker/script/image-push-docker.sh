#!/usr/bin/env bash

# see http://kvz.io/blog/2013/11/21/bash-best-practices/
# make your script exit when a command fails
set -o errexit
# the exit status of the last command that threw a non-zero exit code is returned
set -o pipefail
# exit when your script tries to use undeclared variables.
set -o nounset

usage(){
	echo "Usage: $0 <semver>"
	exit 1
}

# invoke usage if version not supplied
[[ $# -lt 1 ]] && usage

VERSION=$1

docker push mikolajprzybysz/whereiss:${VERSION}
