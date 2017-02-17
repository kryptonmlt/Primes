#!/bin/bash

# Requires: php-cli php-curl
curl -sS https://getcomposer.org/installer | php
php composer.phar require mailgun/mailgun-php php-http/curl-client guzzlehttp/psr7
rm composer.{phar,lock,json}
