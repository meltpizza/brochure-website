#!/bin/bash

# -------------------
# Setup script
#
# To install into production environment, run:
#   ./setup.sh
# -------------------

# make sure it's deleteable
chmod -R 777 app/cache app/logs

if [ ! -f "composer.phar" ]; then
    # get latest composer.phar
    curl -s http://getcomposer.org/installer | /usr/bin/php
fi

# Install dependencies
echo "Running composer install..."
/usr/bin/php composer.phar install --no-dev --optimize-autoloader

/usr/bin/php app/console cache:clear --env=prod
/usr/bin/php app/console assets:install --env=prod
/usr/bin/php app/console assetic:dump --env=prod --no-debug

# make sure everything is writeable
chmod -R 777 app/cache app/logs
