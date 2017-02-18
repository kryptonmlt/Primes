#!/bin/bash

set -e

# Requires: php-cli php-curl
$(dirname $(readlink -f "$0"))/composer-update.sh
cp $(dirname $(readlink -f "$0"))/composer.phar .
php composer.phar require mailgun/mailgun-php php-http/curl-client guzzlehttp/psr7
rm composer.{phar,lock,json}
