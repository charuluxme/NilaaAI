-- ================================================
-- Nilaa AI Complete Database Schema
-- ================================================
-- MySQL 8 / InnoDB
-- Character Set: utf8mb4_unicode_ci
-- Generated for Laravel 10
-- Created: October 26, 2025
-- ================================================

-- ================================================
-- DATABASE SETUP
-- ================================================

-- Create database if it doesn't exist
CREATE DATABASE IF NOT EXISTS `nilaa` 
DEFAULT CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- Use the database
USE `nilaa`;

-- ================================================
-- PART 1: DATABASE SCHEMA
-- ================================================

-- Users Table
CREATE TABLE `users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `email_verified_at` TIMESTAMP NULL DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('user','admin') NOT NULL DEFAULT 'user',
  `avatar_path` VARCHAR(512) DEFAULT NULL,
  `remember_token` VARCHAR(100) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_index` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Resumes Table
CREATE TABLE `resumes` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `file_path` VARCHAR(512) NOT NULL,
  `original_filename` VARCHAR(255) NOT NULL,
  `mime_type` VARCHAR(100) DEFAULT NULL,
  `size_bytes` INT UNSIGNED DEFAULT 0,
  `uploaded_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `status` ENUM('uploaded','parsed','failed') NOT NULL DEFAULT 'uploaded',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` TIMESTAMP NULL DEFAULT NULL,
  KEY `resumes_user_id_index` (`user_id`),
  KEY `resumes_status_index` (`status`),
  CONSTRAINT `fk_resumes_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Resume Analyses Table
CREATE TABLE `resume_analyses` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `resume_id` BIGINT UNSIGNED NOT NULL,
  `extracted_text` LONGTEXT,
  `skills_json` JSON DEFAULT NULL,
  `ats_score` INT UNSIGNED DEFAULT NULL,
  `readability_score` FLOAT DEFAULT NULL,
  `suggestions` LONGTEXT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `resume_analyses_resume_id_index` (`resume_id`),
  CONSTRAINT `fk_resume_analyses_resume` FOREIGN KEY (`resume_id`) REFERENCES `resumes`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Interview Sessions Table
CREATE TABLE `interview_sessions` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `resume_id` BIGINT UNSIGNED NOT NULL,
  `role_applied` VARCHAR(255) DEFAULT NULL,
  `started_at` TIMESTAMP NULL DEFAULT NULL,
  `completed_at` TIMESTAMP NULL DEFAULT NULL,
  `overall_score` FLOAT DEFAULT NULL,
  `session_metadata` JSON DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `interview_sessions_resume_id_index` (`resume_id`),
  CONSTRAINT `fk_interview_sessions_resume` FOREIGN KEY (`resume_id`) REFERENCES `resumes`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Interview Questions Table
CREATE TABLE `interview_questions` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `interview_session_id` BIGINT UNSIGNED NOT NULL,
  `question_text` TEXT NOT NULL,
  `question_type` ENUM('text','code','behavioral') NOT NULL DEFAULT 'text',
  `difficulty` TINYINT UNSIGNED NOT NULL DEFAULT 3,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `interview_questions_session_id_index` (`interview_session_id`),
  CONSTRAINT `fk_interview_questions_session` FOREIGN KEY (`interview_session_id`) REFERENCES `interview_sessions`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Interview Answers Table
CREATE TABLE `interview_answers` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `interview_question_id` BIGINT UNSIGNED NOT NULL,
  `answer_text` LONGTEXT DEFAULT NULL,
  `answer_audio_path` VARCHAR(512) DEFAULT NULL,
  `duration_seconds` INT UNSIGNED DEFAULT NULL,
  `evaluation_json` JSON DEFAULT NULL,
  `score` FLOAT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `interview_answers_question_id_index` (`interview_question_id`),
  CONSTRAINT `fk_interview_answers_question` FOREIGN KEY (`interview_question_id`) REFERENCES `interview_questions`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Feedbacks Table
CREATE TABLE `feedbacks` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `resume_id` BIGINT UNSIGNED NOT NULL,
  `interview_session_id` BIGINT UNSIGNED DEFAULT NULL,
  `feedback_text` LONGTEXT NOT NULL,
  `categories` JSON DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `feedbacks_resume_id_index` (`resume_id`),
  CONSTRAINT `fk_feedbacks_resume` FOREIGN KEY (`resume_id`) REFERENCES `resumes`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_feedbacks_interview_session` FOREIGN KEY (`interview_session_id`) REFERENCES `interview_sessions`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Skill Tags Table
CREATE TABLE `skill_tags` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(191) NOT NULL,
  `canonical_name` VARCHAR(191) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `skill_tags_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Resume Skill Tag Pivot Table
CREATE TABLE `resume_skill_tag` (
  `resume_id` BIGINT UNSIGNED NOT NULL,
  `skill_tag_id` BIGINT UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`resume_id`,`skill_tag_id`),
  KEY `resume_skill_tag_resume_id_index` (`resume_id`),
  KEY `resume_skill_tag_skill_tag_id_index` (`skill_tag_id`),
  CONSTRAINT `fk_resume_skill_tag_resume` FOREIGN KEY (`resume_id`) REFERENCES `resumes`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_resume_skill_tag_skill_tag` FOREIGN KEY (`skill_tag_id`) REFERENCES `skill_tags`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ================================================
-- PART 2: SAMPLE DATA
-- ================================================

-- Note: Password for both users is 'password' (plain text for development)
INSERT INTO `users` (`name`, `email`, `password`, `role`, `email_verified_at`) VALUES
('Admin User', 'admin@nilaaai.local', 'password', 'admin', NOW()),
('Demo User', 'demo@nilaaai.local', 'password', 'user', NOW());

-- ================================================
-- PART 3: USEFUL VIEWS
-- ================================================

-- View: Resume summary with analysis
CREATE OR REPLACE VIEW v_resume_summary AS
SELECT 
    r.id as resume_id,
    r.user_id,
    u.email as user_email,
    r.original_filename,
    r.status,
    r.uploaded_at,
    ra.ats_score,
    ra.readability_score,
    GROUP_CONCAT(DISTINCT st.canonical_name ORDER BY st.canonical_name SEPARATOR ', ') as skills
FROM resumes r
LEFT JOIN users u ON r.user_id = u.id
LEFT JOIN resume_analyses ra ON r.id = ra.resume_id
LEFT JOIN resume_skill_tag rst ON r.id = rst.resume_id
LEFT JOIN skill_tags st ON rst.skill_tag_id = st.id
GROUP BY r.id, r.user_id, u.email, r.original_filename, r.status, r.uploaded_at, ra.ats_score, ra.readability_score;

-- View: Interview performance
CREATE OR REPLACE VIEW v_interview_performance AS
SELECT 
    i.id as session_id,
    i.resume_id,
    i.role_applied,
    i.started_at,
    i.completed_at,
    i.overall_score,
    COUNT(q.id) as total_questions,
    COUNT(a.id) as answered_questions,
    ROUND(AVG(a.score), 2) as avg_answer_score
FROM interview_sessions i
LEFT JOIN interview_questions q ON i.id = q.interview_session_id
LEFT JOIN interview_answers a ON q.id = a.interview_question_id
GROUP BY i.id, i.resume_id, i.role_applied, i.started_at, i.completed_at, i.overall_score;
