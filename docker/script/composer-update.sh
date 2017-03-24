#!/usr/bin/env bash

# see http://kvz.io/blog/2013/11/21/bash-best-practices/
# make your script exit when a command fails
set -o errexit
# the exit status of the last command that threw a non-zero exit code is returned
set -o pipefail
# exit when your script tries to use undeclared variables.
set -o nounset

# https://getcomposer.org/doc/faqs/how-to-install-untrusted-packages-safely.md
docker run --rm -it -w "/var/www" \
    -v $PWD:/var/www \
    -v ~/.ssh:/root/.ssh \
    -v ~/.composer:/root/.composer \
    --volume "$SSH_AUTH_SOCK:$SSH_AUTH_SOCK" -e SSH_AUTH_SOCK=$SSH_AUTH_SOCK \
    composer/composer \
    "update"
