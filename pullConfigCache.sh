#!/bin/bash

set -e


echo 'git pull'
git pull
echo '--------------------------------------------------'
echo 'php artisan config:cache'
php artisan config:cache
echo '--------------------------------------------------'
echo 'php artisan config:clear'
php artisan config:clear
echo '--------------------------------------------------'
echo 'php artisan view:clear'
php artisan view:clear
echo '----------------'$(tput setaf 3)'Process Completed!'$(tput sgr0)'----------------'
