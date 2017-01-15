CREATE DATABASE IF NOT EXISTS stevensdotinstitute;


USE stevensdotinstitute;


CREATE TABLE IF NOT EXISTS Boards (
	`id`                 UNSIGNED INTEGER NOT NULL AUTO_INCREMENT,
	`abbreviation`       VARCHAR(3)       NOT NULL,
	`title`              VARCHAR(16)      NOT NULL,
	`description`        VARCHAR(256)     NOT NULL,

	`creation_datetime`  DATETIME         NOT NULL DEFAULT NOW(),
	`published_status`   BOOLEAN          NOT NULL DEFAULT 0,
	`published_datetime` DATETIME,
	`new_branding`       BOOLEAN          NOT NULL DEFAULT 1,

	PRIMARY KEY (id)
);


CREATE TABLE IF NOT EXISTS Threads (
	`board_id` UNSIGNED INTEGER NOT NULL,
	`op_id`    UNSIGNED INTEGER NOT NULL,
	`title`    VARCHAR(64),

	PRIMARY KEY (board_id, id),
	FOREIGN KEY (board_id) REFERENCES Boards(id) ON DELETE CASCADE,
	FOREIGN KEY (op_id)    REFERENCES Posts(id)  ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS Posts (
	`board_id`          UNSIGNED INTEGER NOT NULL,
	`thread_id`         UNSIGNED INTEGER NOT NULL,
	`id`                UNSIGNED INTEGER NOT NULL AUTO_INCREMENT,

	`creation_datetime` DATETIME         NOT NULL DEFAULT NOW(),
	`ip_address_hash`   BINARY(60)       NOT NULL,

	`name`              VARCHAR(32),
	`comment`           TEXT,
	`file_id`           UNSIGNED INTEGER,

	PRIMARY KEY (board_id, thread_id, id),
	FOREIGN KEY (board_id)  REFERENCES Boards(id)  ON DELETE CASCADE,
	FOREIGN KEY (thread_id) REFERENCES Threads(id) ON DELETE CASCADE,
	FOREIGN KEY (file_id)   REFERENCES Files(id)   ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS Files (
	`id`                UNSIGNED INTEGER NOT NULL AUTO_INCREMENT,

	`creation_datetime` DATETIME         NOT NULL DEFAULT NOW(),
	`ip_address_hash`   BINARY(60)       NOT NULL,
	`poster_name`       VARCHAR(32),

	`size`              UNSIGNED INTEGER NOT NULL,
	`hash`              BINARY(32)       NOT NULL,
	`mime_type`         VARCHAR(255)     NOT NULL,
	`content`           MEDIUMBLOB       NOT NULL
);
