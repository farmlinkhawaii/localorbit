CREATE TABLE migrations (
  version    int NOT NULL,
  date_ran   timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  pt_number  int,
  /* Keys */
  PRIMARY KEY (version)
) ENGINE = InnoDB;


INSERT INTO migrations 
(version, pt_number)
VALUES
(4, 0);


