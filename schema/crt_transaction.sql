CREATE TABLE transaction (
	transaction_id NUMBER(16) NOT NUll,
	buyer_id NUMBER(16) NOT NULL REFERENCES user(user_id),
	seller_id NUMBER(16) NOT NULL REFERENCES user(user_id),
	transaction_date DATE NOT NULL,
	status NUMBER(1) NOT NULL
)
;
