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

create table chat_group (
group_id INT,
group_name1 VARCHAR(200) DEFAULT '',
group_name2 VARCHAR(200) DEFAULT '',
group_name3 VARCHAR(200) DEFAULT '', 
b_color1  VARCHAR(30) DEFAULT '#FFFFFF',
b_color2  VARCHAR(30) DEFAULT '',
b_color3  VARCHAR(30) DEFAULT '',
f_color1  VARCHAR(30) DEFAULT '#000000',
f_color2  VARCHAR(30) DEFAULT '',
f_color3  VARCHAR(30) DEFAULT '',
void TINYINT DEFAULT 0,
created_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
update_by VARCHAR(24) DEFAULT 'admin',
updated_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (group_id)
);

create table participate (
part_id INT,
user_id INT,
group_id INT,
void TINYINT DEFAULT 0,
created_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
update_by VARCHAR(24) DEFAULT 'admin',
updated_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY(part_id)
);

create table message (
message_id BIGINT,
group_id INT,
sender_email VARCHAR(24),
message_text VARCHAR(10000),
void TINYINT DEFAULT 0,
created_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
update_by VARCHAR(24) DEFAULT 'admin',
updated_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (message_id)
);

create table user_avatar (
avatar_id BIGINT,
email VARCHAR(24),
location VARCHAR(400),
void TINYINT DEFAULT 0,
created_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
update_by VARCHAR(24) DEFAULT 'admin',
updated_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (avatar_id)
);





