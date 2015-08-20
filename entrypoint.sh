#!/bin/bash

php app/console cache:clear --no-debug
php app/console assets:install --symlink web
# php app/console assetic:dump web
php app/console doctrine:schema:update --force
/bin/bash -l -c "$*"
