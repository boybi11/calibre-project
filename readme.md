!! FIRST TIME INSTALLERS !!
download: http://www.microsoft.com/en-us/download/details.aspx?id=49983
download Python 2.7.11: https://www.python.org/downloads/
add python to PATH
npm config set python python2.7
npm config set msvs_version 2015 --global

!! DO THIS AT THE START !!
composer update
npm cache clean
npm install --no-bin-links
bower install
gulp copy
php artisan migrate --seeds

!! NOTES !!
API is auto-generated in /Http/Controllers/Api (need to copy paste routes)
