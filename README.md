# MyFile

MyFile is an open-source cloud file storage system built with Laravel, Livewire, Flux, and Toaster. It allows you to securely upload, organize, and share files and directories with modern UI and robust privacy controls.

## Features

- Upload and organize files into directories
- Share files and directories with public/private links
- Toggle privacy for files and directories
- Delete files and directories (recursive delete)
- Activity logging
- Responsive, modern UI with Flux components
- Toast notifications for actions

## Requirements

- Docker (recommended) or PHP 8.2+, Composer, Node.js, and npm
- MySQL or PostgreSQL database

## Getting Started

### 1. Clone the Repository

```sh
git clone https://github.com/mfazrinizar/MyFile-Laravel.git
cd MyFile-Laravel
```

### 2. Copy Environment File

```sh
cp .env.example .env
```

Edit `.env` and set your database and app credentials.

### 3. Build and Run with Docker

```sh
docker build -t myfile-app .
docker run --rm -it -p 9000:9000 -v $(pwd):/var/www myfile-app
```

Or use [docker-compose](https://docs.docker.com/compose/) if you have a `docker-compose.yml`.

### 4. Install Dependencies (if not using Docker)

```sh
composer install
npm install
npm run build
```

### 5. Run Migrations

```sh
php artisan migrate
```

### 6. Start the Application

If using Docker, PHP-FPM will be running on port 9000.  
If running locally:

```sh
php artisan serve
```

Visit [http://localhost:8000](http://localhost:8000) or your configured URL.

## Usage

- Register a new account and log in.
- Upload files, create directories, and organize your storage.
- Use the "Options" menu to share, toggle privacy, or delete files/directories.
- Shared links can be accessed by anyone with the link (if public).

## Development

- **Frontend:** Vite, Tailwind CSS, Alpine.js, Flux UI
- **Backend:** Laravel, Livewire, Eloquent ORM
- **Notifications:** [masmerise/livewire-toaster](https://github.com/masmerise/livewire-toaster)

### Scripts

- `npm run dev` — Start Vite dev server
- `npm run build` — Build assets for production
- `php artisan serve` — Start Laravel development server

## Testing

```sh
php artisan test
```

**Repository:** [https://github.com/mfazrinizar/MyFile-Laravel](https://github.com/mfazrinizar/MyFile-Laravel)  
**Documentation:** [README.md](https://github.com/mfazrinizar/MyFile-Laravel/blob/main/README.md)