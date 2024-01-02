#!/bin/bash

./config/init.sh

composer update
docker compose up

if [ "$1" == "dev" ]; then
  npx gulp dev
fi
