#!/bin/bash

./config/init.sh

composer install
npm install
npx gulp css
npx gulp js 
docker build -t phppinarmvc:1 .

chmod +x ./start.sh
./start.sh
