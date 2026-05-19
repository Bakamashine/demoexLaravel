# Laravel Учебный Портал

Веб-приложение для управления учебными заявками, отзывами и разделения прав доступа между обычными пользователями и администраторами.

## 📑 Содержание

- [Требования](#требования)
- [Установка и запуск](#установка-и-запуск)
- [Архитектура проекта](#архитектура-проекта)
- [База данных](#база-данных)
- [Контроллеры](#контроллеры)
- [Form Requests](#form-requests)
- [Модели](#модели)
- [Enum (Перечисления)](#enum-перечисления)
- [Маршруты (Routes)](#маршруты-routes)
- [Представления (Views)]#представления-views)
- [Middleware](#middleware)
- [Сидеры (Seeders)](#сидеры-seeders)
- [Функционал](#функционал)

---

## ⚙️ Требования

- PHP >= 8.1
- Composer
- SQLite / MySQL / PostgreSQL

---

## 🚀 Установка и запуск

1. **Клонирование репозитория**
   ```bash
   git clone <repository_url>
   cd demoexLaravel
   ```

2. **Установка зависимостей**
   ```bash
   composer install
   ```

3. **Настройка окружения**
   Скопируйте `.env.example` в `.env` и настройте подключение к БД.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Миграции и сидеры**
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Запуск сервера**
   ```bash
   php artisan serve
   ```

6. **Данные для входа (из сидера)**
   - **Администратор**:
     - Логин: `Admin` (поле `login`)
     - Пароль: `KorokNET`
   - **Пользователь**:
     - Email: `user@example.com`
     - Пароль: `password`

---

## 🏗️ Архитектура проекта

Проект построен на Laravel с использованием MVC-архитектуры, форм-реквестов для валидации, ENUM для типизации статусов и ролей, а также middleware для защиты маршрутов.

---

## 🗄️ База данных

### Таблица `users`
| Поле | Тип | Описание |
|------|-----|----------|
| `id` | ID | Уникальный идентификатор |
| `fio` | string | ФИО пользователя |
| `login` | string | Логин (только для администраторов) |
| `email` | string | Email (уникальный) |
| `password` | string | Хэш пароля |
| `phone` | string | Телефон |
| `role` | string | Роль (`Admin` или `User`) |
| `timestamps` | datetime | Время создания/обновления |

### Таблица `orders` (Заявки)
| Поле | Тип | Описание |
|------|-----|----------|
| `id` | ID | Уникальный идентификатор |
| `user_id` | FK | Ссылка на пользователя |
| `course_name` | string | Название курса |
| `date` | date | Дата заявки |
| `payment_type` | string | Тип оплаты (`money`, `phone`) |
| `status` | string | Статус (`New`, `Middle`, `End`) |

### Таблица `feedbacks` (Отзывы)
| Поле | Тип | Описание |
|------|-----|----------|
| `id` | ID | Уникальный идентификатор |
| `user_id` | FK | Ссылка на пользователя |
| `comment` | text | Текст отзыва |
| `rating` | integer | Оценка (1–5) |

---

## 🎛️ Контроллеры

| Контроллер | Назначение |
|------------|------------|
| `AuthController` | Авторизация и регистрация обычных пользователей. |
| `AdminController` | Вход администратора, просмотр всех заявок и смена их статусов. |
| `AccountController` | Личный кабинет пользователя (просмотр своих заявок, создание отзывов). |
| `OrderController` | Создание и удаление заявок пользователем. |
| `FeedbackController` | Сохранение отзывов. |
| `MainController` | Отображение главной страницы (слайдер + список отзывов). |

---

## 📝 Form Requests

| Класс | Валидация |
|-------|-----------|
| `LoginRequest` | `email` (email, exists), `password` (required) |
| `RegisterRequest` | `fio` (required), `email` (email, unique), `password` (min:8, confirmed) |
| `AdminAuthRequest` | `login` (exists:users,login), `password` (required) |
| `OrderRequest` | `course_name` (required), `date` (required, date), `payment_type` (in:money,phone) |
| `FeedbackRequest` | `comment` (required), `rating` (integer, 1–5) |
| `UpdateOrderStatusRequest` | `status` (required, in:New,Middle,End) |

---

## 📦 Модели

| Модель | Связи | Особенности |
|--------|-------|-------------|
| `User` | `orders()` (hasMany), `feedbacks()` (hasMany) | Casts: `role` -> `UserRole`, `password` -> `hashed` |
| `Order` | `user()` (belongsTo) | Casts: `status` -> `OrderStatus`, `date` -> `date` |
| `Feedback` | `user()` (belongsTo) | Хранит текст комментария и оценку |

---

## 🔢 Enum (Перечисления)

| Enum | Значения |
|------|----------|
| `UserRole` | `Admin`, `User` |
| `OrderStatus` | `New`, `Middle`, `End` |

---

## 🛣️ Маршруты (Routes)

| Метод | URI | Имя | Контроллер | Доступ |
|-------|-----|-----|------------|--------|
| GET | `/` | `main` | `MainController` | Все |
| GET | `/about` | `about` | View | Все |
| GET | `/login` | `login` | `AuthController@LoginView` | Гость |
| POST | `/login` | `login.store` | `AuthController@Login` | Гость |
| GET | `/register` | `register` | `AuthController@RegisterView` | Гость |
| POST | `/register` | `register.store` | `AuthController@Register` | Гость |
| POST | `/logout` | `logout` | `AuthController@Logout` | Авторизован |
| GET | `/account` | `account` | `AccountController` | Авторизован |
| GET | `/order/create` | `order.create` | `OrderController@create` | Авторизован |
| POST | `/order` | `order.store` | `OrderController@store` | Авторизован |
| DELETE | `/order/{order}` | `order.destroy` | `OrderController@destroy` | Авторизован |
| POST | `/feedback` | `feedback.store` | `FeedbackController@store` | Авторизован |
| GET | `/admin/login` | `admin.login` | `AdminController@loginView` | Гость |
| POST | `/admin/login` | `admin.login.store` | `AdminController@login` | Гость |
| GET | `/admin` | `admin.index` | `AdminController@index` | **Admin** |
| PATCH | `/admin/order/{order}/status` | `admin.order.updateStatus` | `AdminController@updateStatus` | **Admin** |

---

## 📄 Представления (Views)

| Файл | Описание |
|------|----------|
| `layouts/basic.blade.php` | Основной макет (navbar, footer, подключение стилей) |
| `auth/login.blade.php` | Форма входа обычного пользователя |
| `auth/register.blade.php` | Форма регистрации |
| `admin/login.blade.php` | Форма входа администратора (по логину) |
| `admin/index.blade.php` | Панель администратора (таблица заявок, смена статуса) |
| `account.blade.php` | Личный кабинет пользователя |
| `order/create.blade.php` | Форма создания заявки |
| `index.blade.php` | Главная страница (слайдер + отзывы) |
| `about.blade.php` | Страница "О нас" |

---

## 🛡️ Middleware

| Middleware | Назначение |
|------------|------------|
| `auth` | Стандартная проверка авторизации Laravel. |
| `admin` (`IsAdmin`) | Проверяет, что пользователь авторизован и имеет роль `Admin`. Иначе возвращает `403 Forbidden`. |

---

## 🌱 Сидеры (Seeders)

| Сидер | Описание |
|-------|----------|
| `UserSeeder` | Создает администратора (`Admin`/`KorokNET`) и обычного пользователя (`user@example.com`/`password`). |
| `DatabaseSeeder` | Запускает `UserSeeder`. |

---

## ✨ Функционал

### Для обычных пользователей:
- Регистрация и вход по email.
- Создание заявок на курсы (название, дата, тип оплаты).
- Просмотр и удаление своих заявок.
- Оставление отзывов с рейтингом.
- Просмотр всех отзывов на главной странице.

### Для администраторов:
- Отдельный вход по логину.
- Просмотр всех заявок от всех пользователей.
- Изменение статуса заявок:
  - `New` → Новая
  - `Middle` → Идёт обучение
  - `End` → Обучение завершено

---

## 🛠️ Технологии

- **Laravel 11**
- **Bootstrap 5**
- **SQLite / MySQL**
- **Blade Templates**
- **Enums (PHP 8.1+)**
