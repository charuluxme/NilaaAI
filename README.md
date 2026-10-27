# Nilaa AI

**AI-Powered Resume Analysis & Interview Practice Platform**

Nilaa AI is a full-stack Laravel application that helps job seekers improve their resumes through AI-powered analysis and provides personalized interview practice with instant feedback.

## Features

- 📄 **Resume Upload & Parsing** - Upload PDF/DOCX resumes with automatic text extraction
- 🎯 **ATS Score Analysis** - Get an Applicant Tracking System compatibility score
- 📊 **Readability Metrics** - Measure resume clarity and impact
- 🏷️ **Skill Detection** - Automatically extract and categorize technical skills
- 💡 **AI Suggestions** - Receive actionable improvement recommendations
- 🎤 **Mock Interviews** - Practice with AI-generated role-specific questions
- ⚡ **Real-time Evaluation** - Get instant feedback on interview answers
- 📈 **Progress Tracking** - Monitor improvement over multiple sessions

## Tech Stack

- **Backend**: Laravel 10, PHP 8.2
- **Database**: MySQL 8
- **Queue**: Redis
- **Frontend**: Blade Templates, Tailwind CSS, Vite
- **AI Integration**: OpenAI GPT-4
- **PDF Parsing**: spatie/pdf-to-text
- **Authentication**: Laravel Breeze + Sanctum

## Prerequisites

- PHP 8.2+
- Composer
- Node.js 18+
- MySQL 8
- Redis
- `pdftotext` utility (from poppler-utils)

## Installation

### 1. Clone the Repository

```bash
git clone https://github.com/yourusername/resumentor.git
cd resumentor
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Configure Environment

```bash
cp .env.example .env
```

Edit `.env` and set:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=resumentor
DB_USERNAME=root
DB_PASSWORD=your_password

REDIS_HOST=127.0.0.1
QUEUE_CONNECTION=redis

OPENAI_API_KEY=your_openai_api_key
OPENAI_MODEL=gpt-4
```

### 4. Generate App Key

```bash
php artisan key:generate
```

### 5. Run Migrations & Seeders

```bash
php artisan migrate --seed
```

This creates:
- Admin user: `admin@resumentor.local` / `password`
- Demo user: `demo@resumentor.local` / `password`

### 6. Build Assets

```bash
npm run build
```

### 7. Start Services

**Option A: Local Development**

```bash
# Terminal 1: Web server
php artisan serve

# Terminal 2: Queue worker
php artisan queue:work

# Terminal 3: Asset building (watch mode)
npm run dev
```

**Option B: Docker**

```bash
docker-compose up -d
```

Visit: http://localhost:8000

## API Endpoints

### Resume Management

**Upload Resume**
```http
POST /api/upload-resume
Content-Type: multipart/form-data

file: <resume.pdf>
```

**Get Analysis**
```http
GET /api/resume/{id}/analysis

Response:
{
  "resume": {...},
  "analysis": {
    "extracted_text": "...",
    "skills": [...],
    "ats_score": 85,
    "readability_score": 72.5,
    "suggestions": [...]
  }
}
```

### Interview Sessions

**Start Interview**
```http
POST /api/interview/{resume_id}/start
Content-Type: application/json

{
  "role_applied": "Backend Developer",
  "mode": "text"
}

Response:
{
  "interview_session_id": 1,
  "questions": [...]
}
```

**Submit Answer**
```http
POST /api/interview/{session_id}/answer
Content-Type: application/json

{
  "question_id": 1,
  "answer_text": "...",
  "duration_seconds": 120
}

Response:
{
  "evaluation": {
    "score": 85,
    "strengths": [...],
    "weaknesses": [...],
    "suggestions": [...]
  },
  "updated_overall_score": 82.5
}
```

## Artisan Commands

**Reparse Resumes**
```bash
php artisan resumentor:reparse-resumes
php artisan resumentor:reparse-resumes --status=failed --limit=10
```

## Configuration

### Parser Settings (`config/parser.php`)

- `driver`: PHP or Python parser (`php` | `python`)
- `pdftotext_path`: Path to pdftotext binary
- `max_resume_size_mb`: Maximum upload size (default: 5)

### OpenAI Settings (`config/openai.php`)

- `api_key`: OpenAI API key
- `model`: Model name (default: `gpt-4`)
- `max_tokens`: Max response tokens (default: 2000)
- `temperature`: Response creativity (default: 0.7)

### Prompt Templates

Located in `storage/prompts/openai_templates.json`:
- `question_generation`: Interview question prompts
- `answer_evaluation`: Answer evaluation criteria
- `session_summary`: Overall scoring logic
- `bullet_rewrite`: Resume bullet improvement

## Testing

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit

# With coverage
php artisan test --coverage
```

## Architecture

```
app/
├── Console/Commands/        # Artisan commands
├── Events/                  # Event classes
├── Http/
│   ├── Controllers/Api/    # API controllers
│   └── Requests/           # Form validation
├── Jobs/                   # Queue jobs
├── Models/                 # Eloquent models
└── Services/               # Business logic
    ├── ResumeParserService
    ├── SkillExtractorService
    ├── AnalysisService
    └── OpenAIService
```

**Design Pattern**: Clean Architecture
- Controllers handle HTTP
- Services contain business logic
- Jobs handle async processing
- Events decouple components

## Deployment

### Production Checklist

- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Configure `APP_KEY`
- [ ] Use HTTPS (`APP_URL=https://...`)
- [ ] Set strong database credentials
- [ ] Configure CORS in `config/cors.php`
- [ ] Set up Supervisor for queue worker
- [ ] Configure rate limiting
- [ ] Enable Redis caching
- [ ] Set up log rotation
- [ ] Configure file storage encryption
- [ ] Add data retention policy

### Supervisor Configuration

```ini
[program:resumentor-queue]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/path/to/logs/queue-worker.log
```

### Nginx Configuration

```nginx
server {
    listen 80;
    server_name resumentor.example.com;
    root /var/www/resumentor/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## Performance Optimization

- Enable OPcache in production
- Use Redis for sessions and cache
- Queue all heavy operations (parsing, AI calls)
- Implement rate limiting on OpenAI calls
- Cache frequently accessed data
- Use CDN for static assets

## Security

- All file uploads validated (type, size)
- CSRF protection enabled
- SQL injection prevention via Eloquent
- XSS protection via Blade escaping
- API rate limiting
- Resume files stored outside public directory
- Encryption at rest recommended for PII

## Privacy & Compliance

- Resume files contain PII - implement data retention policy
- Provide user data export/delete endpoints
- Log minimal user data
- Consider GDPR/CCPA requirements
- Encrypt file storage at rest

## Optional: Python Microservice

For advanced parsing (audio transcription, NLP):

1. Set `PARSER_DRIVER=python` in `.env`
2. Set `PARSER_PYTHON_ENDPOINT=http://localhost:5000/parse`
3. Deploy Python service with:
   - Whisper (audio transcription)
   - PyPDF (PDF extraction)
   - spaCy (NLP)

## Troubleshooting

**Queue jobs not processing**
```bash
php artisan queue:restart
php artisan queue:work --queue=default
```

**PDF parsing fails**
```bash
# Install pdftotext
sudo apt-get install poppler-utils

# Verify path
which pdftotext
```

**OpenAI errors**
- Check API key in `.env`
- Verify sufficient credits
- Check rate limits

## Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push to branch (`git push origin feature/amazing-feature`)
5. Open Pull Request

## License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## Support

For issues and questions:
- GitHub Issues: [https://github.com/yourusername/resumentor/issues](https://github.com/yourusername/resumentor/issues)
- Email: support@resumentor.local

---

**Built with ❤️ using Laravel & OpenAI**
