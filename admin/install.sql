
/* ==================== constants ==================== */
SET @tnow = NOW();
SET @tnl  = '0000-00-00 00:00:00';
SET @tns  = '0000-00-00';
SET @db   = DATABASE();

/* ==================== tables ==================== */
CREATE TABLE IF NOT EXISTS `#__pv_addresses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `division_id` int(10) unsigned NOT NULL DEFAULT 0,
  `ordering` int(10) unsigned NOT NULL DEFAULT 0,
  `address1` varchar(100) NOT NULL DEFAULT '',
  `address2` varchar(100) DEFAULT NULL,
  `address3` varchar(100) DEFAULT NULL,
  `city` varchar(100) NOT NULL DEFAULT '',
  `region` varchar(100) NOT NULL DEFAULT '',
  `postcode` varchar(100) NOT NULL DEFAULT '',
  `lon` float(19,15) NOT NULL DEFAULT 0,
  `lat` float(19,15) NOT NULL DEFAULT 0,
  `published` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `checked_out` int(10) unsigned NOT NULL DEFAULT 0,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__pv_address_xrefs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `address_id` int(10) unsigned NOT NULL DEFAULT 0,
  `right_id` int(10) unsigned NOT NULL DEFAULT 0,
  `right_table_id` int(10) unsigned NOT NULL DEFAULT 0,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `pv_address_xrefs_address_id` (`address_id`),
  KEY `pv_address_xrefs_right_id` (`right_id`),
  KEY `pv_address_xrefs_right_table_id` (`right_table_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__pv_inspector_applicants` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `person_id` int(10) unsigned NOT NULL DEFAULT 0,
  `ward_id` int(10) unsigned NOT NULL DEFAULT 0,
  `division_id` int(10) unsigned NOT NULL DEFAULT 0,
  `ordering` int(10) unsigned NOT NULL DEFAULT 0,
  `published` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `checked_out` int(10) unsigned NOT NULL DEFAULT 0,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `pv_inspector_applicants_ward_id` (`ward_id`),
  KEY `pv_inspector_applicants_division_id` (`division_id`),
  KEY `pv_inspector_applicants_person_id` (`person_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__pv_link_types` (
  `id` tinyint(2) unsigned NOT NULL AUTO_INCREMENT,
  `ordering` int(10) unsigned NOT NULL DEFAULT 0,
  `limit` tinyint(2) DEFAULT 2 COMMENT '0 for no limit, 1 or greater for a specific limit',
  `name` varchar(100) NOT NULL DEFAULT '',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__pv_link_xrefs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `link_id` int(10) unsigned NOT NULL DEFAULT 0,
  `right_id` int(10) unsigned NOT NULL DEFAULT 0,
  `right_table_id` int(10) unsigned NOT NULL DEFAULT 0,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `pv_link_xrefs_link_id` (`link_id`),
  KEY `pv_link_xrefs_right_id` (`right_id`),
  KEY `pv_link_xrefs_right_table_id` (`right_table_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__pv_links` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_id` tinyint(2) unsigned NOT NULL DEFAULT 0,
  `ordering` int(10) unsigned NOT NULL DEFAULT 0,
  `value` varchar(255) NOT NULL DEFAULT '',
  `published` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `checked_out` int(10) unsigned NOT NULL DEFAULT 0,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `pv_links_type_id` (`type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__pv_persons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `party_id` int(10) unsigned NOT NULL DEFAULT 0,
  `ordering` int(10) unsigned NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `prefix` varchar(25) DEFAULT NULL,
  `first_name` varchar(40) NOT NULL DEFAULT '',
  `middle_name` varchar(40) DEFAULT NULL,
  `last_name` varchar(40) NOT NULL DEFAULT '',
  `suffix` varchar(25) DEFAULT NULL,
  `gender` char(1) DEFAULT NULL,
  `marital_status` char(1) DEFAULT NULL,
  `bio` text NOT NULL DEFAULT '',
  `published` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `checked_out` int(10) unsigned NOT NULL DEFAULT 0,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `pv_persons_party_id` (`party_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__pv_tables` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/* - Populate table  indexes- */
INSERT INTO `#__pv_tables` 
  SELECT 
  '' AS `id`, 
  TABLE_NAME AS `name`, 
  @tnow AS `created`, 
  @tnl AS `updated` 
  FROM information_schema.tables WHERE TABLE_SCHEMA=@db AND (TABLE_NAME LIKE "%division%" OR TABLE_NAME LIKE "%ward%" OR TABLE_NAME LIKE "%_pv_%") AND TABLE_NAME NOT LIKE "%_rt_%";
 
/* - Populate Link Types */
INSERT INTO `#__pv_link_types` VALUES
('', 3, 0, 'email', @tnow, @tnl),
('', 1, 0, 'phone', @tnow, @tnl),
('', 2, 0, 'fax', @tnow, @tnl),
('', 4, 1, 'accessible_coords', @tnow, @tnl),
('', 5, 1, 'voting_coords', @tnow, @tnl);
