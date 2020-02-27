#!/bin/bash

printf "Waiting for Vespa Configuration Server to start"
while [[ "$(curl -s -o /dev/null -w ''%{http_code}'' http://localhost:19071/ApplicationStatus)" != "200" ]];
do
    printf "."
    sleep 1
done
printf "\n"

printf "Preparing Vespa Application...\n"
/opt/vespa/bin/vespa-deploy prepare /app/src/main/application && /opt/vespa/bin/vespa-deploy activate

printf "Waiting for Vespa Application Server to start"
while [[ "$(curl -s -o /dev/null -w ''%{http_code}'' http://localhost:8080/ApplicationStatus)" != "200" ]];
do
    printf "."
    sleep 3  # may take a little while
done
printf "\n"
