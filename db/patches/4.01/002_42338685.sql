create table domains_branding (
  `branding_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `domain_id` int(10) unsigned NOT NULL,
  `font_color` int(8) unsigned NOT NULL,
  `header_font` int unsigned NOT NULL,
  `background_color` int(8) unsigned not null,
  `background_id` int unsigned not null,
  `is_temp` tinyint not null,
  PRIMARY KEY (`branding_id`),    
  KEY `domains_branding_idx1` (`domain_id`) USING HASH
);