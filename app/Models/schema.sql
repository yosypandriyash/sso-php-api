create database portfolio_dev character set utf8 COLLATE utf8_general_ci;
use portfolio_dev;

create table if not exists users (
    id int auto_increment primary key,
    unique_id varchar(96) unique,

    full_name varchar(128) not null,
    email varchar(128) unique not null,
    password varchar(1024) not null,
    phone_number varchar(32) default null
) ENGINE=INNODB DEFAULT CHARSET=UTF8 AUTO_INCREMENT=1;

create table if not exists user_registration_verification (
    id int auto_increment primary key,
    user_id int not null,

    user_verified boolean not null default 0,

    verification_code varchar(32) not null,
    verification_code_token varchar(64) not null,
    verification_code_expiration_date datetime not null,
    verification_code_client_ip varchar(64) not null,

    created_at timestamp default current_timestamp,
    updated_at datetime default null,
    deleted_at datetime default null,
    foreign key(user_id) references users(id) on delete cascade on update cascade

) ENGINE=INNODB DEFAULT CHARSET=UTF8 AUTO_INCREMENT=1;

create table if not exists user_registration_verification_attempts (
    id int auto_increment primary key,
    user_registration_verification_id int not null,

    verification_attempt_code varchar(32) not null,
    verification_attempt_client_ip varchar(64) not null,

    created_at timestamp default current_timestamp,
    updated_at datetime default null,
    deleted_at datetime default null,
    foreign key(user_registration_verification_id) references user_registration_verification(id) on delete cascade on update cascade

) ENGINE=INNODB DEFAULT CHARSET=UTF8 AUTO_INCREMENT=1;

