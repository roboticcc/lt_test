## О проекте

Используемые технологии:
- Laravel Framework v9.50.2
- Vue3
- [tymondesigns/jwt-auth](https://laravel.com/docs/session) для авторизации и защиты роутов
- Docker

## Развёртывание проекта
1. В корне проекта выполняем команду `docker-compose up -d`
2. В терминале апликейшена (`docker exec -it project_app bash`) накатываем миграции с сидерами (`php artisan migrate --seed`)
3. В корне проекта выполняем `composer install`, `npm install`
4. Для запуска фронта выполняем `npm run dev`

### Возможные проблемы
1. Может возникнуть проблема с доступом до некоторых директорий проекта, обычно отваливается storage (из-за разных юзеров хоста и докера)
для её решения необходимо внутри консоли апликейшена выполнить `chmod -R 777 /var/www/`
2. Ошибки с доступами при запуске  `npm run dev`, решение аналогичное первому пункту

## API-методы

* <span style="background: green; color: white">POST</span> `/api/auth/register` -- принимает объект с полями `name`, `email`, `password` и `password_confirmation`. 
Возвращает статус `success` в случае успешной регистрации, в ином случае отдаёт `error` со списком полей, не прошедших валидацию
* <span style="background: green; color: white">POST</span>`/api/auth/login` -- принимает объект с полями "email" и "password", в случае успешного логина возвращает `token`, который содержит JWT-токен для авторизации, в противном случае отдаёт объект с ошибками логина
* <span style="background: red; color: white">DELETE</span>`/api/v1/:id/delete` -- удаляет задачу с указанным ID, доступно только пользователям с ролью администратора
* <span style="background: green; color: white">POST</span>`/api/v1/tasks` -- создаёт задачу, принимает обязательные параметры `title`, `content` и `category_id`, доступно только пользователям с ролью администратора
* <span style="background: orange; color: white">PATCH</span>`/api/v1/tasks/:id` -- редактирует задачу с указанным ID, принимает обязательные параметры `title`, `content` и `category_id`, доступно только пользователям с ролью администратора
* <span style="background: blue; color: white">GET</span>`/api/v1/tasks` -- возвращает список задач для текущего пользователя, создаёт таковой если он не был создан ранее
* <span style="background: blue; color: white">GET</span>`/api/v1/tasks/:id` -- возвращает инстанс задачи с указанным ID, содержит поля `title`, `content`, `category`, `completed`, где `category` -- название категории, а `completed` -- состояние задачи (выполнена/не выполнена) в контексте текущего пользователя
* <span style="background: green; color: white">POST</span>`/api/v1/tasks/:id/submit` -- отмечает задачу с указанным ID как решённую текущим пользователем
* <span style="background: green; color: white">POST</span>`/api/v1/tasks/:id/replace` -- заменяет задачу с указанным ID на случайную, не назначенную никому из пользователей


## Ежесуточное обновление

Создана команда `php artisan task:shuffle` для ежедневной перетасовки задач в случайном порядке, в `App\Console\Kernel` внесено соответствующее расписание
