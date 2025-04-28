CREATE TABLE user (
user_id INT,
email VARCHAR(24),
display_name VARCHAR(20),
first_name VARCHAR(200),
last_name VARCHAR(200),
status VARCHAR(20) DEFAULT 'Normal',
remark VARCHAR(400),
void TINYINT DEFAULT 0,
created_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
update_by VARCHAR(24) DEFAULT 'admin',
updated_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (user_id)
);

