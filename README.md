# BTH Test

Инструкция по разворачиванию и запуску проекта после клонирования репозитория.

## Требования

- Docker Engine + Docker Compose (plugin `docker compose`)
- Git

## 1) Первый запуск через Docker Compose

1. Клонируйте репозиторий и перейдите в папку проекта:

   ```bash
   git clone <URL_РЕПОЗИТОРИЯ>
   cd bth-test
   ```

2. Создайте локальный `.env`:

   ```bash
   cp .env.example .env
   ```

3. Поднимите контейнеры:

   ```bash
   docker compose up -d --build
   ```

4. Установите PHP-зависимости внутри контейнера приложения:

   ```bash
   docker compose exec laravel.test composer install
   ```

На этом шаге в проекте появится `vendor/bin/sail`, и дальше можно использовать Sail.

## 2) Дальнейшая работа через Sail

1. Если контейнеры уже подняты на предыдущем шаге, можно сразу перейти к командам Sail.
   При необходимости запустить контейнеры:

   ```bash
   ./vendor/bin/sail up -d
   ```

2. Сгенерируйте ключ приложения:

   ```bash
   ./vendor/bin/sail artisan key:generate
   ```

3. Выполните миграции:

   ```bash
   ./vendor/bin/sail artisan migrate
   ```

4. Установите JS-зависимости:

   ```bash
   ./vendor/bin/sail npm install
   ```

5. Запустите проект:

   - Backend + инфраструктура уже работают в контейнерах.
   - Для frontend в режиме разработки:

     ```bash
     ./vendor/bin/sail npm run dev
     ```

6. Откройте приложение в браузере:

   - [http://localhost](http://localhost)

## Полезные команды Sail

```bash
./vendor/bin/sail artisan test       # запуск тестов
./vendor/bin/sail artisan migrate:fresh --seed
./vendor/bin/sail down               # остановить контейнеры
```

## (Опционально) Алиас для Sail

Чтобы не писать каждый раз `./vendor/bin/sail`, можно добавить алиас:

```bash
alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'
```

После этого команды можно запускать так:

```bash
sail up -d
sail artisan migrate
sail npm run dev
```
