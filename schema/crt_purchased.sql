CREATE TABLE purchased (
	user_id NUMBER(16) NOT NULL REFERENCES user(user_id),
	item_id NUMBER(16) NOT NULL REFERENCES item(item_id),
	purchased_date DATE NOT NULL
)
;
