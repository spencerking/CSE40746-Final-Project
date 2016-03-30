CREATE TABLE transaction (
	transaction_id NUMBER(16) PRIMARY KEY,
	buyer_id NUMBER(16) NOT NULL FOREIGN KEY REFERENCES user(user_id),
	seller_id NUMBER(16) NOT NULL FOREIGN KEY REFERENCES user(user_id),
	transaction_date DATE NOT NULL,
	status NUMBER(1) NOT NULL
)
;
