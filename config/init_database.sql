CREATE DATABASE IF NOT EXISTS stevensdotinstitute;


USE stevensdotinstitute;


CREATE TABLE IF NOT EXISTS Boards (
	id                  INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	abbreviation        VARCHAR(3)       NOT NULL,
	title               VARCHAR(16)      NOT NULL,
	description         VARCHAR(256)     NOT NULL,

	creation_timestamp  TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP,
	published_status    BOOLEAN          NOT NULL DEFAULT 0,
	published_timestamp TIMESTAMP,
	new_branding        BOOLEAN          NOT NULL DEFAULT 1,

	PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=0;


INSERT INTO Boards
	(abbreviation, title, description, published_status)
VALUES
	("g", "technology", "vim vs. emacs flame wars", 1),
	("a", "anime",      "weeb shit",                1);


CREATE TABLE IF NOT EXISTS Posts (
	board_id           INTEGER UNSIGNED NOT NULL,
	id                 INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	parent_id          INTEGER UNSIGNED DEFAULT NULL,

	creation_timestamp TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP,
	ip_address_hash    BINARY(60)       NOT NULL,

	name               VARCHAR(32) DEFAULT 'Anonymous',
	comment            TEXT,
	file_id            INTEGER UNSIGNED,

	PRIMARY KEY (board_id, id),
	FOREIGN KEY (board_id)  REFERENCES Boards(id) ON DELETE CASCADE,
	FOREIGN KEY (parent_id) REFERENCES Posts(id)  ON DELETE CASCADE,
	FOREIGN KEY (file_id)   REFERENCES Files(id)  ON DELETE CASCADE
) ENGINE=MyISAM AUTO_INCREMENT=0;


CREATE TABLE IF NOT EXISTS Files (
	id                 INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,

	creation_timestamp TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP,
	ip_address_hash    BINARY(60)       NOT NULL,
	poster_name        VARCHAR(32),

	size               INTEGER UNSIGNED NOT NULL,
	hash               BINARY(32)       NOT NULL,
	mime_type          VARCHAR(255)     NOT NULL,
	extension          VARCHAR(255)     NOT NULL,
	content            MEDIUMBLOB       NOT NULL,

	PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=0;
