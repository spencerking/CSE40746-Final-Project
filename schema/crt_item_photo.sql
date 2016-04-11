CREATE TABLE item_photo (
	item_id NUMBER(16) NOT NULL,
	filename VARCHAR(32) NOT NULL,
	description VARCHAR(128),
	FOREIGN KEY (item_id) REFERENCES item(item_id) ON DELETE CASCADE
)
;