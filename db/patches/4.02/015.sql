INSERT INTO migrations (version_id, pt_ticket_no) 
VALUES ('015', '42367377');

alter table newsletter_content add column is_draft tinyint not null;delimiter $$

CREATE TABLE `organizations` (
  `org_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `parent_org_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `profile` text,
  `buyer_type` enum('Wholesale','Retail') DEFAULT NULL,
  `allow_sell` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '0',
  `is_enabled` tinyint(1) DEFAULT '1',
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `activation_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `public_profile` tinyint(1) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `product_how` text,
  `payment_allow_purchaseorder` int(11) DEFAULT '0',
  `payment_allow_paypal` int(11) DEFAULT '0',
  `is_deleted` tinyint(4) DEFAULT '0',
  `payment_entity_id` int(10) unsigned NOT NULL,
  `po_due_within_days` int(11) NOT NULL DEFAULT '7',
  `social_option_id` tinyint(4) DEFAULT NULL,
  `opm_id` bigint(20) DEFAULT '0',
  `payment_allow_ach` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`org_id`),
  KEY `organizations_idx2` (`is_active`) USING HASH,
  KEY `organizations_idx1` (`is_enabled`) USING HASH
) ENGINE=MyISAM AUTO_INCREMENT=1360 DEFAULT CHARSET=latin1$$

