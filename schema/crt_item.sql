CREATE TABLE item (
	item_id NUMBER(16) PRIMARY KEY,
	seller_id NUMBER(16) NOT NULL,
	name VARCHAR2(64) NOT NULL,
	condition INTEGER NOT NULL,
	description VARCHAR2(1024),
	price NUMBER(16) NOT NULL,
	end_time DATE,
	FOREIGN KEY (seller_id)	REFERENCES domer(user_id)
)
;
