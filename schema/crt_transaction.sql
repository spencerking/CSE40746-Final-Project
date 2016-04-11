CREATE TABLE transaction (
	transaction_id NUMBER(16) PRIMARY KEY,
	buyer_id NUMBER(16) NOT NULL,
	seller_id NUMBER(16) NOT NULL,
	item_id NUMBER(16) NOT NULL,
	transaction_date DATE NOT NULL,
	status NUMBER(1) NOT NULL,
	FOREIGN KEY (buyer_id) REFERENCES domer(user_id),
	FOREIGN KEY (seller_id) REFERENCES domer(user_id),
	FOREIGN KEY (item_id) REFERENCES item(item_id) ON DELETE CASCADE
)
;