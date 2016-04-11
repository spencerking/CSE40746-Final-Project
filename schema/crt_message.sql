CREATE TABLE message {
    chat_id NUMBER(16) NOT NULL,
    user_id NUMBER(16) NOT NULL,
    message_date DATE NOT NULL,
    message_text VARCHAR(140) NOT NULL,
    FOREIGN KEY (chat_id) REFERENCES chat(chat_id),
    FOREIGN KEY (user_id) REFERENCES domer(user_id)
}
;