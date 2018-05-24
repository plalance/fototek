#!/bin/sh

php ./bin/console doctrine:cache:clear-metadata
php ./bin/console doctrine:cache:clear-query
php ./bin/console doctrine:cache:clear-result
php ./bin/console cache:clear --no-warmup

php ./bin/console cache:warmup --env=prod