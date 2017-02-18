#!/bin/sh

EXPECTED_SIGNATURE=$(wget -q -O - https://composer.github.io/installer.sig)
OLD_SIGNATURE=$(test -f old_installer.sig && cat old_installer.sig)
RESULT=0

cd $(dirname $(readlink -f "$0"))

if [ "$OLD_SIGNATURE" != "$EXPECTED_SIGNATURE" ]
then
   php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
   ACTUAL_SIGNATURE=$(php -r "echo hash_file('SHA384', 'composer-setup.php');")

   if [ "$EXPECTED_SIGNATURE" != "$ACTUAL_SIGNATURE" ]
   then
      >&2 echo 'ERROR: Invalid installer signature'
      rm composer-setup.php
      exit 1
   fi
   echo "$ACTUAL_SIGNATURE" > old_installer.sig

   php composer-setup.php --quiet
   RESULT=$?
   rm composer-setup.php
fi
exit $RESULT
