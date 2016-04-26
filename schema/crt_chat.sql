CREATE TABLE chat (
    buyer_id NUMBER(16) NOT NULL,
    seller_id NUMBER(16) NOT NULL,
    start_date DATE NOT NULL,
    update_date DATE NOT NULL,
    PRIMARY KEY (buyer_id, seller_id),
    FOREIGN KEY (buyer_id) REFERENCES domer(user_id),
    FOREIGN KEY (seller_id) REFERENCES domer(user_id),
)
;
