<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Resume;
use App\Models\ResumeAnalysis;
use App\Models\SkillTag;
use App\Models\InterviewSession;
use App\Models\InterviewQuestion;
use App\Models\InterviewAnswer;
use App\Models\Feedback;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('Seeding database...');

        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@nilaaai.local',
            'password' => 'password',
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create demo users
        $user1 = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        $user2 = User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => 'password',
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        $user3 = User::create([
            'name' => 'Michael Johnson',
            'email' => 'michael@example.com',
            'password' => 'password',
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        $this->command->info('Users created!');

        // Create skill tags
        $skills = [
            'PHP', 'Laravel', 'JavaScript', 'React', 'Vue.js', 'Node.js', 
            'Python', 'Django', 'Java', 'Spring Boot', 'MySQL', 'PostgreSQL',
            'MongoDB', 'Docker', 'Kubernetes', 'AWS', 'Azure', 'Git',
            'HTML', 'CSS', 'TypeScript', 'Angular', 'REST API', 'GraphQL',
            'Redis', 'Elasticsearch', 'CI/CD', 'Agile', 'Scrum', 'TDD'
        ];

        $skillTags = [];
        foreach ($skills as $skill) {
            $skillTags[] = SkillTag::create([
                'name' => $skill,
                'canonical_name' => strtolower(str_replace(['.', ' '], ['', '-'], $skill)),
            ]);
        }

        $this->command->info('Skill tags created!');

        // Create resumes for users
        $resume1 = Resume::create([
            'user_id' => $user1->id,
            'file_path' => 'resumes/john_doe_resume.pdf',
            'original_filename' => 'John_Doe_Resume.pdf',
            'mime_type' => 'application/pdf',
            'size_bytes' => 245678,
            'uploaded_at' => now()->subDays(10),
            'status' => 'parsed',
        ]);

        $resume2 = Resume::create([
            'user_id' => $user2->id,
            'file_path' => 'resumes/jane_smith_resume.pdf',
            'original_filename' => 'Jane_Smith_Resume.pdf',
            'mime_type' => 'application/pdf',
            'size_bytes' => 198234,
            'uploaded_at' => now()->subDays(5),
            'status' => 'parsed',
        ]);

        $resume3 = Resume::create([
            'user_id' => $user3->id,
            'file_path' => 'resumes/michael_johnson_resume.docx',
            'original_filename' => 'Michael_Johnson_Resume.docx',
            'mime_type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'size_bytes' => 312456,
            'uploaded_at' => now()->subDays(2),
            'status' => 'parsed',
        ]);

        $this->command->info('Resumes created!');

        // Attach skills to resumes
        $resume1->skillTags()->attach([$skillTags[0]->id, $skillTags[1]->id, $skillTags[2]->id, $skillTags[10]->id, $skillTags[15]->id]);
        $resume2->skillTags()->attach([$skillTags[2]->id, $skillTags[3]->id, $skillTags[4]->id, $skillTags[18]->id, $skillTags[19]->id]);
        $resume3->skillTags()->attach([$skillTags[6]->id, $skillTags[7]->id, $skillTags[11]->id, $skillTags[15]->id, $skillTags[22]->id]);

        // Create resume analyses
        $analysis1 = ResumeAnalysis::create([
            'resume_id' => $resume1->id,
            'extracted_text' => "JOHN DOE\nSenior Full Stack Developer\n\nEXPERIENCE:\n- 5 years of experience in web development\n- Proficient in PHP, Laravel, JavaScript, MySQL, AWS\n- Led team of 5 developers\n\nEDUCATION:\nBachelor of Computer Science\nUniversity of Technology, 2018",
            'skills_json' => json_encode(['PHP', 'Laravel', 'JavaScript', 'MySQL', 'AWS']),
            'ats_score' => 85,
            'readability_score' => 7.8,
            'suggestions' => "Great resume! Consider:\n- Adding more quantifiable achievements\n- Including certification details\n- Expanding project descriptions",
        ]);

        $analysis2 = ResumeAnalysis::create([
            'resume_id' => $resume2->id,
            'extracted_text' => "JANE SMITH\nFrontend Developer\n\nEXPERIENCE:\n- 3 years of React development\n- Created 10+ responsive web applications\n- Expert in JavaScript, React, Vue.js, HTML, CSS\n\nEDUCATION:\nMaster of Computer Science\nTech University, 2020",
            'skills_json' => json_encode(['JavaScript', 'React', 'Vue.js', 'HTML', 'CSS']),
            'ats_score' => 78,
            'readability_score' => 8.2,
            'suggestions' => "Good resume! Recommendations:\n- Add links to portfolio projects\n- Include metrics on application performance\n- List specific frameworks and libraries used",
        ]);

        $analysis3 = ResumeAnalysis::create([
            'resume_id' => $resume3->id,
            'extracted_text' => "MICHAEL JOHNSON\nBackend Engineer\n\nEXPERIENCE:\n- 4 years Python/Django development\n- Built scalable microservices architecture\n- Skills: Python, Django, PostgreSQL, AWS, REST API\n\nEDUCATION:\nBachelor of Software Engineering\nState University, 2019",
            'skills_json' => json_encode(['Python', 'Django', 'PostgreSQL', 'AWS', 'REST API']),
            'ats_score' => 82,
            'readability_score' => 7.5,
            'suggestions' => "Strong technical resume! Consider:\n- Highlight specific projects and impact\n- Add more details about system design\n- Include team collaboration examples",
        ]);

        $this->command->info('Resume analyses created!');

        // Create interview sessions
        $session1 = InterviewSession::create([
            'resume_id' => $resume1->id,
            'role_applied' => 'Senior Full Stack Developer',
            'started_at' => now()->subDays(8),
            'completed_at' => now()->subDays(8)->addMinutes(45),
            'overall_score' => 8.5,
            'session_metadata' => json_encode(['duration_minutes' => 45, 'total_questions' => 5]),
        ]);

        $session2 = InterviewSession::create([
            'resume_id' => $resume2->id,
            'role_applied' => 'Frontend Developer',
            'started_at' => now()->subDays(3),
            'completed_at' => now()->subDays(3)->addMinutes(40),
            'overall_score' => 7.8,
            'session_metadata' => json_encode(['duration_minutes' => 40, 'total_questions' => 5]),
        ]);

        $session3 = InterviewSession::create([
            'resume_id' => $resume3->id,
            'role_applied' => 'Backend Engineer',
            'started_at' => now()->subDay(),
            'completed_at' => now()->subDay()->addMinutes(50),
            'overall_score' => 8.2,
            'session_metadata' => json_encode(['duration_minutes' => 50, 'total_questions' => 5]),
        ]);

        $this->command->info('Interview sessions created!');

        // Create interview questions and answers for session 1
        $question1_1 = InterviewQuestion::create([
            'interview_session_id' => $session1->id,
            'question_text' => 'Can you explain the MVC architecture pattern and how Laravel implements it?',
            'question_type' => 'text',
            'difficulty' => 3,
        ]);

        InterviewAnswer::create([
            'interview_question_id' => $question1_1->id,
            'answer_text' => 'MVC stands for Model-View-Controller. In Laravel, Models represent data, Views handle presentation using Blade templates, and Controllers manage the business logic. Laravel implements this with Eloquent ORM for models, Blade for views, and controller classes for handling requests.',
            'duration_seconds' => 180,
            'evaluation_json' => json_encode(['clarity' => 9, 'accuracy' => 9, 'completeness' => 8]),
            'score' => 8.7,
        ]);

        $question1_2 = InterviewQuestion::create([
            'interview_session_id' => $session1->id,
            'question_text' => 'Write a function to find the second largest element in an array.',
            'question_type' => 'code',
            'difficulty' => 4,
        ]);

        InterviewAnswer::create([
            'interview_question_id' => $question1_2->id,
            'answer_text' => "function secondLargest(arr) {\n  let first = -Infinity, second = -Infinity;\n  for(let num of arr) {\n    if(num > first) {\n      second = first;\n      first = num;\n    } else if(num > second && num < first) {\n      second = num;\n    }\n  }\n  return second;\n}",
            'duration_seconds' => 420,
            'evaluation_json' => json_encode(['correctness' => 9, 'efficiency' => 8, 'code_quality' => 9]),
            'score' => 8.7,
        ]);

        $question1_3 = InterviewQuestion::create([
            'interview_session_id' => $session1->id,
            'question_text' => 'Tell me about a challenging project you led and how you overcame obstacles.',
            'question_type' => 'behavioral',
            'difficulty' => 3,
        ]);

        InterviewAnswer::create([
            'interview_question_id' => $question1_3->id,
            'answer_text' => 'I led a team to migrate a monolithic application to microservices. The main challenge was maintaining zero downtime. We used strangler pattern, implemented feature flags, and performed gradual rollout. The project took 6 months and reduced deployment time by 70%.',
            'duration_seconds' => 240,
            'evaluation_json' => json_encode(['relevance' => 9, 'detail' => 8, 'impact' => 9]),
            'score' => 8.7,
        ]);

        // Create interview questions and answers for session 2
        $question2_1 = InterviewQuestion::create([
            'interview_session_id' => $session2->id,
            'question_text' => 'What are React hooks and why are they useful?',
            'question_type' => 'text',
            'difficulty' => 3,
        ]);

        InterviewAnswer::create([
            'interview_question_id' => $question2_1->id,
            'answer_text' => 'React hooks are functions that let you use state and lifecycle features in functional components. They are useful because they simplify code, make it more reusable, and eliminate the need for class components. Common hooks include useState, useEffect, and useContext.',
            'duration_seconds' => 150,
            'evaluation_json' => json_encode(['clarity' => 8, 'accuracy' => 8, 'completeness' => 7]),
            'score' => 7.7,
        ]);

        $question2_2 = InterviewQuestion::create([
            'interview_session_id' => $session2->id,
            'question_text' => 'Create a custom React hook for fetching data from an API.',
            'question_type' => 'code',
            'difficulty' => 4,
        ]);

        InterviewAnswer::create([
            'interview_question_id' => $question2_2->id,
            'answer_text' => "function useFetch(url) {\n  const [data, setData] = useState(null);\n  const [loading, setLoading] = useState(true);\n  const [error, setError] = useState(null);\n\n  useEffect(() => {\n    fetch(url)\n      .then(res => res.json())\n      .then(setData)\n      .catch(setError)\n      .finally(() => setLoading(false));\n  }, [url]);\n\n  return { data, loading, error };\n}",
            'duration_seconds' => 360,
            'evaluation_json' => json_encode(['correctness' => 8, 'efficiency' => 7, 'code_quality' => 8]),
            'score' => 7.7,
        ]);

        $question2_3 = InterviewQuestion::create([
            'interview_session_id' => $session2->id,
            'question_text' => 'How do you handle tight deadlines and pressure?',
            'question_type' => 'behavioral',
            'difficulty' => 2,
        ]);

        InterviewAnswer::create([
            'interview_question_id' => $question2_3->id,
            'answer_text' => 'I prioritize tasks using the Eisenhower matrix, break down large tasks into smaller manageable chunks, and communicate proactively with stakeholders about realistic timelines. I also maintain focus by minimizing distractions and taking short breaks to stay productive.',
            'duration_seconds' => 180,
            'evaluation_json' => json_encode(['relevance' => 8, 'detail' => 8, 'impact' => 8]),
            'score' => 8.0,
        ]);

        // Create interview questions and answers for session 3
        $question3_1 = InterviewQuestion::create([
            'interview_session_id' => $session3->id,
            'question_text' => 'Explain the difference between SQL and NoSQL databases.',
            'question_type' => 'text',
            'difficulty' => 3,
        ]);

        InterviewAnswer::create([
            'interview_question_id' => $question3_1->id,
            'answer_text' => 'SQL databases are relational, use structured schemas, and support ACID transactions. They are good for complex queries. NoSQL databases are non-relational, schema-flexible, and horizontally scalable. They excel at handling large volumes of unstructured data. Examples: SQL - PostgreSQL, MySQL; NoSQL - MongoDB, Redis.',
            'duration_seconds' => 200,
            'evaluation_json' => json_encode(['clarity' => 9, 'accuracy' => 8, 'completeness' => 8]),
            'score' => 8.3,
        ]);

        $question3_2 = InterviewQuestion::create([
            'interview_session_id' => $session3->id,
            'question_text' => 'Write a Python function to implement a simple rate limiter.',
            'question_type' => 'code',
            'difficulty' => 5,
        ]);

        InterviewAnswer::create([
            'interview_question_id' => $question3_2->id,
            'answer_text' => "from collections import deque\nimport time\n\nclass RateLimiter:\n    def __init__(self, max_requests, time_window):\n        self.max_requests = max_requests\n        self.time_window = time_window\n        self.requests = deque()\n    \n    def allow_request(self):\n        now = time.time()\n        while self.requests and self.requests[0] < now - self.time_window:\n            self.requests.popleft()\n        \n        if len(self.requests) < self.max_requests:\n            self.requests.append(now)\n            return True\n        return False",
            'duration_seconds' => 480,
            'evaluation_json' => json_encode(['correctness' => 9, 'efficiency' => 8, 'code_quality' => 8]),
            'score' => 8.3,
        ]);

        $question3_3 = InterviewQuestion::create([
            'interview_session_id' => $session3->id,
            'question_text' => 'Describe a time when you had to learn a new technology quickly.',
            'question_type' => 'behavioral',
            'difficulty' => 2,
        ]);

        InterviewAnswer::create([
            'interview_question_id' => $question3_3->id,
            'answer_text' => 'When our team decided to adopt Docker, I had one week to learn it before a major deployment. I created a learning plan: watched tutorials, read documentation, built sample projects, and practiced daily. I also joined online communities for help. Within a week, I successfully containerized our application.',
            'duration_seconds' => 210,
            'evaluation_json' => json_encode(['relevance' => 8, 'detail' => 8, 'impact' => 8]),
            'score' => 8.0,
        ]);

        $this->command->info('Interview questions and answers created!');

        // Create feedbacks
        Feedback::create([
            'resume_id' => $resume1->id,
            'interview_session_id' => $session1->id,
            'feedback_text' => "Excellent performance! Your technical knowledge is strong, particularly in Laravel and system architecture. Your code solutions were efficient and well-structured. For improvement, consider:\n- Providing more real-world examples in behavioral questions\n- Discussing trade-offs when proposing solutions\n- Adding more details about team collaboration",
            'categories' => json_encode(['technical' => 9, 'behavioral' => 8, 'coding' => 9]),
        ]);

        Feedback::create([
            'resume_id' => $resume2->id,
            'interview_session_id' => $session2->id,
            'feedback_text' => "Good interview overall! Your React knowledge is solid and you demonstrated practical understanding. Areas for improvement:\n- Deepen knowledge of advanced React patterns\n- Practice more complex coding challenges\n- Elaborate more on project impacts and metrics\n- Improve communication clarity in technical explanations",
            'categories' => json_encode(['technical' => 8, 'behavioral' => 8, 'coding' => 7]),
        ]);

        Feedback::create([
            'resume_id' => $resume3->id,
            'interview_session_id' => $session3->id,
            'feedback_text' => "Very strong performance! Your backend expertise is evident, especially in Python and system design. The rate limiter implementation was impressive. Suggestions:\n- Discuss scalability considerations in more depth\n- Share more about monitoring and debugging practices\n- Provide metrics from past projects to quantify impact",
            'categories' => json_encode(['technical' => 9, 'behavioral' => 8, 'coding' => 8]),
        ]);

        $this->command->info('Feedbacks created!');

        $this->command->info('');
        $this->command->info('=== Database Seeding Complete! ===');
        $this->command->info('');
        $this->command->info('Users created:');
        $this->command->info('  Admin: admin@resumentor.local / password');
        $this->command->info('  User 1: john@example.com / password');
        $this->command->info('  User 2: jane@example.com / password');
        $this->command->info('  User 3: michael@example.com / password');
        $this->command->info('');
        $this->command->info('Data created:');
        $this->command->info('  - 4 Users');
        $this->command->info('  - 30 Skill Tags');
        $this->command->info('  - 3 Resumes');
        $this->command->info('  - 3 Resume Analyses');
        $this->command->info('  - 3 Interview Sessions');
        $this->command->info('  - 9 Interview Questions');
        $this->command->info('  - 9 Interview Answers');
        $this->command->info('  - 3 Feedbacks');
        $this->command->info('');
    }
}
