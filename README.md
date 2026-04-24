<p align="center">
  <img src="https://i.imgur.com/XPuoV4A.png" width="30%" />
</p>

<p align="center">
    A full-stack movie catalog platform inspired by Letterboxd. <br>
    Explore movies, manage collections, rate films, and watch trailers powered by the TMDB API.
</p>

<p align="center">
  <a href="https://cinebox-film-catalog-production.up.railway.app/">View Live Demo →</a>
</p>

<br>

![Banner Preview](https://i.imgur.com/iuPogUb.png)

<br>

![Explore Preview](https://i.imgur.com/9jPXnEw.png)

<p align="center">
Discover • Rate • Review • Build your movie collection
</p>

<br>

## 🍿 Features

- Add and remove movies from your personal collection  
- Rate movies (1 to 5 stars) and write/edit reviews  
- Mark movies as favorites  
- Organize and filter your collection (favorites, rated, not rated)  
- Search movies globally and within your collection  
- Discover upcoming and trending movies  
- Customize user profile (avatar and personal info)  
- Removing a movie from your collection will also delete its rating, review, and favorite status (with confirmation prompt)

<br>

## Tech Stack

### Backend
- Laravel 12.53.0 (PHP framework)
- MySQL (local development)
- PostgreSQL (production environment on Railway)

### Frontend
- Blade Templates
- Tailwind CSS
- Vanilla JavaScript (no frameworks)

### APIs & Services
- TMDB API (movie data provider)
- Mailtrap (email testing environment)
- Gmail SMTP (production email service)

### Media Storage
- Cloudinary (image upload, storage and CDN)

### DevOps / Deployment
- Railway (hosting & deployment platform)
- GitHub Actions (CI/CD pipeline)

<br>

## How to Run Locally

### 1. Clone the repository
```bash
git clone https://github.com/leticialencar/cinebox-film-catalog.git
cd cinebox-film-catalog
```

### 2. Install dependencies
```bash
composer install
npm install
```

### 3. Configure environment variables
```bash
cp .env.example .env
php artisan key:generate
```
Update your `.env` file with your database credentials and required API keys (TMDB, Cloudinary, etc).<br>
Mailtrap is optional and used only for local email testing.

### 4. Run database migrations
```bash
php artisan migrate
```

### 5. Start the development server
```bash
php artisan serve
npm run dev
# or for production build:
npm run build
```
The application will be available at: `http://localhost:8000`

<br>

## Future Improvements
- Docker deployment for production environment
- Google OAuth login integration
- Add tags/genres system for movies (custom user tags)
- Improve collection status system (`watched`, `want to watch`, `watching`)
- Possible social features (likes, reviews sharing between users)

<br>

## Author
 
Made with ❤️ by **Letícia Alencar** <br>
Personal project for learning and portfolio development.
And for those who love movies ;)

<br>

## Credits

Data provided by The Movie Database (TMDB).
https://www.themoviedb.org/

This project is not endorsed or certified by TMDB.

<br>

---
 
<div align="center">
⭐ If you liked this project, consider giving it a star — it helps a lot!
 
</div>
