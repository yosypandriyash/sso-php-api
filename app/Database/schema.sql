create database pcstate_accounts character set utf8 COLLATE utf8_general_ci;
use pcstate_accounts;

create table applications (
    id int auto_increment not null,
    unique_id varchar(96) unique not null,
    app_name varchar(64) not null,
    url varchar(96) not null,
    callback_url varchar(128) not null,
    api_key varchar(96) unique not null,

    created_at timestamp NOT NULL DEFAULT current_timestamp(),
    updated_at datetime DEFAULT NULL,
    deleted_at datetime DEFAULT NULL,

    PRIMARY KEY (id)
);

create table users(
    id int auto_increment not null,
    unique_id varchar(96) unique not null,
    user_name varchar(64) not null,
    full_name varchar(128) not null,
    email varchar(128) not null,
    password varchar(1024) not null,

    created_at timestamp NOT NULL DEFAULT current_timestamp(),
    updated_at datetime DEFAULT NULL,
    deleted_at datetime DEFAULT NULL,

    PRIMARY KEY (id)
);

create table user_password_reset_requests(
    id int auto_increment not null,
    user_id int not null,
    unique_id varchar(96) unique not null,
    origin_ip varchar(64) not null,
    is_active boolean not null default 1,
    expiration_date datetime not null,

    created_at timestamp NOT NULL DEFAULT current_timestamp(),
    updated_at datetime DEFAULT NULL,
    deleted_at datetime DEFAULT NULL,

    PRIMARY KEY (id),
    foreign key(user_id) references users(id) on delete cascade on update cascade
);

create table application_users(
    id int auto_increment not null,
    unique_id varchar(96) unique not null,
    application_id int not null,
    user_id int not null,

    created_at timestamp NOT NULL DEFAULT current_timestamp(),
    updated_at datetime DEFAULT NULL,
    deleted_at datetime DEFAULT NULL,

    PRIMARY KEY (id),
    foreign key(application_id) references applications(id) on delete cascade on update cascade,
    foreign key(user_id) references users(id) on delete cascade on update cascade
);

create table application_permissions (
    id int auto_increment not null,
    unique_id varchar(96) unique not null,
    permission_name varchar(64) not null,
    permission_description varchar(128),
    application_id int not null,
    is_active boolean not null default 1,

    created_at timestamp NOT NULL DEFAULT current_timestamp(),
    updated_at datetime DEFAULT NULL,
    deleted_at datetime DEFAULT NULL,

    PRIMARY KEY (id),
    foreign key(application_id) references applications(id) on delete cascade on update cascade
);

create table user_application_permissions (
     id int auto_increment not null,
     unique_id varchar(96) unique not null,
     user_id int not null,
     application_permission_id int not null,
     is_granted boolean not null default 1,

     created_at timestamp NOT NULL DEFAULT current_timestamp(),
     updated_at datetime DEFAULT NULL,
     deleted_at datetime DEFAULT NULL,

     PRIMARY KEY (id),
     foreign key(user_id) references users(id) on delete cascade on update cascade,
     foreign key(application_permission_id) references application_permissions(id) on delete cascade on update cascade
);