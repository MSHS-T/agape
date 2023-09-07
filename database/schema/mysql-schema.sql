/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `application_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `application_files` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `application_id` int unsigned NOT NULL,
  `order` tinyint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filepath` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `application_files_filepath_unique` (`filepath`),
  KEY `application_files_application_id_foreign` (`application_id`),
  CONSTRAINT `application_files_application_id_foreign` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `application_laboratory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `application_laboratory` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `application_id` int unsigned NOT NULL,
  `laboratory_id` int unsigned NOT NULL,
  `order` tinyint unsigned NOT NULL,
  `contact_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `application_laboratory_application_id_foreign` (`application_id`),
  KEY `application_laboratory_laboratory_id_foreign` (`laboratory_id`),
  CONSTRAINT `application_laboratory_application_id_foreign` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`),
  CONSTRAINT `application_laboratory_laboratory_id_foreign` FOREIGN KEY (`laboratory_id`) REFERENCES `laboratories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `application_study_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `application_study_field` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `application_id` int unsigned NOT NULL,
  `study_field_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `application_study_field_application_id_foreign` (`application_id`),
  KEY `application_study_field_study_field_id_foreign` (`study_field_id`),
  CONSTRAINT `application_study_field_application_id_foreign` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`),
  CONSTRAINT `application_study_field_study_field_id_foreign` FOREIGN KEY (`study_field_id`) REFERENCES `study_fields` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `applications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `applications` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `applicant_id` int unsigned NOT NULL,
  `projectcall_id` int unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acronym` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `carrier_id` int unsigned DEFAULT NULL,
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target_date` text COLLATE utf8mb4_unicode_ci,
  `theme` text COLLATE utf8mb4_unicode_ci,
  `summary_fr` text COLLATE utf8mb4_unicode_ci,
  `summary_en` text COLLATE utf8mb4_unicode_ci,
  `keywords` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `amount_requested` double(8,2) DEFAULT NULL,
  `other_fundings` double(8,2) DEFAULT NULL,
  `total_expected_income` double(8,2) DEFAULT NULL,
  `total_expected_outcome` double(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `submitted_at` timestamp NULL DEFAULT NULL,
  `other_laboratories` text COLLATE utf8mb4_unicode_ci,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `devalidation_message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `selection_comity_opinion` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `applications_reference_unique` (`reference`),
  KEY `applications_applicant_id_foreign` (`applicant_id`),
  KEY `applications_projectcall_id_foreign` (`projectcall_id`),
  KEY `applications_carrier_id_foreign` (`carrier_id`),
  CONSTRAINT `applications_applicant_id_foreign` FOREIGN KEY (`applicant_id`) REFERENCES `users` (`id`),
  CONSTRAINT `applications_carrier_id_foreign` FOREIGN KEY (`carrier_id`) REFERENCES `persons` (`id`),
  CONSTRAINT `applications_projectcall_id_foreign` FOREIGN KEY (`projectcall_id`) REFERENCES `project_calls` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `evaluation_offers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `evaluation_offers` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `application_id` int unsigned NOT NULL,
  `creator_id` int unsigned NOT NULL,
  `expert_id` int unsigned DEFAULT NULL,
  `accepted` tinyint(1) DEFAULT NULL,
  `justification` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `invitation_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `retry_history` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '[]',
  PRIMARY KEY (`id`),
  KEY `evaluation_offers_application_id_foreign` (`application_id`),
  KEY `evaluation_offers_creator_id_foreign` (`creator_id`),
  KEY `evaluation_offers_expert_id_foreign` (`expert_id`),
  KEY `evaluation_offers_invitation_code_foreign` (`invitation_code`),
  CONSTRAINT `evaluation_offers_application_id_foreign` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`),
  CONSTRAINT `evaluation_offers_creator_id_foreign` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`),
  CONSTRAINT `evaluation_offers_expert_id_foreign` FOREIGN KEY (`expert_id`) REFERENCES `users` (`id`),
  CONSTRAINT `evaluation_offers_invitation_code_foreign` FOREIGN KEY (`invitation_code`) REFERENCES `invitations` (`invitation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `evaluations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `evaluations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `offer_id` int unsigned NOT NULL,
  `grade1` smallint unsigned DEFAULT NULL,
  `comment1` text COLLATE utf8mb4_unicode_ci,
  `grade2` smallint unsigned DEFAULT NULL,
  `comment2` text COLLATE utf8mb4_unicode_ci,
  `grade3` smallint unsigned DEFAULT NULL,
  `comment3` text COLLATE utf8mb4_unicode_ci,
  `global_grade` smallint unsigned DEFAULT NULL,
  `global_comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `submitted_at` timestamp NULL DEFAULT NULL,
  `devalidation_message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `evaluations_offer_id_foreign` (`offer_id`),
  CONSTRAINT `evaluations_offer_id_foreign` FOREIGN KEY (`offer_id`) REFERENCES `evaluation_offers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `invitations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invitations` (
  `invitation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`invitation`),
  UNIQUE KEY `invitations_invitation_unique` (`invitation`),
  UNIQUE KEY `invitations_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `laboratories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `laboratories` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `director_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `regency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creator_id` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `laboratories_creator_id_foreign` (`creator_id`),
  CONSTRAINT `laboratories_creator_id_foreign` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `persons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `persons` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_workshop` tinyint(1) NOT NULL DEFAULT '0',
  `creator_id` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `persons_creator_id_foreign` (`creator_id`),
  CONSTRAINT `persons_creator_id_foreign` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `project_call_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_call_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label_long` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label_short` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_workshop` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `project_calls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_calls` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `project_call_type_id` bigint unsigned NOT NULL,
  `year` smallint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `application_start_date` date NOT NULL,
  `application_end_date` date NOT NULL,
  `evaluation_start_date` date NOT NULL,
  `evaluation_end_date` date NOT NULL,
  `number_of_experts` tinyint unsigned NOT NULL,
  `number_of_documents` tinyint unsigned NOT NULL,
  `privacy_clause` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `invite_email_fr` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `invite_email_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `help_experts` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `help_candidates` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `creator_id` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `number_of_keywords` tinyint unsigned NOT NULL,
  `number_of_laboratories` tinyint unsigned NOT NULL,
  `number_of_study_fields` tinyint unsigned NOT NULL,
  `number_of_target_dates` tinyint unsigned DEFAULT NULL,
  `application_form_filepath` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `financial_form_filepath` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notation_1_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Qualité et ambition scientifique du projet',
  `notation_1_description` varchar(3000) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '<ul><li>Clarté des objectifs et des hypothèses de recherche</li><li>Caractère interdisciplinaire du projet et effet structurant</li><li>Caractère novateur, originalité, progrès par rapport à l''état de l''art</li><li>Faisabilité notamment au regard des méthodes, gestion des risques scientifiques</li></ul>',
  `notation_2_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Organisation du projet et moyens mis en oeuvre',
  `notation_2_description` varchar(3000) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '<ul><li>Compétence, expertise et implication du coordinateur scientfiique et des partenaires</li><li>Qualité et complémentarité de l''équipe, qualité de la collaboration</li><li>Adéquation aux objectifs des moyens mis en oeuvre et demandés (cohérence du projet)</li></ul>',
  `notation_3_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Impact et retombées du projet',
  `notation_3_description` varchar(3000) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '<ul><li>Impact scientifique, social, économique ou culturel</li><li>Capacité du projet à répondre aux enjeux de recherche, acquisitions de nouvelles connaissances et de savoir-faire</li><li>Stratégie de diffusion et de valorisation des résultats</li></ul>',
  PRIMARY KEY (`id`),
  UNIQUE KEY `project_calls_reference_unique` (`reference`),
  KEY `project_calls_creator_id_foreign` (`creator_id`),
  KEY `project_calls_project_call_type_id_foreign` (`project_call_type_id`),
  CONSTRAINT `project_calls_creator_id_foreign` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`),
  CONSTRAINT `project_calls_project_call_type_id_foreign` FOREIGN KEY (`project_call_type_id`) REFERENCES `project_call_types` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`key`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `study_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `study_fields` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creator_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `study_fields_creator_id_foreign` (`creator_id`),
  CONSTRAINT `study_fields_creator_id_foreign` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` tinyint unsigned NOT NULL DEFAULT '0',
  `role_type_id` bigint unsigned DEFAULT NULL,
  `invited` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_type_id_foreign` (`role_type_id`),
  CONSTRAINT `users_role_type_id_foreign` FOREIGN KEY (`role_type_id`) REFERENCES `project_call_types` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1,'2014_10_12_000000_create_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2,'2014_10_12_100000_create_password_resets_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3,'2018_12_11_151058_create_project_calls_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4,'2018_12_11_155714_create_settings_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (5,'2018_12_11_160507_create_study_fields_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (6,'2018_12_11_160517_create_laboratories_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (7,'2018_12_11_160630_create_persons_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (8,'2018_12_11_161022_create_applications_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (9,'2018_12_11_164714_create_application_files_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (10,'2018_12_11_164930_create_application_laboratory_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (11,'2018_12_11_165121_create_application_study_field_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (12,'2018_12_11_165329_create_evaluation_offers_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (13,'2018_12_11_165543_create_evaluations_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (14,'2019_02_14_142109_add_contact_name_to_laboratories_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (15,'2019_02_14_143503_alter_target_date_on_applications_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (16,'2019_02_18_125559_alter_persons_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (17,'2019_02_18_125952_alter_laboratories_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (18,'2019_03_17_173443_move_contact_name_to_application_laboratories',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (19,'2019_03_21_124550_add_fields_to_projectcall_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (20,'2019_03_21_132627_add_other_laboratories_field_to_applications_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (21,'2019_03_21_133132_add_creator_foreign_key_to_study_fields_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (22,'2019_03_29_152206_add_files_to_project_calls_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (23,'2019_04_01_152920_update_evaluations_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (24,'2019_04_02_100501_add_invitations_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (25,'2019_04_02_105517_alter_users_table_to_soft_delete',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (26,'2019_05_07_133530_set_project_call_title_nullable',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (27,'2019_06_11_160623_add_reference_fields',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (28,'2019_12_14_000001_create_personal_access_tokens_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (29,'2020_04_03_110150_add_devalidation_message_to_applications_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (30,'2020_04_03_114955_fixes_default_keywords_value',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (31,'2020_04_03_153834_add_devalidation_message_to_evaluations_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (32,'2020_04_14_120920_add_selection_comity_opinion_to_applications_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (33,'2020_04_14_155612_add_invitation_code_to_evaluation_offers_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (34,'2020_07_24_112111_alter_applications_table_to_increase_field_length',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (35,'2021_01_24_164232_add_retry_history_column_to_evaluation_offers_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (36,'2021_01_24_165501_alter_justification_column_of_evaluation_offers_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (37,'2022_09_20_161410_create_project_call_types_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (38,'2022_09_20_162624_alter_project_calls_table_to_manage_fk_call_type',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (39,'2022_10_02_113532_add_role_type_to_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (40,'2022_10_02_114237_alter_role_column_on_invitations_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (41,'2022_10_17_194237_add_notation_guide_on_project_calls_table',1);
