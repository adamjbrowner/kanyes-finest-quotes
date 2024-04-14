# /bin/sh

# start the laravel dev app

docker run --rm --interactive --tty \
  --volume $PWD:/app \
  composer install

cp .env.example .env

./vendor/bin/sail up -d
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --force

nohup ./vendor/bin/sail artisan queue:work --daemon &

./vendor/bin/sail artisan test

./vendor/bin/sail npm install
./vendor/bin/sail npm run dev