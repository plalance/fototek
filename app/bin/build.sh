#!/bin/sh
php ./bin/console doctrine:generate:entities SiteBundle --no-backup
php ./bin/console doctrine:generate:entities UserBundle --no-backup

( exec "./app/bin/migrate.sh" )