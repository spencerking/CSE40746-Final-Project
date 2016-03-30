CREATE TABLE item_photo (
	item_id NUMBER(16) NOT NULL REFERENCES item(item_id),
	filename VARCHAR(32) NOT NULL,
	description VARCHAR(128)
)
;
