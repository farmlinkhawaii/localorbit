DROP TABLE IF EXISTS migrations;

CREATE TABLE migrations (
  version_id    int NOT NULL,
  date_ran   timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  pt_number  int,
  /* Keys */
  PRIMARY KEY (version_id)
) ENGINE = InnoDB;


INSERT INTO migrations 
(version_id, pt_number)
VALUES
(4, 0);

