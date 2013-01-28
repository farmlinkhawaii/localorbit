drop table if exists domains_branding;
create table domains_branding (
  `branding_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `domain_id` int(10) unsigned NOT NULL,
  `header_font` int unsigned NOT NULL,
  `background_color` int(8) unsigned not null,
  `background_id` int unsigned null,
  `is_temp` tinyint not null,
  PRIMARY KEY (`branding_id`),    
  KEY `domains_branding_idx1` (`domain_id`) USING HASH
);

drop table if exists fonts;
create table fonts (
  `font_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `font_name` varchar(255) not null,
  PRIMARY KEY (`font_id`)
);

drop table if exists backgrounds;
create table backgrounds (
  `background_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) not null,
  `is_available` tinyint(1) not null,
  PRIMARY KEY (`background_id`)
);

insert into backgrounds (file_name, is_available) values ('broccoli.jpg', 1);
insert into backgrounds (file_name, is_available) values ('brownpaper.jpg', 1);
insert into backgrounds (file_name, is_available) values ('cherry-tomatoes.jpg', 1);
insert into backgrounds (file_name, is_available) values ('greens.jpg', 1);
insert into backgrounds (file_name, is_available) values ('painting.jpg', 1);
insert into backgrounds (file_name, is_available) values ('Peaches.jpg', 1);
insert into backgrounds (file_name, is_available) values ('Potatoes.jpg', 1);
insert into backgrounds (file_name, is_available) values ('Radishes.jpg', 1);
insert into backgrounds (file_name, is_available) values ('SungoldTomatoes.jpg', 1);
insert into backgrounds (file_name, is_available) values ('tomatoes.jpg', 1);

insert into fonts (font_name) values ('\'Droid Sans\', sans-serif');
insert into fonts (font_name) values ('\'Lato\', sans-serif');
insert into fonts (font_name) values ('\'Sorts Mill Goudy\', serif');
insert into fonts (font_name) values ('\'PT Sans Narrow\', sans-serif');
insert into fonts (font_name) values ('\'Oranienbaum\', serif');
insert into fonts (font_name) values ('\'Raleway\', sans-serif');
insert into fonts (font_name) values ('\'Open Sans Condensed\',\'Domine\', Georgia, \'Times New Roman\', Times, serif');
insert into fonts (font_name) values ('\'Voltaire\', sans-serif');
insert into fonts (font_name) values ('\'Port Lligat Slab\', serif');