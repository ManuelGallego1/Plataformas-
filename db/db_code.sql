DROP DATABASE IF EXISTS ajcreativeStudios;     

CREATE DATABASE ajcreativeStudios;

USE ajcreativeStudios;

CREATE TABLE users(
    id int auto_increment,
    user varchar(200) UNIQUE,
    pass varchar(200),
    primary key(id)
);

CREATE TABLE servers(
    id int auto_increment,
    name varchar(100),
    user varchar(100),
    pass varchar(100),
    port int,
    primary key(id)
);

CREATE TABLE domains(
    id int auto_increment,
    url varchar(200),
    server int,
    primary key (id),
    foreign key (server) references servers(id)
);

CREATE TABLE socialwebs(
    id int auto_increment,
    name varchar(100),
    email varchar(100),
    pass varchar(100),
    primary key(id)
)

CREATE TABLE messages(
    id int auto_increment,
    content varchar(300),
    sender int,
    primary key (id),
    foreign key (sender) references users(id) 
);