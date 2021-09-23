create database ec default character set utf8;
use ec;

create table users(
    id int auto_increment primary key,
    name varchar(255) not null,
    email varchar(255) not null unique,
    password varchar(255) not null,
    admin_flag int not null,
    created_at timestamp default CURRENT_TIMESTAMP,
    updated_at timestamp
);

create table items(
    id int auto_increment primary key,
    user_id int not null,
    name varchar(255) not null,
    content varchar(255) not null,
    price int not null,
    stock int not null,
    image varchar(255) not null,
    status_flag int not null,
    created_at timestamp default CURRENT_TIMESTAMP,
    updated_at timestamp,
    foreign key(user_id) references users(id)
    on delete cascade
    on update cascade
);