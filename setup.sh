heroku config:set APP_ENV=production
heroku config:set LOG_CHANNEL=errorlog
heroku config:set DB_CONNECTION=herokupg
heroku config:set APP_KEY=`php artisan key:generate --show`