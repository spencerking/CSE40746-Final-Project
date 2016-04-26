CREATE TABLE message (
    buyer_id NUMBER(16) NOT NULL,
    seller_id NUMBER(16) NOT NULL,
    user_id NUMBER(16) NOT NULL,
    message_date DATE NOT NULL,
    message_text VARCHAR(1024) NOT NULL,
    PRIMARY KEY (buyer_id, seller_id, message_date),
    FOREIGN KEY (user_id) REFERENCES domer(user_id)
)
;
