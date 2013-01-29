DROP TABLE IF EXISTS migrations;

CREATE TABLE migrations (
  version_id  varchar(10) NOT NULL,
  date_ran    datetime,
  /* Keys */
  PRIMARY KEY (version_id)
) ENGINE = InnoDB;

INSERT INTO migrations (version_id) 
VALUES ('005')