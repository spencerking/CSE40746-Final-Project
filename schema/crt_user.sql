CREATE TABLE user (
	user_id NUMBER(16) PRIMARY KEY,
	password_hash BINARY(64) NOT NULL,
	email VARCHAR2(64) NOT NULL
)
;
