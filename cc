#!/bin/bash

sudo chmod -R 777 app/cache/ app/logs/
app/console cache:clear
sudo chmod -R 777 app/cache/ app/logs/
