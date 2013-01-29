DROP TABLE IF EXISTS migrations;

CREATE TABLE migrations (
  version_id  int NOT NULL,
  date_ran    datetime,
  /* Keys */
  PRIMARY KEY (version_id)
) ENGINE = InnoDB;

INSERT INTO migrations 
(version_id) 
VALUES (5)