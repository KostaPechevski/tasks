## Task Management App (Interview Project)

This Laravel 11 application is a small task management tool built for a technical assignment. It demonstrates clean, conventional Laravel code: Eloquent models, form requests, RESTful controllers, Blade views, and a lightweight drag-and-drop UI.

### Requirements

- PHP 8.3+
- Composer
- MySQL 8+ (or compatible)
- Node.js (optional, only if you want to compile assets instead of using the Tailwind CDN)

### Features

- Create, edit, and delete tasks
- Optional assignment of tasks to projects
- Tasks ordered by `priority` (ascending)
- Drag & drop reordering of tasks via SortableJS
- Project filter dropdown to show tasks for a single project

### Database schema

Two tables are used:

- `projects`
  - `id`
  - `name`
  - timestamps
- `tasks`
  - `id`
  - `name`
  - `priority` (integer, used for ordering)
  - `project_id` (nullable, foreign key to `projects`)
  - timestamps

Relationships:

- A `Project` has many `Task` records.
- A `Task` belongs to a `Project` (optionally).

### Installation

1. Install dependencies:

   ```bash
   composer install
   ```

2. Copy the environment file and configure MySQL:

   ```bash
   cp .env.example .env
   ```

   Update the database section:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=tasks_app
   DB_USERNAME=your_mysql_user
   DB_PASSWORD=your_mysql_password
   ```

3. Generate the application key:

   ```bash
   php artisan key:generate
   ```

4. Create the database in MySQL:

   ```sql
   CREATE DATABASE tasks_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

5. Run database migrations:

   ```bash
   php artisan migrate
   ```

### Running the application

Start the development server:

```bash
php artisan serve
```

Visit `http://127.0.0.1:8000` in your browser. You will be redirected to `/tasks`.

Main routes:

- `/projects` – list of projects
- `/tasks` – list of tasks with project filter and create form
- `/tasks/store` – POST, create a new task
- `/tasks/{task}/update` – PUT, update an existing task
- `/tasks/{task}/delete` – DELETE, delete a task
- `/tasks/reorder` – POST, reorder tasks via AJAX

### Reorder functionality

The `/tasks` view uses SortableJS to make table rows draggable.

- Each row has a `data-task-id` attribute.
- When a drag-and-drop operation finishes, the client script:
  - Reads the current row order from the DOM.
  - Builds an ordered array of task IDs.
  - Sends a JSON `POST` request to `/tasks/reorder` with `task_ids`.
- The `TaskController@reorder` method:
  - Receives the array of IDs (validated by `TaskReorderRequest`).
  - Updates each task’s `priority` to sequential values starting from 1, in the order provided.
- Tasks are always queried using `ORDER BY priority`, so the new order is consistently reflected on page reload.

