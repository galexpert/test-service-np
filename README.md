
скачиваем проект с ветки master

$ git clone https://github.com/galexpert/test-service-np.git <имя_папки>
создаем и подключаем БД на лкальном сервере
в файле локальном .env необходимо установить настройки 
APP_KEY=<сгенерировать свой ключ приложения>
APP_URL=<локальный адрес>
QUEUE_CONNECTION=database
DB_DATABASE=<локальная база данных>


стартуем работу локального сервера...


далее в консоли выполняем такие действия
устанавливаем все зависимости
npm install
composer install
необходимо выполнить команду
php artisan key:generate
php artisan storage:link

php artisan migrate
php artisan Cities:import
php artisan queue:work

npm run build или vite build
чтобы сайт корректно отображался, возможно придется настроить редирект с основного локального домена на папку /public
local-domain --> /local-domain/public Это возможно сделать в настройках вашего сервера или в файле .htacces


рабочая тестовая страница должна открываться локальному домену вашего проекта (.env APP_URL=)  напр http://localhost
Если все правильно выполненно, там будет форма рассчета стоимости доставки с выбором городов отделений...
