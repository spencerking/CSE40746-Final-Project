CREATE TABLE favorite (
	user_id NUMBER(16) NOT NULL,
	item_id NUMBER(16) NOT NULL,
	status NUMBER(1) NOT NULL,
	FOREIGN KEY (user_id) REFERENCES domer(user_id) ON DELETE CASCADE,
	FOREIGN KEY (item_id) REFERENCES item(item_id) ON DELETE CASCADE
)
;
