
/* ==================== constants ==================== */
SET @tnow = NOW();
SET @tnl  = '0000-00-00 00:00:00';
SET @tns  = '0000-00-00';
SET @db   = DATABASE();

/* ==================== tables ==================== */

CREATE TABLE IF NOT EXISTS `#__pv_inspector_applicants` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `division_id` int(10) unsigned NOT NULL DEFAULT 0,
  `prefix` varchar(25) DEFAULT NULL,
  `first_name` varchar(40) NOT NULL DEFAULT '',
  `middle_name` varchar(40) DEFAULT NULL,
  `last_name` varchar(40) NOT NULL DEFAULT '',
  `suffix` varchar(25) DEFAULT NULL,
  `address1` varchar(100) NOT NULL DEFAULT '',
  `address2` varchar(100) DEFAULT NULL,
  `city` varchar(100) NOT NULL DEFAULT '',
  `region` varchar(100) NOT NULL DEFAULT '',
  `postcode` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `phone` varchar(100) NOT NULL DEFAULT '',
  `published` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `checked_out` int(10) unsigned NOT NULL DEFAULT 0,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `pv_inspector_applicants_division_id` (`division_id`),
  KEY `pv_inspector_applicants_person_id` (`person_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SAM DEFAULT CHARSET=utf8;
