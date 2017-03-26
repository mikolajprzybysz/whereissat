# Whereissat
Shows the location of ISS

## Requirements

* php 5.5.*

## Get google api key
You can obtain you google api key here:

    https://developers.google.com/maps/documentation/geocoding/get-api-key#key

## run with docker
If you have docker installed, simply run following commands:

    ./docker/script/image-build.sh master
    GOOGLE_MAPS_API_KEY=YOUR_API_KEY DOCKER_TAG=master docker-compose -f docker-compose.yml up -d --force-recreate

now you can visit the site at:

    http://localhost:8888
    
## run on linux

    echo 'SetEnv GOOGLE_MAPS_API_KEY YOUR_API_KEY' >> public/.htaccess

## run unit tests

    (cd tests && ../vendor/bin/phpunit)
