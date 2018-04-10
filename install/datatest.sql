-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2018 at 06:19 PM
-- Server version: 10.1.24-MariaDB
-- PHP Version: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `datatest`
--

-- --------------------------------------------------------

--
-- Table structure for table `api_token`
--

CREATE TABLE `api_token` (
  `id` int(11) UNSIGNED NOT NULL,
  `token` varchar(300) DEFAULT NULL,
  `activity_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `atm_estate`
--

CREATE TABLE `atm_estate` (
  `atm_estate_id` int(121) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `atm_estate_bank_name` varchar(255) DEFAULT NULL,
  `atm_estate_quantity` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `atm_estate`
--

INSERT INTO `atm_estate` (`atm_estate_id`, `user_id`, `atm_estate_bank_name`, `atm_estate_quantity`) VALUES
(1, '1', 'Unity Bank', '12');

-- --------------------------------------------------------

--
-- Table structure for table `cf_values`
--

CREATE TABLE `cf_values` (
  `cf_values_id` int(11) UNSIGNED NOT NULL,
  `rel_crud_id` int(11) DEFAULT NULL,
  `cf_id` int(11) DEFAULT NULL,
  `curd` varchar(250) DEFAULT NULL,
  `value` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `custom_fields`
--

CREATE TABLE `custom_fields` (
  `custom_fields_id` int(11) UNSIGNED NOT NULL,
  `rel_crud` varchar(250) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `type` varchar(250) DEFAULT NULL,
  `required` int(11) DEFAULT NULL,
  `options` varchar(250) DEFAULT NULL,
  `status` varchar(250) DEFAULT NULL,
  `show_in_grid` int(11) DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `engineer_details`
--

CREATE TABLE `engineer_details` (
  `engineer_details_id` int(121) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `engineer_details_engineer_first_name_` varchar(255) DEFAULT NULL,
  `engineer_details_engineer_last_name` varchar(255) DEFAULT NULL,
  `engineer_details_engineer_email` varchar(255) DEFAULT NULL,
  `engineer_details_engineer_number` varchar(255) DEFAULT NULL,
  `engineer_details_location` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `engineer_details`
--

INSERT INTO `engineer_details` (`engineer_details_id`, `user_id`, `engineer_details_engineer_first_name_`, `engineer_details_engineer_last_name`, `engineer_details_engineer_email`, `engineer_details_engineer_number`, `engineer_details_location`) VALUES
(1, '1', 'Paul', 'Oluyege', 'pauloluyege@gmail.com', '(+234) 806- 8492563', 'Lagos'),
(2, '1', 'Altara', 'Credits', 'altara@altaracredits.com', '1221211', 'Abuja');

-- --------------------------------------------------------

--
-- Table structure for table `fault_calls`
--

CREATE TABLE `fault_calls` (
  `fault_calls_id` int(121) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `fault_calls_engineer_name` varchar(255) DEFAULT NULL,
  `fault_calls_bank_name` varchar(255) DEFAULT NULL,
  `fault_calls_terminal_id` varchar(255) DEFAULT NULL,
  `fault_calls_terminal_name` varchar(255) DEFAULT NULL,
  `fault_calls_terminal_location` varchar(255) DEFAULT NULL,
  `fault_calls_fault_description` varchar(255) DEFAULT NULL,
  `fault_calls_error_code` varchar(255) DEFAULT NULL,
  `fault_calls_date_logged` varchar(255) DEFAULT NULL,
  `fault_calls_time_loggged` varchar(255) DEFAULT NULL,
  `fault_calls_status` varchar(255) DEFAULT NULL,
  `fault_calls_date_resolved` varchar(255) DEFAULT NULL,
  `fault_calls_time_resolved` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `id` int(122) UNSIGNED NOT NULL,
  `user_type` varchar(250) DEFAULT NULL,
  `data` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`id`, `user_type`, `data`) VALUES
(1, 'admin', '{\"user\":\"user\",\"fault_calls\":{\"all_read\":\"1\"},\"atm_estate\":{\"all_read\":\"1\"},\"engineer_details\":{\"all_read\":\"1\"}}'),
(2, 'admin', '{\"user\":\"user\",\"fault_calls\":{\"all_read\":\"1\"},\"atm_estate\":{\"all_read\":\"1\"},\"engineer_details\":{\"all_read\":\"1\"}}'),
(3, 'user', '{\"user\":\"user\",\"fault_calls\":\"fault_calls\",\"atm_estate\":\"atm_estate\",\"engineer_details\":\"engineer_details\"}'),
(4, 'Admin', '{\"user\":\"user\",\"fault_calls\":{\"all_read\":\"1\"},\"atm_estate\":{\"all_read\":\"1\"},\"engineer_details\":{\"all_read\":\"1\"}}'),
(6, 'Userr', '{\"user\":\"user\",\"fault_calls\":\"fault_calls\",\"atm_estate\":{\"all_read\":\"1\"},\"engineer_details\":{\"all_read\":\"1\"}}');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(122) UNSIGNED NOT NULL,
  `keys` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `keys`, `value`) VALUES
(1, 'website', 'Custom Project'),
(2, 'logo', 'logo.png'),
(3, 'favicon', 'favicon.ico'),
(4, 'SMTP_EMAIL', ''),
(5, 'HOST', ''),
(6, 'PORT', ''),
(7, 'SMTP_SECURE', ''),
(8, 'SMTP_PASSWORD', ''),
(9, 'mail_setting', 'simple_mail'),
(10, 'company_name', 'Company Name'),
(11, 'crud_list', 'User,Fault Calls,ATM Estate,Engineer Details'),
(12, 'EMAIL', ''),
(13, 'UserModules', 'yes'),
(14, 'register_allowed', '1'),
(15, 'email_invitation', '1'),
(16, 'admin_approval', '1'),
(17, 'language', 'english'),
(18, 'user_type', '[\"user\"]'),
(19, 'date_formate', ''),
(20, 'api_status', 'disabled'),
(21, 'api_key', ''),
(22, 'token_expiration', '20');

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE `templates` (
  `id` int(121) UNSIGNED NOT NULL,
  `module` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `template_name` varchar(255) DEFAULT NULL,
  `html` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`id`, `module`, `code`, `template_name`, `html`) VALUES
(1, 'forgot_pass', 'forgot_password', 'Forgot password', '<html xmlns=\"http://www.w3.org/1999/xhtml\"><head>\r\n  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\r\n  <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">\r\n  <style type=\"text/css\" rel=\"stylesheet\" media=\"all\">\r\n    /* Base ------------------------------ */\r\n    *:not(br):not(tr):not(html) {\r\n      font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;\r\n      -webkit-box-sizing: border-box;\r\n      box-sizing: border-box;\r\n    }\r\n    body {\r\n      \r\n    }\r\n    a {\r\n      color: #3869D4;\r\n    }\r\n\r\n\r\n    /* Masthead ----------------------- */\r\n    .email-masthead {\r\n      padding: 25px 0;\r\n      text-align: center;\r\n    }\r\n    .email-masthead_logo {\r\n      max-width: 400px;\r\n      border: 0;\r\n    }\r\n    .email-footer {\r\n      width: 570px;\r\n      margin: 0 auto;\r\n      padding: 0;\r\n      text-align: center;\r\n    }\r\n    .email-footer p {\r\n      color: #AEAEAE;\r\n    }\r\n  \r\n    .content-cell {\r\n      padding: 35px;\r\n    }\r\n    .align-right {\r\n      text-align: right;\r\n    }\r\n\r\n    /* Type ------------------------------ */\r\n    h1 {\r\n      margin-top: 0;\r\n      color: #2F3133;\r\n      font-size: 19px;\r\n      font-weight: bold;\r\n      text-align: left;\r\n    }\r\n    h2 {\r\n      margin-top: 0;\r\n      color: #2F3133;\r\n      font-size: 16px;\r\n      font-weight: bold;\r\n      text-align: left;\r\n    }\r\n    h3 {\r\n      margin-top: 0;\r\n      color: #2F3133;\r\n      font-size: 14px;\r\n      font-weight: bold;\r\n      text-align: left;\r\n    }\r\n    p {\r\n      margin-top: 0;\r\n      color: #74787E;\r\n      font-size: 16px;\r\n      line-height: 1.5em;\r\n      text-align: left;\r\n    }\r\n    p.sub {\r\n      font-size: 12px;\r\n    }\r\n    p.center {\r\n      text-align: center;\r\n    }\r\n\r\n    /* Buttons ------------------------------ */\r\n    .button {\r\n      display: inline-block;\r\n      width: 200px;\r\n      background-color: #3869D4;\r\n      border-radius: 3px;\r\n      color: #ffffff;\r\n      font-size: 15px;\r\n      line-height: 45px;\r\n      text-align: center;\r\n      text-decoration: none;\r\n      -webkit-text-size-adjust: none;\r\n      mso-hide: all;\r\n    }\r\n    .button--green {\r\n      background-color: #22BC66;\r\n    }\r\n    .button--red {\r\n      background-color: #dc4d2f;\r\n    }\r\n    .button--blue {\r\n      background-color: #3869D4;\r\n    }\r\n  </style>\r\n</head>\r\n<body style=\"width: 100% !important;\r\n      height: 100%;\r\n      margin: 0;\r\n      line-height: 1.4;\r\n      background-color: #F2F4F6;\r\n      color: #74787E;\r\n      -webkit-text-size-adjust: none;\">\r\n  <table class=\"email-wrapper\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"\r\n    width: 100%;\r\n    margin: 0;\r\n    padding: 0;\">\r\n    <tbody><tr>\r\n      <td align=\"center\">\r\n        <table class=\"email-content\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"width: 100%;\r\n      margin: 0;\r\n      padding: 0;\">\r\n          <!-- Logo -->\r\n\r\n          <tbody>\r\n          <!-- Email Body -->\r\n          <tr>\r\n            <td class=\"email-body\" width=\"100%\" style=\"width: 100%;\r\n    margin: 0;\r\n    padding: 0;\r\n    border-top: 1px solid #edeef2;\r\n    border-bottom: 1px solid #edeef2;\r\n    background-color: #edeef2;\">\r\n              <table class=\"email-body_inner\" align=\"center\" width=\"570\" cellpadding=\"0\" cellspacing=\"0\" style=\" width: 570px;\r\n    margin:  14px auto;\r\n    background: #fff;\r\n    padding: 0;\r\n    border: 1px outset rgba(136, 131, 131, 0.26);\r\n    box-shadow: 0px 6px 38px rgb(0, 0, 0);\r\n       \">\r\n                <!-- Body content -->\r\n                <thead style=\"background: #3869d4;\"><tr><th><div align=\"center\" style=\"padding: 15px; color: #000;\"><a href=\"{var_action_url}\" class=\"email-masthead_name\" style=\"font-size: 16px;\r\n      font-weight: bold;\r\n      color: #bbbfc3;\r\n      text-decoration: none;\r\n      text-shadow: 0 1px 0 white;\">{var_sender_name}</a></div></th></tr>\r\n                </thead>\r\n                <tbody><tr>\r\n                  <td class=\"content-cell\" style=\"padding: 35px;\">\r\n                    <h1>Hi {var_user_name},</h1>\r\n                    <p>You recently requested to reset your password for your {var_website_name} account. Click the button below to reset it.</p>\r\n                    <!-- Action -->\r\n                    <table class=\"body-action\" align=\"center\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"\r\n      width: 100%;\r\n      margin: 30px auto;\r\n      padding: 0;\r\n      text-align: center;\">\r\n                      <tbody><tr>\r\n                        <td align=\"center\">\r\n                          <div>\r\n                            <!--[if mso]><v:roundrect xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:w=\"urn:schemas-microsoft-com:office:word\" href=\"{{var_action_url}}\" style=\"height:45px;v-text-anchor:middle;width:200px;\" arcsize=\"7%\" stroke=\"f\" fill=\"t\">\r\n                              <v:fill type=\"tile\" color=\"#dc4d2f\" />\r\n                              <w:anchorlock/>\r\n                              <center style=\"color:#ffffff;font-family:sans-serif;font-size:15px;\">Reset your password</center>\r\n                            </v:roundrect><![endif]-->\r\n                            <a href=\"{var_varification_link}\" class=\"button button--red\" style=\"background-color: #dc4d2f;display: inline-block;\r\n      width: 200px;\r\n      background-color: #3869D4;\r\n      border-radius: 3px;\r\n      color: #ffffff;\r\n      font-size: 15px;\r\n      line-height: 45px;\r\n      text-align: center;\r\n      text-decoration: none;\r\n      -webkit-text-size-adjust: none;\r\n      mso-hide: all;\">Reset your password</a>\r\n                          </div>\r\n                        </td>\r\n                      </tr>\r\n                    </tbody></table>\r\n                    <p>If you did not request a password reset, please ignore this email or reply to let us know.</p>\r\n                    <p>Thanks,<br>{var_sender_name} and the {var_website_name} Team</p>\r\n                   <!-- Sub copy -->\r\n                    <table class=\"body-sub\" style=\"margin-top: 25px;\r\n      padding-top: 25px;\r\n      border-top: 1px solid #EDEFF2;\">\r\n                      <tbody><tr>\r\n                        <td> \r\n                          <p class=\"sub\" style=\"font-size:12px;\">If you are having trouble clicking the password reset button, copy and paste the URL below into your web browser.</p>\r\n                          <p class=\"sub\"  style=\"font-size:12px;\"><a href=\"{var_varification_link}\">{var_varification_link}</a></p>\r\n                        </td>\r\n                      </tr>\r\n                    </tbody></table>\r\n                  </td>\r\n                </tr>\r\n              </tbody></table>\r\n            </td>\r\n          </tr>\r\n        </tbody></table>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n\r\n\r\n</body></html>'),
(2, 'users', 'invitation', 'Invitation', '<p>Hello <strong>{var_user_email}</strong></p>\r\n\r\n<p>Click below link to register&nbsp;<br />\r\n{var_inviation_link}</p>\r\n\r\n<p>Thanks&nbsp;</p>\r\n'),
(3, 'registration', 'registration', 'Registration', '<p>Hello <strong>{var_user_name}</strong></p>\r\n<p>Welcome to Notes&nbsp;<br />\r\n<p>To complete your registration&nbsp;<br /><br />\r\n<a href=\"{var_varification_link}\">please click here</a></p>\r\n\n<p>Thanks&nbsp;</p>');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `users_id` int(121) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `user_type` varchar(255) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `is_deleted` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `var_key` varchar(255) DEFAULT NULL,
  `create_date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`users_id`, `user_id`, `user_type`, `profile_pic`, `email`, `password`, `name`, `is_deleted`, `status`, `var_key`, `create_date`) VALUES
(1, '1', 'admin', 'demo_pic.png', 'admin@admin.com', '$2y$10$acaSvN6E2UvWQQSONq17.OGlFdY1RH9Q9wiIywjor0IzRMCH6.946', 'admin', '0', 'active', '', '2018-02-13'),
(2, '1', 'Userr', 'user.png', 'paul@test.com', '$2y$10$Mi99hcy7A5aLaveo0Hpy4.MtfaUXzHG3PeAX95MT/Ux/pCGJuu2Qy', 'Paul', '0', 'active', NULL, '2018-04-10');

-- --------------------------------------------------------

--
-- Table structure for table `wpb_c_modules`
--

CREATE TABLE `wpb_c_modules` (
  `id` int(122) UNSIGNED NOT NULL,
  `menu_name` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `module_name` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `wpb_extension`
--

CREATE TABLE `wpb_extension` (
  `extension_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `db_tables` varchar(250) DEFAULT NULL,
  `status` varchar(250) DEFAULT NULL,
  `inst_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rm_queries` longtext,
  `version` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `api_token`
--
ALTER TABLE `api_token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `atm_estate`
--
ALTER TABLE `atm_estate`
  ADD PRIMARY KEY (`atm_estate_id`);

--
-- Indexes for table `cf_values`
--
ALTER TABLE `cf_values`
  ADD PRIMARY KEY (`cf_values_id`);

--
-- Indexes for table `custom_fields`
--
ALTER TABLE `custom_fields`
  ADD PRIMARY KEY (`custom_fields_id`);

--
-- Indexes for table `engineer_details`
--
ALTER TABLE `engineer_details`
  ADD PRIMARY KEY (`engineer_details_id`);

--
-- Indexes for table `fault_calls`
--
ALTER TABLE `fault_calls`
  ADD PRIMARY KEY (`fault_calls_id`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`users_id`);

--
-- Indexes for table `wpb_c_modules`
--
ALTER TABLE `wpb_c_modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wpb_extension`
--
ALTER TABLE `wpb_extension`
  ADD PRIMARY KEY (`extension_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `api_token`
--
ALTER TABLE `api_token`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `atm_estate`
--
ALTER TABLE `atm_estate`
  MODIFY `atm_estate_id` int(121) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `cf_values`
--
ALTER TABLE `cf_values`
  MODIFY `cf_values_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `custom_fields`
--
ALTER TABLE `custom_fields`
  MODIFY `custom_fields_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `engineer_details`
--
ALTER TABLE `engineer_details`
  MODIFY `engineer_details_id` int(121) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `fault_calls`
--
ALTER TABLE `fault_calls`
  MODIFY `fault_calls_id` int(121) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(122) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(122) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `templates`
--
ALTER TABLE `templates`
  MODIFY `id` int(121) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `users_id` int(121) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `wpb_c_modules`
--
ALTER TABLE `wpb_c_modules`
  MODIFY `id` int(122) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wpb_extension`
--
ALTER TABLE `wpb_extension`
  MODIFY `extension_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
