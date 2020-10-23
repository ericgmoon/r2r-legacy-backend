-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 05, 2019 at 05:04 AM
-- Server version: 5.6.45-cll-lve
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_gse`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'arshad', 'arshad.ozit@gmail.com', '$2y$10$jFj7g2NPeTo6uuqDOW6gZO0lG3vJiPF/h6BZCSCtPgWdia5o1jJfO', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Overview', 'uploads/overview.png', NULL, NULL),
(2, '1. Work at Heights', 'uploads/work_at_height.png', NULL, NULL),
(3, '2. Mobile Plant', 'uploads/mobile_plant.png', NULL, NULL),
(4, '3. Traffic and Light Vehicles', 'uploads/traffic_and_light_vehicles.png', NULL, NULL),
(5, '4. Cranes and Lifting', 'uploads/cranes.png', NULL, NULL),
(6, '5. Electrical', 'uploads/electrical.png', NULL, NULL),
(7, '6. Excavation and Trenching', 'uploads/excavation.png', NULL, NULL),
(8, '7. Temporary Works', 'uploads/temporary.png', NULL, NULL),
(9, '8. Tunnelling', 'uploads/tunnelling.png', NULL, NULL),
(10, '9. Compressed Air Tunnelling', 'uploads/compressed.png', NULL, NULL),
(11, '10. Energy Isolation', 'uploads/energy.png', NULL, NULL),
(12, '11. Utilities', 'uploads/utilities.png', NULL, NULL),
(13, '12. Fitness for Work', 'uploads/fitness.png', NULL, NULL),
(14, 'Glossary', 'uploads/glossary.png', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `descriptions`
--

CREATE TABLE `descriptions` (
  `id` int(10) UNSIGNED NOT NULL,
  `cat_id` int(11) NOT NULL,
  `subcat_id` int(11) NOT NULL,
  `desp` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `section` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `descriptions`
--

INSERT INTO `descriptions` (`id`, `cat_id`, `subcat_id`, `desp`, `section`, `created_at`, `updated_at`) VALUES
(1, 2, 8, '<p>Work at heights shall be eliminated where practicable, and where not practicable, the work must be controlled via the application of the hierarchy of risk control as follows:</p>\r\n\r\n<ol>\r\n	<li>&nbsp;Provision and maintenance of a stable and securely fenced work platform i.e. scaffolding or elevated&nbsp;work platform;</li>\r\n	<li>&nbsp;Secure perimeter screens, fencing, handrails or other forms of physical barriers that are capable of&nbsp;&nbsp;preventing the fall of a person; or</li>\r\n	<li>Other forms of physical restraints that are capable of arresting the &nbsp;fall of a person.&nbsp;</li>\r\n</ol>', '1.1', NULL, '2019-11-04 13:46:52'),
(2, 2, 8, 'Work at heights associated with loading and unloading of trucks shall \r\nbe controlled in accordance with the hierarchy of risk control. Where \r\npracticable, loads shall be pre-slung and accessible from ground or \r\nmechanical methods used which eliminate persons working at height.  \r\nIf not practicable, ensure persons are located on a fully fenced platform  \r\nor the truck platform is encapsulated with a suitable handrail system\r\n', '1.2', NULL, NULL),
(3, 2, 8, 'Suspended work areas must be adequately protected to prevent the risk \r\nof falling objects striking a person inclusive of providing and maintaining \r\nsteel mesh panel fencing, suitable barriers or screening and/or adequately \r\nestablishing demarcated exclusion zones\r\n', '1.3', NULL, NULL),
(4, 2, 10, 'Penetrations and openings through which a person could fall shall be \r\nadequately protected with suitable fencing or penetration covers immediately \r\nafter being formed. Penetration covers shall be adequately fixed to prevent \r\ndisplacement or dislodgement and their design and installation verified \r\nin writing by a suitably qualified Engineer in accordance with the BYCA \r\nTemporary Works Procedure.\r\n', '1.4', NULL, NULL),
(5, 2, 10, 'Construction work on roofs shall only be undertaken where the roof is fully \r\nencapsulated by either scaffold or a proprietary guardrail system, and the \r\ninterior of the roof is protected by steel wire safety mesh as per relevant \r\nregulatory requirements.\r\n', '1.5', NULL, NULL),
(6, 2, 9, 'Elevating Work Platforms (EWPs) shall be operated and maintained by a \r\ncompetent person in accordance with manufacturer’s recommendations  \r\ndetailed in the OEM Manual and AS 2550.10.\r\n', '1.6', NULL, NULL),
(7, 2, 9, 'EWP operators shall undertake an assessment of ground conditions and slope \r\nprior to operation of the EWP and where there is any change in site location  \r\nor ground conditions. Where fitted, outriggers and self-levelling systems must  \r\nbe utilised\r\n', '1.7', NULL, NULL),
(8, 2, 9, 'Suitable controls must be implemented to mitigate the risk of a crush injury \r\ninvolving stationary objects while working on a EWP. Controls may include \r\nphysical barriers and/or an electronic detection systems.\r\n', '1.8', NULL, NULL),
(9, 2, 9, 'Telescopic boom type EWPs must be operated by an authorised person holding  \r\na National Licence to Perform High Risk Work Class Boom-Type Elevating Work \r\nPlatform Operation (WP), and scissor lifts must be operated by a competent \r\nperson who holds an Elevating Work Platform Association of Australia (EWPA) \r\nYellow Card qualification\r\n', '1.9', NULL, NULL),
(10, 2, 9, 'Operators of Boom Type EWPs shall wear an AS compliant lanyard and harness \r\nconnected to a dedicated anchor point located in the operator’s basket or \r\nplatform.\r\n', '1.10', NULL, NULL),
(11, 2, 11, ' The use of ladders (other than platform ladders) as a work platform is \r\nprohibited. Ladders must only be used for access and egress where:\r\ni. Other means of access are not practicable (e.g. scaffold stair  \r\ntower or EWP); and\r\nii. Its use is limited to personnel access and an alternate means of \r\nemergency egress is provided.\r\n', '1.11', NULL, NULL),
(12, 2, 11, ' Ladders shall only be used for access & egress when their use is  \r\napproved by the responsible BYCA Superintendent. Ladders must be:\r\ni. Secured in a lockable storage area only accessible by  \r\nnominated persons;\r\nii. Be located at a 4 (vertical):1 (horizontal) slope;\r\niii. Be industrial grade;\r\niv. Extend 1 metre above landing;\r\nv. Not extend greater than 6 metres between ladder landings;\r\nvi. Be secured against displacement or dislodgement;\r\nvii. Be used in a head to toe configuration (i.e. scaffold access); and\r\nviii. Be located in a dedicated access bay where practicable, and the  \r\nladder aperture is suitably protected by a cover or physical barrier.\r\n', '1.12', NULL, NULL),
(13, 2, 12, '1.13 Fall arrest devices must only be used:\r\ni. When BYCA issues a Fall Arrest Permit (other than for use on a  \r\nBoom Type EWP);\r\nii. When it is utilised in a fall prevention configuration as opposed to  \r\na fall arrest configuration (i.e. system prevents person falling beyond  \r\nthe edge of the work platform); and\r\niii. In a fall arrest configuration where authorised by the BYCA Project Mgr.  \r\nand where personnel have been suitably trained in their use including \r\nemergency rescue.\r\n', '1.13', NULL, NULL),
(14, 2, 12, 'The design and installation of anchor points used as part of a fall  \r\narrest system must:\r\ni. Comply with AS/NZS 1891.4; and\r\nii. Be designed and implemented in accordance with a Temporary Works \r\nDesign (TWD) which has been certified in writing by an IPSE prior to  \r\ninitial use and at the nominated inspection intervals.\r\n', '1.14', NULL, NULL),
(15, 2, 12, 'Anchor points shall be designed to a minimum of 15kN ultimate strength  \r\nfor one person and 21kN for two persons.\r\n', '1.15', NULL, NULL),
(16, 2, 12, 'Installation of anchor points and static line systems shall be undertaken by       \r\nauthorised persons who hold a National Licence to Perform High Risk Work \r\nClass Basic Rigging (RB) or Basic Scaffolding (SB) or above.\r\n', '1.16', NULL, NULL),
(17, 2, 12, 'All Fall Arrest devices shall be inspected by a competent person quarterly  \r\nand have a colour coded inspection tag affixed.\r\n', '1.17', NULL, NULL),
(18, 3, 13, 'People and plant shall be separated by physical barriers  \r\nwhere practicable.\r\n', '2.1', NULL, NULL),
(19, 3, 13, 'Where not practicable, control measures must be implemented to \r\nadequately isolate people from plant, including but not limited to  \r\nthe establishment of an exclusion zone for the plant’s maximum  \r\ndesign envelope/radius unless varied by an accepted Safe Work  \r\nMethod Statement (SWMS) authorised by the BYCA Project Mgr.\r\n', '2.2', NULL, NULL),
(20, 3, 13, 'People and plant shall have separate site access, including to  \r\nsite compounds.\r\n\r\n', '2.3', NULL, NULL),
(21, 3, 13, 'BYCA Project Mgr’s must implement suitable arrangements to  \r\nprevent the risk of mobile plant roll away and ensure plant is  \r\nparked on fundamentally stable ground wherever practicable.\r\n', '2.4', NULL, NULL),
(22, 3, 13, 'Work locations utilised for the loading and/or unloading of plant  \r\nor equipment must be adequately isolated to prevent access  \r\nby unauthorised personnel.\r\n', '2.5', NULL, NULL),
(23, 3, 14, 'Mobile plant and equipment must be operated, inspected, tested,  \r\nand maintained in a safe and adequate condition; be fit for purpose;  \r\nand comply with relevant Australian Standards and recommendations  \r\nof the manufacturer detailed in the OEM Manual.\r\n', '2.6', NULL, NULL),
(24, 3, 14, 'Project Directors are responsible to implement a system to monitor  \r\nplant preventative maintenance to ensure its undertaken in accordance with \r\nthe manufacturer’s recommendations\r\n', '2.7', NULL, NULL),
(25, 3, 14, 'Prior to undertaking work all incoming mobile plant must be verified by \r\nthe relevant subcontractor/supplier (primary verification) and the BYCA \r\nrepresentative (site acceptance) using the BYCA Plant Verification process. \r\n Where a defect is identified the plant item shall be parked in a safe location \r\nand locked with a “Do Not Operate” tag affixed (refer to GSE 10). The tag may \r\nonly be removed once remediation work has been completed and certified  \r\nin writing by a competent person.\r\n', '2.8', NULL, NULL),
(26, 3, 14, 'The following shall be provided to BYCA for each plant item at the time  \r\nof project on boarding:\r\ni. Plant Risk Assessment (PRA);\r\nii. Certificate of Plant Item Registration (where applicable);\r\niii. Original Equipment Manufacturer’s (OEM) Manual; and\r\niv. A dedicated log book detailing inspection, test, and maintenance  \r\nrecords for the previous 12 months.\r\n', '2.9', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(3, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(4, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(5, '2016_06_01_000004_create_oauth_clients_table', 1),
(6, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(7, '2019_01_10_070920_create_user_devices_table', 1),
(8, '2019_10_30_102206_create_categories_table', 2),
(9, '2019_10_30_102837_create_sub_categories_table', 3),
(10, '2019_10_30_113643_create_admins_table', 4),
(11, '2019_11_01_045655_create_descriptions_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('0684d7e834fd6c0cc5ed0620a5c894495b25eba7009340a3b4760dbb5174b09503d62890a916c3d8', 1, 1, 'MyApp', '[]', 0, '2019-11-04 17:36:14', '2019-11-04 17:36:14', '2020-11-04 10:36:14'),
('1512fee8a12f6346cc12c6f00e53369e9afaad07b5af912c833d64e7932daa4d45d47dc353f5a6e0', 1, 1, 'MyApp', '[]', 0, '2019-11-04 15:51:08', '2019-11-04 15:51:08', '2020-11-04 08:51:08'),
('46def151dd02d56dc21d77ca1721fd75525a5c7cee46d377bfcde847630f6cb2dde464007a84a41f', 1, 1, 'MyApp', '[]', 0, '2019-11-01 13:43:18', '2019-11-01 13:43:18', '2020-11-01 06:43:18'),
('6d920af2d155908099cf2db3435b97ce47bbc8c1d825fbfc96e041737648359d593379a5cc991350', 1, 1, 'MyApp', '[]', 0, '2019-11-04 15:58:27', '2019-11-04 15:58:27', '2020-11-04 08:58:27'),
('7ffc72189e308d5b8e66b13937c04d86bb817dd1d2caeeb78aad0c0bb60ae51013a23d230f087428', 1, 1, 'MyApp', '[]', 0, '2019-11-01 13:56:28', '2019-11-01 13:56:28', '2020-11-01 06:56:28'),
('9a56b0d029dd102b0322bd10784e5aa69f9b05c393388ac017f9b3abe13aaad79ab426d518f742d2', 1, 1, 'MyApp', '[]', 0, '2019-11-01 18:32:47', '2019-11-01 18:32:47', '2020-11-01 11:32:47'),
('a23af62bca956e28b89dfe2e56f3dc5f3a3b742044828761251887d39f9c0c18115b377647b11aab', 1, 1, 'MyApp', '[]', 0, '2019-11-01 17:00:38', '2019-11-01 17:00:38', '2020-11-01 10:00:38'),
('b4ceae97b235e5bf1b7fd2892892a11d2c799b57de422c7f810946b10a3757a628fab201a70fc506', 1, 1, 'MyApp', '[]', 0, '2019-11-01 19:50:07', '2019-11-01 19:50:07', '2020-11-01 12:50:07'),
('b51bcaf5b0f03c8808fa2227aaaa2ba91eb22229f56c7acf8b2a6567b8b1717177855ae76f9d879f', 1, 1, 'MyApp', '[]', 0, '2019-11-01 13:46:29', '2019-11-01 13:46:29', '2020-11-01 06:46:29'),
('b5c527169a1ec8d11cfb1ac08d641af70b804f3cf08846bc5169305bc3d30dd469a0b94aec6b6f1d', 1, 1, 'MyApp', '[]', 0, '2019-11-05 04:03:11', '2019-11-05 04:03:11', '2020-11-04 21:03:11'),
('e6bbe2bea94797ca1cb73805661ab8a06c6c08ae2fb4035d7a95affe127358d88047aae8b7057d7d', 1, 1, 'MyApp', '[]', 0, '2019-11-01 17:14:19', '2019-11-01 17:14:19', '2020-11-01 10:14:19'),
('e7adb0f3c01e3d2d321ced0b01c7b162916533988e554e3881b88ab3712fe482ef0e4f66d1962bec', 1, 1, 'MyApp', '[]', 0, '2019-10-30 04:49:36', '2019-10-30 04:49:36', '2020-10-30 10:19:36');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'GSE Personal Access Client', 'IAHzuxCc6RNtY7uZCRfeEqXP79lAMRQw5VWLbua0', 'http://localhost', 1, 0, 0, '2019-10-30 04:49:29', '2019-10-30 04:49:29');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2019-10-30 04:49:29', '2019-10-30 04:49:29');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `cat_id` int(11) NOT NULL,
  `sub_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `cat_id`, `sub_title`, `created_at`, `updated_at`) VALUES
(1, 1, 'Introduction', NULL, NULL),
(2, 1, 'Our Commitment', NULL, NULL),
(3, 1, 'The GES’s', NULL, NULL),
(4, 1, 'Safety Behaviours', NULL, NULL),
(5, 1, 'Personal Accountability', NULL, NULL),
(6, 1, 'Safety Leadership', NULL, NULL),
(7, 1, 'Acknowledgements', NULL, NULL),
(8, 2, 'Hierarchy of Risk Control', NULL, NULL),
(9, 2, 'Elevating  Work Platforms', NULL, NULL),
(10, 2, 'Safe Work on Roofs and Penetrations', NULL, NULL),
(11, 2, 'Ladders', NULL, NULL),
(12, 2, 'Fall Arrest Devices', NULL, NULL),
(13, 3, 'People and Plant Separation ', NULL, NULL),
(14, 3, 'Plant Onboarding', NULL, NULL),
(15, 3, 'Operational Controls', NULL, NULL),
(16, 3, 'Competency and Training', NULL, NULL),
(17, 4, 'People and Traffic Separation', NULL, NULL),
(18, 4, 'Operational controls', NULL, NULL),
(19, 4, 'Light Vehicles', NULL, NULL),
(20, 5, 'Crane Appointed Person', NULL, NULL),
(21, 5, 'Operational Controls', NULL, NULL),
(22, 5, 'Crane Lifts', NULL, NULL),
(23, 5, 'Competency and Training ', NULL, NULL),
(24, 6, 'Energised Electrical Equipment', NULL, NULL),
(25, 6, 'Operational Controls ', NULL, NULL),
(26, 7, 'Underground Utilities', NULL, NULL),
(27, 7, 'Operational Controls', NULL, NULL),
(28, 7, 'Access and Egress', NULL, NULL),
(29, 7, 'Inspection and Certification', NULL, NULL),
(30, 7, 'Competency and Training', NULL, NULL),
(31, 8, 'Temporary Works Engineer', NULL, NULL),
(32, 8, 'Inspection and Certification', NULL, NULL),
(33, 8, 'Operational Controls', NULL, NULL),
(34, 8, 'Scaffolding', NULL, NULL),
(35, 8, 'Competency and Training', NULL, NULL),
(36, 9, 'Permits', NULL, NULL),
(37, 9, 'Ground Support', NULL, NULL),
(38, 9, 'Ventilation and Hygiene', NULL, NULL),
(39, 9, 'Mobile Plant', NULL, NULL),
(40, 9, 'Drilling and Blasting', NULL, NULL),
(41, 9, 'Operational Controls', NULL, NULL),
(42, 9, 'Emergency Response', NULL, NULL),
(43, 9, 'Competency and Training', NULL, NULL),
(44, 10, 'Appointed Persons', NULL, NULL),
(45, 10, 'Permit Process', NULL, NULL),
(46, 10, 'Intervention Procedure', NULL, NULL),
(47, 10, 'Operational Controls', NULL, NULL),
(48, 11, 'Isolation, Lock Out and Tag Out', NULL, NULL),
(49, 11, 'Emergency Response', NULL, NULL),
(50, 12, 'Utilities Manager', NULL, NULL),
(51, 12, 'Live Services', NULL, NULL),
(52, 12, 'Underground Utilities', NULL, NULL),
(53, 12, 'Overhead Utilities', NULL, NULL),
(54, 12, 'Working in Proximity to Utilities', NULL, NULL),
(55, 13, 'Drugs and Alcohol', NULL, NULL),
(56, 13, 'Work Schedule Planning', NULL, NULL),
(57, 14, 'Acronyms and Definitions', NULL, NULL),
(58, 14, 'Definitions', NULL, NULL),
(59, 14, 'Definitions', NULL, NULL),
(60, 14, 'Definitions', NULL, NULL),
(61, 14, 'Definitions', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(119) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `org_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` mediumint(9) NOT NULL DEFAULT '1',
  `otp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0000',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `profile_image`, `password`, `org_password`, `active`, `otp`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'arshad', '123456@gmail.com', NULL, '$2y$10$fVLFrLOh92LAEspsuYqqx.JeD0SbyJXWri1u4QiZLYXmc.TfXHz9.', '123456', 1, '0000', NULL, '2019-10-30 04:37:23', '2019-10-30 04:37:23'),
(2, 'arshad', 'arshad2.ozit@gmail.com', NULL, '$2y$10$P/IBvRQMFICY57NaVeiat./ouclLuWEBTUqI73pcvUyhLQezH8Y0i', '$2y$10$P/IBvRQMFICY57NaVeiat./ouclLuWEBTUqI73pcvUyhLQezH8Y0i', 1, '0000', NULL, '2019-10-30 04:38:11', '2019-10-30 04:38:11'),
(3, 'arshad', 'arshad3.ozit@gmail.com', NULL, '$2y$10$jFj7g2NPeTo6uuqDOW6gZO0lG3vJiPF/h6BZCSCtPgWdia5o1jJfO', '123456', 1, '0000', NULL, '2019-10-30 04:39:09', '2019-10-30 04:39:09');

-- --------------------------------------------------------

--
-- Table structure for table `user_devices`
--

CREATE TABLE `user_devices` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `device_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_devices`
--

INSERT INTO `user_devices` (`id`, `user_id`, `device_type`, `device_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'abc', '13212323123123', '2019-10-30 04:49:37', '2019-10-30 04:49:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `descriptions`
--
ALTER TABLE `descriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_personal_access_clients_client_id_index` (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_devices`
--
ALTER TABLE `user_devices`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `descriptions`
--
ALTER TABLE `descriptions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_devices`
--
ALTER TABLE `user_devices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
