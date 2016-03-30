CREATE TABLE tagged_item (
	item_id NUMBER(16) NOT NULL,
	tag_name VARCHAR(32) NOT NULL,
	FOREIGN KEY (item_id) REFERENCES item(item_id) ON DELETE CASCADE,
	FOREIGN KEY (tag_name) REFERENCES tag(tag_name) ON DELETE CASCADE
)
;
